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
}
