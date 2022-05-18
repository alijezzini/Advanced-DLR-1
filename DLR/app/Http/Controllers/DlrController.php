<?php

namespace App\Http\Controllers;

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

        $requested_status = $request->status;
        switch ($requested_status) {
            case '2':
                $inserted_status = "Delivered";
                break;
            case '3':
                $inserted_status = "Expired";
                break;
            case '4':
                $inserted_status = "Deleted";
                break;
            case '5':
                $inserted_status = "Undelivered";
                break;
            case '6':
                $inserted_status = "Accepted";
                break;
            case '7':
                $inserted_status = "Invalid";
                break;
            case '8':
                $inserted_status = "Rejected";
                break;
            default:
                $inserted_status = 'Something went wrong.';
                break;
        }
        MessageRepository::updateMessageStatus($request->message_id, $inserted_status);
        $message_service = new MessagesService();
        return $message_service->getDeliveryStatus($request);
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
