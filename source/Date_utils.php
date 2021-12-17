<?php

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

function getSecondsFromDateInterval(DateInterval $interval): int
{
    $date = new DateTimeImmutable();
    $newDate = $date->add($interval);

    return $newDate->getTimestamp() - $date->getTimestamp();
}

function secondsAsStringTime(string|int $seconds): string
{
    $hours = str_pad(intdiv($seconds, 3600), 2, 0, STR_PAD_LEFT);
    $minutes = str_pad(intdiv($seconds % 3600, 60), 2, 0, STR_PAD_LEFT);
    $seconds = str_pad($seconds - ($hours * 3600) - ($minutes * 60), 2, 0, STR_PAD_LEFT);

    return "{$hours}:{$minutes}:{$seconds}";
}

function getDayTemplateByOdds(int $regularRate, int $extraRate, int $lazyRate): array
{
    $regularDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '14:00:00',
        'time4' => '18:00:00',
        'worked_time' => DAILY_TIME
    ];

    $extraHourDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '14:00:00',
        'time4' => '19:00:00',
        'worked_time' => DAILY_TIME + 3600
    ];

    $lazyDayTemplate = [
        'time1' => '08:30:00',
        'time2' => '12:00:00',
        'time3' => '14:00:00',
        'time4' => '18:00:00',
        'worked_time' => DAILY_TIME + 1800
    ];

    $randNumber = rand(0, 100);

    if ($randNumber <= $regularRate) return $regularDayTemplate;
    if ($randNumber <= $regularRate + $extraRate) return $extraHourDayTemplate;
    if ($randNumber <= $regularRate + $extraRate + $lazyRate) return $lazyDayTemplate;
}
// Mudar o nome dessa função
function generateWorkingHours(int|string $user, string|DateTime $initialDate, int $regularRate, int $extraRate, int $lazyRate)
{
    $data = [];

    $work_date = dateAsDateTime($initialDate);

    while (isBeforeThatDate($work_date, (new DateTime())->modify('-1 day'))) {

        if (!isWeekend($work_date)) {

            $day_template = getDayTemplateByOdds($regularRate, $extraRate, $lazyRate);

            $data[] = [
                'user' => $user,
                'work_date' => $work_date->format('Y-m-d'),
                'time1' => $day_template['time1'],
                'time2' => $day_template['time2'],
                'time3' => $day_template['time3'],
                'time4' => $day_template['time4'],
                'worked_time' => $day_template['worked_time']
            ];
        }

        $work_date = $work_date->modify('+1 day');
    }

    return $data;
}