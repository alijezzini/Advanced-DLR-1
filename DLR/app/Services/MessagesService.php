<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repository\MessageRepository;
use App\Services\ApiHandlerService;
use App\Repository\SourceDestinationRepository;
use App\Repository\GatewayConnectionRepository;
use DateTime;


class MessagesService
{
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
                'message_id' => $message->message_id,
                'delivery_status' => $message->status,
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
        $gateway_connection = GatewayConnectionRepository::getConnectionById(
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
        $gateway_connection = GatewayConnectionRepository::getConnectionById(
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

    public static function searchFilter(
        string | null $sender_id,
        string | null $destination,
        DateTime | null $start_date,
        DateTime | null $end_date
    ) {

        $message = (new Message)->newQuery();
        // request contains both source and destination
        if (!is_null($sender_id) and !is_null($destination)) {

            $message = MessageRepository::getMessagesBYSourceDestination(
                $sender_id,
                $destination,
                $start_date,
                $end_date

            );
        } else {
            // request contains only destination
            if (is_null($sender_id)) {

                $message = MessageRepository::getMessagesByDestination(
                    $destination,
                    $start_date,
                    $end_date
                );
            } else {

                // request contains only source



                $message = MessageRepository::GetMessagesBySource(
                    $sender_id,
                    $start_date,
                    $end_date
                );
            }
        }
        if ($message->isEmpty()) {
            return  [
                'status' => 404,
                'message' => 'No matching results!',
            ];
        } else {
            return $message;
        }
    }
}
