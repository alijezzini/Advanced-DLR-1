<?php

namespace App\Services;

use App\Models\GatewayConnection;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repository\MessageRepository;
use App\Services\ApiHandlerService;
use App\Repository\SourceDestinationRepository;
use App\Repository\GatewayConnectionRepository;

class MessagesService
{
    // public static function createMessage(Tvalue $message)
    // {
    // }


    // USED
    public static function sendMessage(
        string $type,
        string $url,
        string $values
    ) {
        $api_handler = new ApiHandlerService(
            $type,
            $url,
            $values
        );
        return $api_handler->requesthandler();
    }

    public function getDeliveryStatusIndexValueDB(Request $request)
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

    // USED
    public static function sendDeliveryStatus(
        string $message_id,
        string $delivery_status,
        $gateway_connection
    ) {
        $api_handler = new ApiHandlerService(
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

    public  function getDeliveryStatusIndexValue(string $dlr_index): string
    {
        $delivery_status_dict = json_decode(
            file_get_contents(
                storage_path() . "/delivery_status_dictionary.json"
            ),
            true
        );

        if (!array_key_exists($dlr_index, $delivery_status_dict)) {
            return response()->json([
                'message' => 'Delivery status does not exist in JSON file!'
            ]);
        } else {
            return $delivery_status_dict[$dlr_index];
        }
    }

    // USED
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
            $message->terminator_message_id,
            $delivery_status,
            $gateway_connection
        );
    }

    // USED
    public static function generateTerminatorId(): string
    {
        return Str::uuid();
    }

    public static function dlrHandler(
        string $message_id,
        string $delivery_status
    ) {
        $message = MessageRepository::getMessageById($message_id);
        $dlr_value = self::getDeliveryStatusIndexValue($delivery_status);
        $message->delivery_status = $dlr_value;
        $gateway_connection = GatewayConnectionRepository::getGatewayConnectionById(
            $message->connection_id
        );
        MessageRepository::updateDeliveryStatus($message);
        self::sendDLR(
            'POST',
            $gateway_connection->api_url,
            "{
                'terminator_id': {$message->terminator_id},
                'delivery_status': {$delivery_status}
            }"
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendDLR(
        string $type,
        string $url,
        string $values
    ) {
        $api_handler = new ApiHandlerService(
            $type,
            $url,
            $values
        );
        return $api_handler->requesthandler();
    }
}
