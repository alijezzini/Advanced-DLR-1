<?php

namespace App\Repository;


use Illuminate\Support\Facades\DB;

class BlacklistSourceRepository
{
    public static function getSourceBySenderId(string $sender_id)
    {
        $source_sender_id = DB::table('blacklist_sources')
            ->where('sender_id', '=', $sender_id)
            ->get();

        return $source_sender_id;
    }
}
