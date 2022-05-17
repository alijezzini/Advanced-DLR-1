<?php

namespace App\Repository;


use DateTime;
use Illuminate\Support\Facades\DB;

class MessageRepository
{
    public static function getMessageById(int $message_id)
    {
        $message = DB::table('messages')->where('terminator_message_id', '=', $message_id)

            ->get();

        return $message;
    }

    public static function updateMessageStatus(int $message_id, string $status)
    {
        $update_message = DB::table('messages')
            ->where('terminator_message_id', '=', $message_id)
            ->update(['messages.status' => $status]);
    }

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

    public static function getTimeInterval(): DateTime
    {
        $time_interval = DB::table('time_interval');

        return $time_interval->time_interval;
    }
}
