<?php

namespace Source\Model;

use DateInterval;
use DateTime;
use Exception;
use Source\Exception\AppException;

class WorkingHours extends Model
{
    protected static $entity = 'working_hours';
    protected static $columns = [
        'primary' => 'id',
        'require' => ['user', 'work_date', 'worked_time'],
        'timestamp' => true,
    ];

    public function user()
    {
        return User::find(['id' => $this->user]);
    }

    public static function getAbsentUsers()
    {
        $today = (new DateTime())->format('Y-m-d');

        $absentUsers = User::fetch([
            'sql_raw' =>
            "is_active = 1 
            AND id not in (
                select user from working_hours
                where work_date = '{$today}'
                and time1 is not null
            )"
        ]);
        
        return $absentUsers;
    }

    public static function getMonthlyReport(int|string $user, string|DateTime $date)
    {
        $report = [];

        $date = dateAsDateTime($date);
        
        $firstDate = $date->modify('first day of this month')->format('Y-m-d');
        $lastDate = $date->modify('last day of this month')->format('Y-m-d');
        
        $result = static::fetch([
            'user' => $user,
            'sql_raw' => "work_date between '{$firstDate}' AND '{$lastDate}'"
        ]);
        
        if ($result)
            foreach ($result as $working_hours)
                $report[$working_hours->work_date] = $working_hours;

        return $report;
    }

    public static function getWorkedTimeInMonth(string|DateTime $date)
    {
        $date = dateAsDateTime($date);

        $firstDate = $date->modify('first day of this month')->format('Y-m-d');
        $lastDate = $date->modify('last day of this month')->format('Y-m-d');

        return static::find([
            'sql_raw' => "work_date between '{$firstDate}' and '{$lastDate}'",
        ], 'sum(worked_time) as sumOfWorkedTime')->sumOfWorkedTime;
    }

    public static function workingHours($user, string $work_date): WorkingHours
    {
        $working_hours = self::find(['user' => $user, 'work_date' => $work_date]);

        if (!$working_hours) {

            $working_hours = new WorkingHours([
                'user' => $user,
                'work_date' => $work_date,
                'worked_time' => 0
            ]);
        }

        return $working_hours;
    }

    private function getNextTime(): ?string
    {
        if (!isset($this->time1)) return 'time1';
        if (!isset($this->time2)) return 'time2';
        if (!isset($this->time3)) return 'time3';
        if (!isset($this->time4)) return 'time4';
        return null;
    }

    private function getTimeAsDateTime(): array
    {
        try {
            isset($this->time1) ? $times[] = new DateTime($this->time1) : $times[] = null;
            isset($this->time2) ? $times[] = new DateTime($this->time2) : $times[] = null;
            isset($this->time3) ? $times[] = new DateTime($this->time3) : $times[] = null;
            isset($this->time4) ? $times[] = new DateTime($this->time4) : $times[] = null;
            return $times;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function toClockIn(string $time): void
    {
        // if (!preg_match('/[0-9]{2}[:]{1}[0-9]{2}[:]{1}[0-9]{2}/', $time))
        // { throw new AppException('error'); }

        $next_time = $this->getNextTime();
        $times = $this->getTimeAsDateTime();

        foreach ($times as $times_time)
        {
            if ($times_time)
            {
                if (isBeforeThatDate($time, $times_time))
                {
                    throw new AppException('Ponto inválido. Informe um horário à frente do último ponto.');

                    return;
                }
            }
        }

        if (!$next_time) {

            throw new AppException('Limite de pontos por dia alcançados.');

            return;
        }

        $this->$next_time = $time;
        $this->worked_time = getSecondsFromDateInterval($this->workedHours());

        parent::save();
    }

    public function workedHours(): DateInterval
    {
        [$time1, $time2, $time3, $time4] = $this->getTimeAsDateTime();

        $part1 = new DateInterval('PT0S');
        $part2 = new DateInterval('PT0S');


        if (isset($time1)) $part1 = $time1->diff(new DateTime());
        if (isset($time2)) $part1 = $time1->diff($time2);
        if (isset($time3)) $part2 = $time3->diff(new DateTime());
        if (isset($time4)) $part2 = $time3->diff($time4);

        return sumInterval($part1, $part2);
    }

    public function breakHours(): DateInterval
    {
        [, $time2, $time3,] = $this->getTimeAsDateTime();

        $breakHours = new DateInterval('PT0S');

        if (isset($time2)) $breakHours = $time2->diff(new DateTime());
        if (isset($time3)) $breakHours = $time2->diff($time3);

        return $breakHours;
    }

    public function exitTime(): DateTime
    {
        [$time1, , , $time4] = $this->getTimeAsDateTime();

        $full_working_hours = new DateInterval('PT8H');

        if (!$time1) return (new DateTime())->add($full_working_hours);
        if ($time4) return $time4;
        
        $total = sumInterval($full_working_hours, $this->breakHours());
        return $time1->add($total);
    }

    public function getActiveClock(): ?string
    {
        $next_time = $this->getNextTime();

        if ($next_time === 'time1') {

            return 'exit_time';

        } elseif ($next_time === 'time3') {

            return 'break_and_exit';

        } elseif ($next_time === 'time2' || $next_time === 'time4') {

            return 'worked_time';

        }

        return null;
    }
}
