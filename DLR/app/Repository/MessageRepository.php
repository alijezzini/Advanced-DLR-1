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

    public static function updateStatus(string $message_id, string $status)
    {
        DB::table('messages')
            ->where('message_id', '=', $message_id)
            ->update(['status' => $status]);
    }

    public static function updateDeliveryStatus(Message $message)
    {
        DB::table('messages')
            ->where('terminator_message_id', '=', $message->id)
            ->update(['delivery_status' => $message->delivery_status]);
    }

    public static function getTimeInterval()
    {
        $time_interval = DB::table('time_interval')->get();

        return $time_interval[0]->time_interval;
    }

    public static function updateFakeValue(Message $message)
    {
        DB::table('messages')
            ->where('id', '=', $message->id)
            ->update(['fake' => $message->fake]);
    }

    public static function updateMessageId(Message $message)
    {
        DB::table('messages')
            ->where('id', '=', $message->id)
            ->update(['message_id' => $message->message_id]);
    }
}
