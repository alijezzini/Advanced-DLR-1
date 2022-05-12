<?php

namespace App\Services;

use App\Models\Cdr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CdrService
{
    public function faker(Cdr $cdr)
    {
        // do things
    }

    public function checkBlacklistSenderId(Request $request)
    {
        $source_sender_id = DB::table('source')

            ->where('sender_id', '=', $request->senderid)

            ->get();

        if ($source_sender_id->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function checkSenderIdDestination(Request $request)
    {
        $sender_id_destination = DB::table('destination')

            ->where('sender_id', '=', $request->senderid)

            ->where('destination', '=', $request->destination)

            ->get();

        if ($sender_id_destination->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }
}
