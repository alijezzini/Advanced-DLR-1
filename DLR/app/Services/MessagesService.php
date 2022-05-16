<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Destination;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessagesService
{
    public function faker(Message $message): bool
    {
        $blacklist_sender = $this->checkBlacklistSender($message->sender_id);
        $sender_destination = $this->checkSenderDestination($message->sender_id, $message->destination);

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

        return true;
    }

    public function checkBlacklistSender(string $sender_id): bool
    {
        $source_sender_id = DB::table('sources')

            ->where('sender_id', '=', $sender_id)

            ->get();

        if ($source_sender_id->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function checkSenderDestination(string $sender_id, string $destination): bool
    {
        $sender_id_destination = DB::table('destination')

            ->where('sender_id', '=', $sender_id)

            ->where('destination', '=', $destination)

            ->get();

        if ($sender_id_destination->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function checkTimeDifference(DateTime $time_received): Carbon
    {
        $current_time = Carbon::now();

        $time_received_query = DB::table('destination')

            ->where('time_received', '=', $time_received)

            ->get();

        $time_received_carbon = Carbon::createFromDate($time_received_query->time_received);

        $time_difference = $$time_received_carbon->diffInDays($current_time);

        return $time_difference;
    }

    public function getTimeInterval(): DateTime
    {
        $time_interval = DB::table('time_interval');

        return $time_interval->time_interval;
    }

    public function generateTerminatorId(Message $message): string
    {
        return Str::uuid();
    }
}
