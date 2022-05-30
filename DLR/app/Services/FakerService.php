<?php

namespace App\Services;

use App\Models\Message;
use Carbon\Carbon;
use App\Repository\MessageRepository;
use App\Repository\BlacklistSourceRepository;
use App\Repository\GatewayConnectionRepository;
use App\Repository\SourceDestinationRepository;

class FakerService
{

    protected $message;

    public function __construct(Message $message)
    {

        $this->message = $message;
    }

    // USED
    public function checkBlacklistSender(): bool
    {

        $source_sender_id = BlacklistSourceRepository::getSourceBySenderId(
            $this->message->sender_id
        );

        if ($source_sender_id->isEmpty()) {

            return false;
        } else {

            return true;
        }
    }

    // USED
    public function checkSenderDestination(): bool
    {

        $sender_id_destination =
            SourceDestinationRepository::getSenderDestination(
                $this->message->sender_id,
                $this->message->destination
            );


        if ($sender_id_destination->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    // USED
    public function getTimeDifference()
    {
        $old_destination = SourceDestinationRepository::getSenderDestination(
            $this->message->sender_id,
            $this->message->destination
        )[0];
        $old_time_received = Carbon::createFromDate(
            $old_destination->time_received
        );
        $new_time_received = Carbon::createFromDate($this->message->date_received);
        $time_difference = $old_time_received
            ->diff($new_time_received)
            ->format('%H:%I:%S');

        return $time_difference;
    }

    // USED
    public function checkFakingInterval(): bool
    {
        $time_difference = $this->getTimeDifference();
        $time_interval = MessageRepository::getTimeInterval();

        if ($time_difference > $time_interval) {
            return true;
        } else {
            return false;
        }
    }

    // USED
    public function fakingManager()
    {
        // Checking if the sender_id is found in the blacklist table
        $blacklist_sender = $this->checkBlacklistSender();
        if (!$blacklist_sender) {
            $send_message = MessagesService::sendMessage(
                "Post",
                "https://httpsmsc01.montymobile.com/HTTP/api/Client/SendSMS",
                "{
                    'destination': {$this->message->destination},
                    'source': {$this->message->sender_id},
                    'text': {$this->message->message_text},
                    'dataCoding': 0
                }"
            );
            $send_message_response = $send_message->json();
            $this->message->message_id = $send_message_response["SMS"]["Id"];
            MessageRepository::updateMessageId($this->message);
            return;
        }

        // Checking if the sender_id & destination are
        // found in the sender_destination table
        $sender_destination = $this->checkSenderDestination();
        if (!$sender_destination) {
            $this->message->fake = 1;
            $this->message->delivery_status = "Delivered";
            MessagesService::manageMessageAndDlr($this->message, 2);
            return;
        } else {
            $faking_interval = $this->checkFakingInterval();
            if ($faking_interval) {
                $this->message->fake = 1;
                $this->message->delivery_status = "Delivered";
                MessagesService::manageMessageAndDlr($this->message, 2);
            } else {
                MessagesService::sendMessage(
                    "Post",
                    "https://httpsmsc02.montymobile.com/HTTP/api/Client/SendSMS",
                    "{
                        'destination': {$this->message->destination},
                        'source': {$this->message->sender_id},
                        'text': {$this->message->message_text},
                        'dataCoding': 0
                    }"
                );
            }
            SourceDestinationRepository::updateSenderDestination($this->message);
        }
    }
}
