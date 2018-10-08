<?php

namespace View;

class DateTimeView
{

    public function dateTime(): string
    {
        date_default_timezone_set('Europe/Stockholm');
        $day = date('l');
        $dayOfMonth = date('jS');
        $month = date('F');
        $year = date('Y');
        $currentTime = date('H:i:s');

        return "<p> {$day}, the {$dayOfMonth} of {$month} {$year}, The time is {$currentTime} </p>";
    }
}
