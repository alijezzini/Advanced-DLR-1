<?php

namespace App\Services;

use App\Models\GatewayConnection;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repository\MessagesRepository;
use App\Services\ApiHandlerService;
use App\Repository\SourceDestinationRepository;
use App\Repository\GatewayConnectionsRepository;
use DateTime;


class MessagesService
{
    /**
     * sendMessage
     *
     * @return call requestHandler
     */
    public static function sendMessage(
        string $type,
        string $url,
        array $values
    ) {
        $api_handler = new ApiHandlerService(
            $type,
            $url,
            $values
        );
        return $api_handler->requestHandler();
    }

    /**
     * getDeliveryStatusIndexValueDB
     *
     * @param  mixed $request
     * @return void
     */
    public function getDeliveryStatusIndexValueDB(Request $request)
    {
        $message = MessagesRepository::getMessageById($request->message_id);
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

    /**
     * sendDeliveryStatus
     *
     * @return void
     */
    public static function sendDeliveryStatus(
        string $message_id,
        string $delivery_status_index,
        GatewayConnection $gateway_connection
    ) {
        $api_handler = new ApiHandlerService(
            "Get",
            $gateway_connection->api_url,
            [
                "ConnectionId" => "{$gateway_connection->connection_id}",
                "MessageId" => $message_id,
                // "MessageId" => "74bc1316-a302-41f9-980b-26acf72b4f58",
                "Status" => "{$delivery_status_index}"
            ]
        );
        return $api_handler->requesthandler();
    }

    /**
     * getDeliveryStatusValue
     *
     * @param  mixed $dlr_index
     * @return string
     */
    public static function getDeliveryStatusValue(string $dlr_index): string
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

    /**
     * getDeliveryStatusIndexValue
     *
     * @param  mixed $dlr_value
     * @return string
     */
    public static function getDeliveryStatusIndexValue(string $dlr_value): string
    {
        $delivery_status_dict = json_decode(
            file_get_contents(
                storage_path() . "/delivery_status_dictionary.json"
            ),
            true
        );

        $inverted_dict = array_flip($delivery_status_dict);
        if (!array_key_exists($dlr_value, $inverted_dict)) {
            return response()->json([
                'message' => 'Delivery status does not exist in JSON file!'
            ]);
        } else {
            return $inverted_dict[$dlr_value];
        }
    }

    /**
     * messageManager
     *
     * @return void
     */
    public static function messageManager(
        Message $message,
        string $delivery_status_index
    ) {
        MessagesRepository::updateFakeValue($message);
        MessagesRepository::updateDeliveryStatus($message);
        $gateway_connection =
            GatewayConnectionsRepository::getConnectionById(
                $message->connection_id
            );
        MessagesService::sendDeliveryStatus(
            $message->terminator_message_id,
            $delivery_status_index,
            $gateway_connection
        );
    }

    /**
     * generateTerminatorId
     *
     * @return string
     */
    public static function generateTerminatorId(): string
    {
        return Str::uuid();
    }

    /**
     * dlrHandler
     *
     * @return void
     */
    public static function dlrHandler(
        string $message_id,
        string $delivery_status
    ) {
        $message = MessagesRepository::getMessageById($message_id);
        $message->delivery_status = self::getDeliveryStatusValue($delivery_status);
        $gateway_connection = GatewayConnectionsRepository::getConnectionById(
            $message->connection_id
        );
        MessagesRepository::updateDeliveryStatus($message);

        MessagesService::sendDeliveryStatus(
            $message->terminator_message_id,
            $delivery_status,
            $gateway_connection
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
        array $values
    ) {
        $api_handler = new ApiHandlerService(
            $type,
            $url,
            $values
        );
        return $api_handler->requesthandler();
    }

    /**
     * searchFilter
     *
     * @return void
     */
    public static function searchFilter(
        string | null $sender_id,
        string | null $destination,
        DateTime | null $start_date,
        DateTime | null $end_date
    ) {
        $message = (new Message)->newQuery();
        if (!is_null($sender_id) and !is_null($destination)) {
            $message = MessagesRepository::getMessagesBYSourceDestination(
                $sender_id,
                $destination,
                $start_date,
                $end_date
            );
        } else {
            if (is_null($sender_id)) {

                $message = MessagesRepository::getMessagesByDestination(
                    $destination,
                    $start_date,
                    $end_date
                );
            } else {
                $message = MessagesRepository::GetMessagesBySource(
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

    public static function totalFakeMessages($messages)
    {
        $fake_messages = array();
        foreach ($messages as $message) {
            if ($message->fake == 1) {
                array_push($fake_messages, $message);
            }
        }
        return $fake_messages;
    }

    public static function totalMessages(
        string | null $year,
        string | null $month,
        string | null $day,
    ) {
        if (is_null($year) and is_null($month) and is_null($day)) {
            $messages = MessagesRepository::getAllMessages();
        }
        if (!is_null($year) and !is_null($month) and !is_null($day)) {
            $messages = MessagesRepository::getMessagesByYearMonthDay($year, $month, $day);
        } else {
            if (!is_null($year) and !is_null($month)) {
                $messages = MessagesRepository::getMessagesByYearMonth($year, $month);
            } else {
                if (!is_null($year) and is_null($day)) {
                    $messages = MessagesRepository::getMessagesByYear($year);
                }
            }
        }
        $total_messages_number = $messages->count();
        $totalfake = count(self::totalFakeMessages($messages));
        return  [
            'status' => 404,
            'Number of total messages' => $total_messages_number,
            'Number of fake messages' => $totalfake,
        ];
    }

    public static function totalSenders(
        string | null $sender,
    ) {
        $senders = MessagesRepository::getMessagesBySenderId($sender);

        $total_senders_count = $senders->count();
        $total_fake_messages = count(self::totalFakeMessages($senders));
        return  [
            'status' => 404,
            'Number of total senders' => $total_senders_count,
            'Number of fake senders' => $total_fake_messages,
        ];
    }
}
