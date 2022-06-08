<?php

namespace App\Repository;

use App\Models\Message;
use App\Models\TimeInterval;
use DateTime;
use Illuminate\Support\Facades\DB;


class MessagesRepository
{
    public static function getMessageByMessageId(string $message_id)
    {
        $message = Message::where('message_id', '=', $message_id)
            ->get()
            ->first();

        return $message;
    }

    public static function getMessageByTerminatorId(string $message_id)
    {
        $message = Message::where('terminator_message_id', '=', $message_id)
            ->get()
            ->first();

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
            ->where('id', '=', $message->id)
            ->update(['delivery_status' => $message->delivery_status]);
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

    public static function getMessagesByDestination(
        string|null $destination,
        DateTime $startdate,
        DateTime $enddate
    ) {
        $message = DB::table('messages')
            ->where('destination', '=', $destination)
            ->whereBetween('date_received', [$startdate, $enddate])
            ->get();

        return $message;
    }

    public static function getMessagesBySource(
        string|null $source,
        DateTime $startdate,
        DateTime $enddate
    ) {

        $message = DB::table('messages')
            ->where('sender_id', '=', $source)
            ->whereBetween('date_received', [$startdate, $enddate])
            ->get();

        return $message;
    }

    public static function getMessagesBySourceDestination(
        string|null $source,
        string|null $destination,
        DateTime $startdate,
        DateTime $enddate
    ) {
        $message = DB::table('messages')
            ->where('sender_id', '=', $source)
            ->where('destination', '=', $destination)
            ->whereBetween('date_received', [$startdate, $enddate])
            ->get();

        return $message;
    }

    public static function getAllMessages()
    {
        $message = DB::table('messages')
            ->get();

        return $message;
    }

    public static function getMessagesByYearMonthDay(
        string | null $year,
        string | null $month,
        string | null $day
    ) {
        $message = DB::table('messages')
            ->whereYear('date_received', $year)
            ->whereMonth('date_received', '=', $month)
            ->whereDay('date_received', '=', $day)
            ->get();

        return $message;
    }

    public static function getMessagesByYearMonth(
        string|null $year,
        string|null $month,
    ) {
        $message = DB::table('messages')
            ->whereYear('date_received', $year)
            ->whereMonth('date_received', '=', $month)
            ->get();

        return $message;
    }

    public static function getMessagesByYear(
        string|null $year,
    ) {
        $message = DB::table('messages')
            ->whereYear('date_received', $year)
            ->get();

        return $message;
    }

    public static function getMessagesBySenderId(
        string|null $sender,
    ) {
        $message = DB::table('messages')
            ->where('sender_id', $sender)
            ->get();

        return $message;
    }
}
