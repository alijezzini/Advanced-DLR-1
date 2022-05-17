<?php

namespace App\Services;

use App\Models\Message;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Str;
use App\Repository\MessageRepository;
use App\Repository\SourceRepository;
use App\Repository\DestinationRepository;

class FakerService
{



    public function checkBlacklistSender(string $sender_id): bool
    {
        $source_sender_id = SourceRepository::getSourceBySenderId($sender_id);

        if ($source_sender_id->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function checkSenderDestination(string $sender_id, string $destination): bool
    {
        $sender_id_destination = DestinationRepository::getSenderDestination($sender_id, $destination);

        if ($sender_id_destination->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function getTimeDifference(DateTime $time_received): Carbon
    {
        $current_time = Carbon::now();

        $time_received_carbon = Carbon::createFromDate($time_received);

        $time_difference = $$time_received_carbon->diffInDays($current_time);

        return $time_difference;
    }

    public function checkFakingInterval(Message $message)
    {
        $time_difference = $this->getTimeDifference($message->time_received);
        $time_interval = MessageRepository::getTimeInterval();

        if ($time_difference < $time_interval) {
            $message->fake = 1;
        } else {
            MessagesService::sendMessage($message);
        }
    }



    public function sendTerminatorId(Message $message)
    {
        $messages_service = new MessagesService();
        $terminator_id = $messages_service->generateTerminatorId();
        $this->message->terminator_message_id = $terminator_id;

        return [
            'status' => 200,
            'terminator_message_id' => $terminator_id,
        ];
    }

    public function fakingManager(Message $message)
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

        FakerService::checkFakingInterval($message);
    }
}
