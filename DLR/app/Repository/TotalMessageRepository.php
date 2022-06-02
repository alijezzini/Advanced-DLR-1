<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class TotalMessageRepository
{
    // Case 1
    public static function getAllMessages()
    {
        $message = DB::table('messages')
            ->get();


        return $message;
    }
    public static function getYearMonthDay(
        string|null $year,
        string|null $month,
        string|null $day
    )

    // Case 2
    {
        $message = DB::table('messages')
            ->whereYear('date_received', $year)
            ->whereMonth('date_received', '=', $month)
            ->whereDay('date_received', '=', $day)
            ->get();

        return $message;
    }

    // Case 3
    public static function getYearMonth(
        string|null $year,
        string|null $month,
    ) {
        $message = DB::table('messages')
            ->whereYear('date_received', $year)
            ->whereMonth('date_received', '=', $month)
            ->get();

        return $message;
    }

    // Case 4
    public static function getYear(
        string|null $year,
    ) {
        $message = DB::table('messages')
            ->whereYear('date_received', $year)
            ->get();

        return $message;
    }
        // total of senders
        public static function getSender(
            string|null $sender,
        ) {
            $message = DB::table('messages')
               ->where('sender_id', $sender)
                ->get();
    
            return $message;
        }
}
