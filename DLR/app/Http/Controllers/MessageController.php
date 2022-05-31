<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\MessagesService;
use App\Services\FakerService;
use App\Services\GatewayConnectionService;
use Carbon\Carbon;



class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function createMessage(
        Request $request,
        string $connection_id
    ): Message {
        $message = new Message;
        $message->sender_id = $request->source;
        $message->message_text = $request->content;
        $message->destination = $request->destination;
        $message->date_received = Carbon::now();
        $message->fake = '0';
        $message->connection_id = $connection_id;
        $messages_service = new MessagesService($message);
        $message->terminator_message_id = $messages_service
            ->generateTerminatorId();
        $message->save();

        return $message;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date);
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date);

        $validator = Validator::make($request->all(), [
            'sender_id',
            'destination',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 401,
                'message' => $validator->errors(),
                'data' => null,
            ];

            return $response;
        } else {
            return MessagesService::searchFIlter(
                $request->sender_id,
                $request->destination,
                $start_date,
                $end_date,

            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source' => 'required',
            'content' => 'required',
            'destination' => 'required',
            'username' => 'required',
            'password' => 'required',
            'dataCoding',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 401,
                'message' => $validator->errors(),
                'data' => null,
            ];

            return $response;
        } else {
            // checking if the credentials return a valid gateway connection
            $gateway_connection = GatewayConnectionService::checkGatewayConnection(
                $request->username,
                $request->password
            );
            // 
            if (!is_null($gateway_connection)) {
                // Creating an instance of a Message
                $message = $this->createMessage(
                    $request,
                    $gateway_connection->connection_id
                );
                //Instance of FakerService with an Type message as an attrinute
                $faker = new FakerService($message);
                //Faking process
                $faker->fakingManager();
                $response = [
                    'status' => 200,
                    'message' => 'Message object added successfully',
                    'terminator_message_id' => $message->terminator_message_id,
                ];

                return $response;
            } else {
                return [
                    'status' => 'Wrong username or password!'
                ];
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDLR(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message_id' => 'required',
            'delivery_status' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 401,
                'message' => $validator->errors(),
                'data' => null,
            ];

            return $response;
        } else {
            $message_id = $request->message_id;
            $delivery_status = $request->delivery_status;
            MessagesService::dlrHandler($message_id, $delivery_status);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
