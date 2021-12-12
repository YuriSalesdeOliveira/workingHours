<?php

use Source\Exception\AppException;
use Source\Model\User;
use Source\Model\WorkingHours;

function getPreviousFiveYearsThatDate(string|DateTime $date): array
{
    $date = dateAsDateTime($date);

    $previous_five_years = [];

    for ($number_of_years = 5; $number_of_years !== 0; --$number_of_years)
    {
        array_push($previous_five_years, $date->format('Y'));
        
        $date = $date->modify('-1 year');
    }

    return $previous_five_years;
}

function getPreviousMonthsThatDate(string|DateTime $date): array
{
    $date = dateAsDateTime($date);

    $filtered_months = [];

    $months = [
        '1' => 'january',
        '2' => 'february',
        '3' => 'march',
        '4' => 'april',
        '5' => 'may',
        '6' => 'june',
        '7' => 'july',
        '8' => 'august',
        '9' => 'september',
        '10' => 'october',
        '11' => 'november',
        '12' => 'december'
    ];

    foreach ($months as $number => $month) {
        
        $filtered_months[$number] = $month;

        if ($number == $date->format('m')) return $filtered_months;
    }
}

function dateAsDateTime(string|DateTime $date): DateTime
{
    return is_string($date) ? new DateTime($date) : $date;
}

function isWeekend(string|DateTime $date): bool
{
    $date = dateAsDateTime($date);
    return $date->format('N') > 5;
}

function isBeforeThatDate(string|DateTime $isBefore, string|DateTime $thatDate): bool
{
    $isBefore = dateAsDateTime($isBefore);
    $thatDate =dateAsDateTime($thatDate);
    return $isBefore < $thatDate;
}

function sumInterval(DateInterval $interval1, DateInterval $interval2): DateInterval
{
    $date = new DateTime('00:00:00');

    $date->add($interval1);
    $date->add($interval2);

    return (new DateTime('00:00:00'))->diff($date);
}

function convertDateIntervalToDateTime(DateInterval $interval): DateTime
{
    return new DateTime($interval->format('%H:%i:%s'));
}

function getDayTemplateByOdds(int $regularRate, int $extraRate, int $lazyRate): array
{
    $regularDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '14:00:00',
        'time4' => '18:00:00',
        'worked_time' => '08:00:00'
    ];

    $extraHourDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '14:00:00',
        'time4' => '19:00:00',
        'worked_time' => '09:00:00'
    ];

    $lazyDayTemplate = [
        'time1' => '08:30:00',
        'time2' => '12:00:00',
        'time3' => '14:00:00',
        'time4' => '18:00:00',
        'worked_time' => '07:30:00'
    ];

    $randNumber = rand(0, 100);

    if ($randNumber <= $regularRate) return $regularDayTemplate;
    if ($randNumber <= $regularRate + $extraRate) return $extraHourDayTemplate;
    if ($randNumber <= $regularRate + $extraRate + $lazyRate) return $lazyDayTemplate;
}

function populateWorkingHours(int|string $user, string|DateTime $initialDate, int $regularRate, int $extraRate, int $lazyRate)
{
    $work_date = dateAsDateTime($initialDate);

    if (!$user = User::find(['id' => $user]))
        throw new AppException('Usuário não existe na base de dados');

    // WorkingHours::delete([]);

    while (isBeforeThatDate($work_date, (new DateTime())->modify('-1 day'))) {

        $day_template = getDayTemplateByOdds($regularRate, $extraRate, $lazyRate);

        $working_hours = new WorkingHours();

        $working_hours->user = $user->id;
        $working_hours->work_date = $work_date->format('Y-m-d');
        $working_hours->time1 = $day_template['time1'];
        $working_hours->time2 = $day_template['time2'];
        $working_hours->time3 = $day_template['time3'];
        $working_hours->time4 = $day_template['time4'];
        $working_hours->worked_time = $day_template['worked_time'];

        $working_hours->save();

        $work_date = $work_date->modify('+1 day');
    }
}