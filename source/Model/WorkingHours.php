<?php

namespace Source\Model;

use DateInterval;
use DateTime;
use Exception;

class WorkingHours extends Model
{
    protected static $entity = 'working_hours';
    protected static $columns = [
        'primary' => 'id',
        'require' => ['user_id', 'work_date', 'worked_time'],
        'timestamp' => false,
    ];

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

    private function getTimeHowDateTime(): array
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
        $next_time = $this->getNextTime();

        if (!$next_time) {

            setMessage(['exceeded_to_clock_in' => 'Limite de pontos por dia alcançados.']);

            return;
        }

        $this->$next_time = $time;

        parent::save();
    }

    public function workedHours(): DateInterval
    {
        [$time1, $time2, $time3, $time4] = $this->getTimeHowDateTime();

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
        [, $time2, $time3,] = $this->getTimeHowDateTime();

        $breakHours = new DateInterval('PT0S');

        if (isset($time2)) $breakHours = $time2->diff(new DateTime());
        if (isset($time3)) $breakHours = $time2->diff($time3);

        return $breakHours;
    }

    public function exitTime(): DateTime
    {
        [$time1, , , $time4] = $this->getTimeHowDateTime();

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
