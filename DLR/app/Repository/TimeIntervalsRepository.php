<?php

namespace App\Repository;

use App\Models\TimeInterval;
use Illuminate\Support\Facades\DB;

class TimeIntervalsRepository
{
    public static function getTimeInterval()
    {
        $time_interval = DB::table('time_intervals')
            ->get()
            ->first();

        return $time_interval->time_interval;
    }
}
