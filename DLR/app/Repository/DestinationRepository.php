<?php

namespace App\Repository;


use Illuminate\Support\Facades\DB;

class DestinationRepository
{
    public static function getSenderDestination(string $sender_id, string $destination)
    {
        $sender_id_destination = DB::table('destination')

            ->where('sender_id', '=', $sender_id)

            ->where('destination', '=', $destination)

            ->get();

        return $sender_id_destination;
    }
}
