<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Repository\MessageRepository;
use App\Services\MessagesService;
use Illuminate\Http\Request;



class DlrController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setMessageDlr(Request $request)
    {
    
        $Status_Json = json_decode(file_get_contents(storage_path() . "/status.json"), true);    
        $request_status =$request->delivery_status;  

        if(!array_key_exists($request_status,$Status_Json))
        {
            return response()->json([
            'message' => 'Delivery status does not exist in JSON file!'
            ]);
        }
        else{
            $delivery_status = $Status_Json[$request_status];
        }
        //Needs Fixing
        printf($delivery_status);
        MessageRepository::updateDeliveryStatus(
            $request->message_id,
            $delivery_status
        );

    }
    
    /* 
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
