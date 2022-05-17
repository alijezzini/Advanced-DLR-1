<?php

namespace App\Repository;


use Illuminate\Support\Facades\DB;

class SourceRepository
{

    public static function getSourceBySenderId(string $sender_id)
    {
        $source_sender_id = DB::table('sources')

            ->where('sender_id', '=', $sender_id)

            ->get();

        return $source_sender_id;
    }
}
