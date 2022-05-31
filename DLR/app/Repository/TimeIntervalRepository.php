<?php

namespace App\Repository;

use App\Models\TimeInterval;


class TimeIntervalRepository
{
    public static function getTimeInterval()
    {
        $time_interval = TimeInterval::table('time_interval')
            ->get()
            ->first();

        return $time_interval->time_interval;
    }
}
