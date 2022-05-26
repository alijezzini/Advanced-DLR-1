<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repository\MessageRepository;
use App\Services\Bla;
use App\Repository\SourceDestinationRepository;
use App\Repository\GatewayConnectionRepository;

class MessagesService
{
    public static function sendMessage(
        string $type,
        string $url,
        string $values
    ) {
        $api_handler = new Bla(
            $type,
            $url,
            $values
        );
        return $api_handler->requesthandler();
    }

    public function getDeliveryStatusDB(Request $request)
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

    public static function sendDeliveryStatus(
        string $message_id,
        string $delivery_status,
        $gateway_connection
    ) {
        $api_handler = new Bla(
            "get",
            $gateway_connection->api_url,
            "{
                'ConnectionId': $gateway_connection->connection_id,
                'MessageId': $message_id,
                'Status': $delivery_status,
            }"
        );
        return $api_handler->requesthandler();
    }

    public static function getDeliveryStatus(Request $request)
    {
        $delivery_status_dict = json_decode(
            file_get_contents(
                storage_path() . "/delivery_status_dictionary.json"
            ),
            true
        );
        $request_status = $request->statusId;

        if (!array_key_exists($request_status, $delivery_status_dict)) {
            return response()->json([
                'message' => 'Delivery status does not exist in JSON file!'
            ]);
        } else {
            $delivery_status = $delivery_status_dict[$request_status];
        }
        //Needs Fixing
        MessageRepository::updateDeliveryStatus(
            $request->messageId,
            $delivery_status
        );
    }

    public static function manageMessageAndDlr(
        Message $message,
        int $delivery_status
    ) {
        MessageRepository::updateFakeValue($message);
        MessageRepository::updateDeliveryStatus($message);
        SourceDestinationRepository::insertSenderDestination($message);
        $gateway_connection = GatewayConnectionRepository::getGatewayConnectionById(
            $message->connection_id
        );
        MessagesService::sendDeliveryStatus(
            $message->message_id,
            $delivery_status,
            $gateway_connection
        );
    }

    public static  function generateTerminatorId(): string
    {
        return Str::uuid();
    }
}
