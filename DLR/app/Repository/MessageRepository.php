<?php

namespace App\Repository;

use App\Models\Message;
use App\Models\Destination;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessageRepository
{
    public static function getSourceBySenderId(string $sender_id)
    {
        $source_sender_id = DB::table('sources')

            ->where('sender_id', '=', $sender_id)

            ->get();

        return $source_sender_id;
    }

    public static function getSenderDestination(string $sender_id, string $destination)
    {
        $sender_id_destination = DB::table('destination')

            ->where('sender_id', '=', $sender_id)

            ->where('destination', '=', $destination)

            ->get();

        return $sender_id_destination;
    }

    public static function getReceivedTime()
    {
    }

    public function getTimeInterval(): DateTime
    {
        $time_interval = DB::table('time_interval');

        return $time_interval->time_interval;
    }
}
