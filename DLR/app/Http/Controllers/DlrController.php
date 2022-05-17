<?php

namespace App\Http\Controllers;
use guzzle;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;



class DlrController extends Controller
{   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMessage_id(Request $request)
    {  
        $tests = DB::table('messages')->where('terminator_message_id', '=', $request->message_id)
        ->select('message_id','status')->get();
        return  $tests;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
 {
    
    $RequestStatus=$request->status;
      switch ($RequestStatus) {
            case '2':
                $InsertStatus ="Delivered";
                break;
            case '3':
                $InsertStatus ="Expired";
                break;
            case '4':
                $InsertStatus ="Deleted";
                break;
            case '5':
                $InsertStatus ="Undelivered";
                 break;
            case '6':
                $InsertStatus ="Accepted";
                 break;
            case '7':
                $InsertStatus ="Invalid";
                break; 
            case '8':
                $InsertStatus ="Rejected";
                break;  
            default:
               $InsertStatus ='Something went wrong.';
                break;       
        }
        $test = DB::table('messages')
        ->where('terminator_message_id', '=', $request->message_id)
        ->update(['messages.status' => $InsertStatus]);

        $try = [
            'status' => 200,
            'success' => 'Id matched successfully',
        ];
        
          return $this->getMessage_id($request);
      
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
