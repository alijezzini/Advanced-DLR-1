<?php

namespace App\Repository;

use App\Models\Message;
use DateTime;
use Illuminate\Support\Facades\DB;

class MessageRepository
{
    public static function getMessageById(string $message_id)
    {
        $message = DB::table('messages')->where('terminator_message_id', '=', $message_id)

            ->get();

        return $message;
    }

    public static function updateMessageStatus(string $message_id, string $status)
    {
        $update_message = DB::table('messages')
            ->where('message_id', '=', $message_id)
            ->update(['status' => $status]);
    }

    public static function updateDeliveryStatus(string $message_id, string $delivery_status)
    {
        $update_delivery_status = DB::table('message')
            ->where('message_id', '=', $message_id)
            ->update(['delivery_status' => $delivery_status]);
    }

    public static function getReceivedTime()
    {
    }

    public static function getTimeInterval(): DateTime
    {
        $time_interval = DB::table('time_interval');

        return $time_interval->time_interval;
    }

    public static function updateMessage(Message $message)
    {
        $update_delivery_status = DB::table('message')
            ->where('message_id', '=', $message->message_id)
            ->update(['fake' => $message->fake]);
    }
}
