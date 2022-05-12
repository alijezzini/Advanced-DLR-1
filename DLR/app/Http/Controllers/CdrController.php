<?php

namespace App\Http\Controllers;
use App\Models\Cdr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CdrController extends Controller
{
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


        if ($SenderID->count() > 0){  

            if (is_null($req->destination)) {
                return $NoDestination;
            }else{
                return $Destination;
            }

          }else {   return $Message;      
                }
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $SenderID = DB::table('cdrs')
        ->where('cdr_id', '=',)
        ->get();
        if ($SenderID->count() > 0){  

         
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
