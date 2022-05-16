<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Destination;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Repository\MessageRepository;

class FakerService
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
        $source_sender_id = MessageRepository::getSourceBySenderId($sender_id);

        if ($source_sender_id->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function checkSenderDestination(string $sender_id, string $destination): bool
    {
        $sender_id_destination = MessageRepository::getSenderDestination($sender_id, $destination);

        if ($sender_id_destination->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function checkTimeDifference(DateTime $time_received): Carbon
    {
        $current_time = Carbon::now();

        $time_received_carbon = Carbon::createFromDate($time_received);

        $time_difference = $$time_received_carbon->diffInDays($current_time);

        return $time_difference;
    }



    public function generateTerminatorId(Message $message): string
    {
        return Str::uuid();
    }
}
