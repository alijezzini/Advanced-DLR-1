<?php

namespace App\Repository;

use App\Models\Message;
use DateTime;
use Illuminate\Support\Facades\DB;

class MessageRepository
{
    public static function getMessageById(string $message_id)
    {
        $message = DB::table('messages')
            ->where('terminator_message_id', '=', $message_id)
            ->get();

        return $message;
    }

    public static function updateMessageStatus(string $message_id, string $status)
    {
        DB::table('messages')
            ->where('message_id', '=', $message_id)
            ->update(['status' => $status]);
    }

    public static function updateDeliveryStatus(string $id, string $delivery_status)
    {
        DB::table('messages')
            ->where('terminator_message_id', '=', $id)
            ->update(['delivery_status' => $delivery_status]);
    }

    public static function getReceivedTime()
    {
    }

    public static function getTimeInterval()
    {
        $time_interval = DB::table('time_interval')->get();

        return $time_interval[0]->time_interval;
    }

    public static function updateMessage(Message $message)
    {
        DB::table('messages')
            ->where('id', '=', $message->id)
            ->update(['fake' => $message->fake]);
    }
}
