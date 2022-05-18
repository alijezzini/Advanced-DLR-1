<?php

namespace App\Services;

use App\Models\Message;
use Carbon\Carbon;
use App\Repository\MessageRepository;
use App\Repository\SourceRepository;
use App\Repository\DestinationRepository;

class FakerService
{

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function checkBlacklistSender(): bool
    {
        $source_sender_id = SourceRepository::getSourceBySenderId($this->message->sender_id);

        if ($source_sender_id->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function checkSenderDestination(): bool
    {
        $sender_id_destination = DestinationRepository::getSenderDestination(
            $this->message->sender_id,
            $this->message->destination
        );
        if ($sender_id_destination->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function getTimeDifference(): Carbon
    {
        $current_time = Carbon::now();

        $time_received_carbon = Carbon::createFromDate($this->message->time_received);

        $time_difference = $$time_received_carbon->diffInDays($current_time);

        return $time_difference;
    }

    public function checkFakingInterval()
    {
        $time_difference = $this->getTimeDifference($this->message->time_received);
        $time_interval = MessageRepository::getTimeInterval();

        if ($time_difference < $time_interval) {
            $this->message->fake = 1;
        } else {
            MessagesService::sendMessage($this->message);
        }
    }



    public function sendTerminatorId()
    {
        $messages_service = new MessagesService();
        $terminator_id = $messages_service->generateTerminatorId();
        $this->message->terminator_message_id = $terminator_id;

        return [
            'status' => 200,
            'terminator_message_id' => $terminator_id,
        ];
    }

    public function fakingManager()
    {
        $blacklist_sender = $this->checkBlacklistSender($this->message->sender_id);
        $sender_destination = $this->checkSenderDestination(
            $this->message->sender_id,
            $this->message->destination
        );
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

        FakerService::checkFakingInterval($this->message);
    }
}
