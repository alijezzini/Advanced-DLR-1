<?php

namespace App\Http\Controllers;

use App\Models\Cdr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\CdrService;

class CdrController extends Controller
{
    protected $cdrService;

    public function __construct(CdrService $cdrService)
    {
        $this->cdrService = $cdrService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $req)
    {


        // $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $out->writeln($req->enddate);

        //get CDR table that include sender id between start date and end date.

        $SenderID = DB::table('cdrs')

            ->where('sender_id', '=', $req->senderid)

            ->whereBetween('date_recieved', [$req->startdate, $req->enddate])

            ->get();

        //get CDR table that does include destination.

        $NoDestination = DB::table('cdrs')->whereNull('destination')->get();

        //get CDR table that does not include destination.

        $Destination = DB::table('cdrs')

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
        $validator = Validator::make($request->all(), [
            'sender_id' => 'required',
            'message_text' => 'required',
            'status' => 'required',
            'destination' => 'required',
            'delivery_status' => 'required',
            'terminator_message_id' => 'required',
            'date_recieved' => 'required',
            'date_sent' => 'required',
            'date_dlr' => 'required',
            'fake' => 'required'
        ]);

        if ($validator->fails()) {
            $respond = [
                'status' => 401,
                'message' => $validator->errors(),
                'data' => null,
            ];

            return $respond;
        } else {
            $cdr_message = new Cdr;
            $cdr_message->sender_id = $request->sender_id;
            $cdr_message->message_text = $request->message_text;
            $cdr_message->status = $request->status;
            $cdr_message->destination = $request->destination;
            $cdr_message->delivery_status = $request->delivery_status;
            $cdr_message->terminator_message_id = $request->terminator_message_id;
            $cdr_message->date_recieved = $request->date_recieved;
            $cdr_message->date_sent = $request->date_sent;
            $cdr_message->date_dlr = $request->date_dlr;
            $cdr_message->fake = $request->fake;
            $blacklist_sender = $this->cdrService->checkBlacklistSender($cdr_message);
            $cdr_message->save();
            $respond = [
                'status' => 200,
                'message' => 'CDR message object added successfully',
                'data' => $cdr_message,
                'checkBlacklistSender' => $blacklist_sender,
            ];

            return $respond;
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
        //
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
