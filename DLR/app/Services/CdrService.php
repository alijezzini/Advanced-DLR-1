<?php

namespace App\Services;

use App\Models\Cdr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CdrService
{
    public function faker(Request $request): bool
    {
        $current_time = Carbon::now();
        $blacklist_sender = $this->checkBlacklistSender($request);
        $sender_destination = $this->checkSenderDestination($request);

        if (!$blacklist_sender) {
            return [
                'status' => 200,
                'message' => 'Sender ID was not found!',
            ];
        }
        if (!$sender_destination) {
            return [
                'status' => 200,
                'message' => 'Sender ID / Destination combination was not found!',
            ];
        }
    }

    public function checkBlacklistSender(Cdr $request): bool
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

    public function checkSenderDestination(Request $request): bool
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

    public function checkTimeDifference(Request $request)
    {
    }
}
