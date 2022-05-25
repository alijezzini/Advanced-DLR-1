<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repository\MessageRepository;
use Illuminate\Support\Facades\Http;
use App\Services\ApiHandler;

class MessagesService
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public  function sendMessage()
    {
        $apicall = new ApiHandler(
            "Post",
            "http://127.0.0.1:8000/api/auth/createSource",
            '{"sender_id": "bobs"}'
        );
        return $apicall->requesthandler();
    }

    // public function getDeliveryStatus(Request $request)
    // {
    //     $message = MessageRepository::getMessageById($request->message_id);
    //     if (!$message) {
    //         return [
    //             'status' => 'Message Id was not found!'
    //         ];
    //     } else {
    //         return [
    //             'message_id' => $message[0]->message_id,
    //             'delivery_status' => $message[0]->status,
    //         ];
    //     }
    // }

    public function generateTerminatorId(): string
    {
        return Str::uuid();
    }

    // public function returnDeliveryStatus()
    // {
    //     // create getConnectionId method from gatewayConnections service
    //     $connection_id = "";
    //     $message_id = $this->message->terminaton_message_id;
    //     $status = "";
    //     $update_dlr = Http::post(
    //         "https://httpsmsc02.montymobile.com/HTTP/api/Vendor/DLRListenerBasic?" .
    //             "ConnectionId={$connection_id}&MessageId={$message_id}&Status={$status}"
    //     );
    // }

    public function setMessageDlr(Request $request)
    {

        $Status_Json = json_decode(file_get_contents(storage_path() . "/status.json"), true);
        $request_status = $request->delivery_status;

        if (!array_key_exists($request_status, $Status_Json)) {
            return response()->json([
                'message' => 'Delivery status does not exist in JSON file!'
            ]);
        } else {
            $delivery_status = $Status_Json[$request_status];
        }
        //Needs Fixing
        printf($delivery_status);
        MessageRepository::updateDeliveryStatus(
            $request->id,
            $delivery_status
        );
    }
}
