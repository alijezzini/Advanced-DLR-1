<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repository\MessageRepository;

class MessagesService
{
    public static function sendMessage(Message $message)
    {
    }

    public function updateMessageId(string $received_message_id, string $sent_terminator_id)
    {
    }

    public function updateDeliveryStatus(string $message_id, string $delivery_status)
    {
    }

    public function updateStatus(string $message_id, string $status)
    {
    }

    public function getMessageStatus(Request $request)
    {
        $message = MessageRepository::getMessageById($request->message_id);
        if (!$message) {
            return [
                'status' => 'Message Id was not found!'
            ];
        } else {
            return [
                'message_id' => $message[0]->message_id,
                'delivery_status' => $message[0]->status,
            ];
        }
    }

    public function generateTerminatorId(): string
    {
        return Str::uuid();
    }
}
