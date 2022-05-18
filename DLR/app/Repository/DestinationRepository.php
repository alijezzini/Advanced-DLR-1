<?php

namespace App\Repository;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class DestinationRepository
{
    public static function getSenderDestination(string $sender_id, string $destination)
    {
        $sender_id_destination = DB::table('destination')

            ->where('sender_id', '=', $sender_id)

            ->where('destination', '=', $destination)

            ->get();

        return $sender_id_destination[0];
    }

    public static function insertSenderDestination(Message $message)
    {
    }

    public static function updateSenderDestination(Message $message)
    {
        DB::table('destination')

            ->where('sender_id', '=', $message->sender_id)

            ->where('destination', '=', $message->destination)

            ->update(['time_received' => $message->date_received]);
    }
}
