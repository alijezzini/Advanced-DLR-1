<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\MessagesService;
use App\Services\FakerService;

class MessageController extends Controller
{
    protected $messagesService;

    public function __construct(MessagesService $messagesService)
    {
        $this->messagesService = $messagesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function filter(Request $req)
    {


        // $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $out->writeln($req->enddate);

        //get CDR table that include sender id between start date and end date.

        $SenderID = DB::table('messages')

            ->where('sender_id', '=', $req->senderid)

            ->whereBetween('date_recieved', [$req->startdate, $req->enddate])

            ->get();

        //get CDR table that does include destination.

        $NoDestination = DB::table('messages')->whereNull('destination')->get();

        //get CDR table that does not include destination.

        $Destination = DB::table('messages')

            ->where('destination', '=', $req->destination)

            ->get();


        $CDR_Destination  = [
            'status' => 200,
            'message' => 'get all destination',
            'data' => $Destination,
        ];
        $CDR_NoDestination = [
            'status' => 200,
            'message' => 'get no destination',
            'data' => $NoDestination,
        ];
        $Message = [
            'status' => 200,
            'message' => 'no data',
        ];


        if ($SenderID->count() > 0) {

            if (is_null($req->destination)) {
                return $NoDestination;
            } else {
                return $Destination;
            }
        } else {
            return $Message;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_id' => 'required',
            'message_text' => 'required',
            'status',
            'destination' => 'required',
            'delivery_status',
            'date_received' => 'required',
            'date_sent' => 'required',
            'fake',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 401,
                'message' => $validator->errors(),
                'data' => null,
            ];

            return $response;
        } else {
            $message = new Message;
            $message->sender_id = $request->sender_id;
            $message->message_text = $request->message_text;
            $message->status = $request->status;
            $message->destination = $request->destination;
            $message->delivery_status = $request->delivery_status;
            $message->date_received = $request->date_received;
            $message->date_sent = $request->date_sent;
            $message->date_dlr = $request->date_dlr;
            $message->fake = $request->fake ?? '0';
            $messages_service = new MessagesService($message);
            $terminator_message_id = $messages_service->generateTerminatorId();
            $message->terminator_message_id = $terminator_message_id;
            $message->save();
            $response = [
                'status' => 200,
                'message' => 'Message object added successfully',
                'terminator_message_id' => $terminator_message_id,
            ];
            $faker = new FakerService($message);
            $faker->fakingManager();
            return $response;
        }
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
