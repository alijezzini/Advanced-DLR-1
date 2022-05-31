<?php

namespace App\Repository;

use App\Models\Message;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class MessageRepository
{
    // USED
    public static function getMessageById(string $message_id)
    {
        $message = Message::table('messages')
            ->where('terminator_message_id', '=', $message_id)
            ->get()
            ->first();

        return $message;
    }

    // USED
    public static function getTimeInterval()
    {
        $time_interval = DB::table('time_interval')
            ->get()
            ->first();

        return $time_interval->time_interval;
    }

    public static function updateStatus(string $message_id, string $status)
    {
        DB::table('messages')
            ->where('message_id', '=', $message_id)
            ->update(['status' => $status]);
    }

    // USED
    public static function updateDeliveryStatus(Message $message)
    {
        DB::table('messages')
            ->where('message_id', '=', $message->message_id)
            ->update(['delivery_status' => $message->delivery_status]);
    }

    // USED
    public static function updateFakeValue(Message $message)
    {
        DB::table('messages')
            ->where('id', '=', $message->id)
            ->update(['fake' => $message->fake]);
    }

    // USED
    public static function updateMessageId(Message $message)
    {
        DB::table('messages')
            ->where('id', '=', $message->id)
            ->update(['message_id' => $message->message_id]);
    }

    public static function getMessagesByDestination(
        string $destination,
        datetime $startdate,
        datetime $enddate
    ) {
        $message = DB::table('messages')
            ->where('destination', '=', $destination)
            ->whereBetween('date_recieved', [$startdate, $enddate])
            ->get();

        return $message;
    }

    public static function getMessagesBySource(
        string $source,
        datetime $startdate,
        datetime $enddate
    ) {
        $message = DB::table('messages')
            ->where('sender_id', '=', $source)
            ->whereBetween('date_recieved', [$startdate, $enddate])
            ->get();

        return $message;
    }

    public static function getMessagesBySourceDestination(
        string $source,
        string $destination,
        datetime $startdate,
        datetime $enddate
    ) {
        $message = DB::table('messages')
            ->where('sender_id', '=', $source)
            ->where('destination', '=', $destination)
            ->whereBetween('date_recieved', [$startdate, $enddate])
            ->get();

        return $message;
    }
}
