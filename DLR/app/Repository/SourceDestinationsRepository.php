<?php

namespace App\Repository;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class SourceDestinationsRepository
{
    public static function getSenderDestination(string $sender_id, string $destination)
    {

        $sender_id_destination = DB::table('source_destinations')
            ->where('sender_id', '=', $sender_id)
            ->where('destination', '=', $destination)
            ->get();


        return $sender_id_destination;
    }

    public static function insertSenderDestination(Message $message)
    {
        DB::table('source_destinations')->insert([
            [
                'sender_id' => $message->sender_id,
                'destination' => $message->destination,
                'time_received' => $message->date_received,
            ],
        ]);
    }

    public static function updateSenderDestination(Message $message)
    {
        DB::table('source_destinations')
            ->where('sender_id', '=', $message->sender_id)
            ->where('destination', '=', $message->destination)
            ->update(['time_received' => $message->date_received]);
    }
}
