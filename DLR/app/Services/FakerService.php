<?php

namespace App\Services;

use App\Models\Message;
use Carbon\Carbon;
use App\Repository\MessageRepository;
use App\Repository\BlacklistSourceRepository;
use App\Repository\SourceDestinationRepository;

class FakerService
{

    protected $message;

    public function __construct(Message $message)
    {

        $this->message = $message;
    }

    public function checkBlacklistSender(): bool
    {

        $source_sender_id = BlacklistSourceRepository::getSourceBySenderId($this->message->sender_id);

        if ($source_sender_id->isEmpty()) {

            return false;
        } else {

            return true;
        }
    }

    public function checkSenderDestination(): bool
    {

        $sender_id_destination = SourceDestinationRepository::getSenderDestination(
            $this->message->sender_id,
            $this->message->destination
        );


        if ($sender_id_destination->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

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

        $time_difference = $old_time_received->diff($new_time_received)->format('%H:%I:%S');


        return $time_difference;
    }

    public function checkFakingInterval(): bool
    {
        $time_difference = $this->getTimeDifference();
        $time_interval = MessageRepository::getTimeInterval();
        // $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $out->writeln($time_interval->format('Y-m-d H:i:s'));

        if ($time_difference > $time_interval) {




            return true;
        } else {
            return false;
        }
    }

    public function fakingManager()
    {
        $blacklist_sender = $this->checkBlacklistSender();

        if (!$blacklist_sender) {
            // not implemented yet
            // MessagesService::sendMessage($this->message);
            return;
        }

        $sender_destination = $this->checkSenderDestination();


        if (!$sender_destination) {
            $this->message->fake = 1;
            MessageRepository::updateMessage($this->message);
            SourceDestinationRepository::insertSenderDestination($this->message);
            // not implemented yet
            // return delivered dlr response;
            return "DLR Response";
        } else {
            $faking_interval = $this->checkFakingInterval();
            if ($faking_interval) {
                $this->message->fake = 1;
                MessageRepository::updateMessage($this->message);
                // not implemented yet
                // return delivered dlr response;
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                $out->writeln("Send Message - 1");
            } else {
                // not implemented yet
                // MessagesService::sendMessage($this->message);
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                $out->writeln("Send Message - 2");
            }
            SourceDestinationRepository::updateSenderDestination($this->message);
        }
    }
}
