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
        $request_status = $request->delivery_status;
        switch ($request_status) {
            case '2':
                $delivery_status = "Delivered";
                break;
            case '3':
                $delivery_status = "Expired";
                break;
            case '4':
                $delivery_status = "Deleted";
                break;
            case '5':
                $delivery_status = "Undelivered";
                break;
            case '6':
                $delivery_status = "Accepted";
                break;
            case '7':
                $delivery_status = "Invalid";
                break;
            case '8':
                $delivery_status = "Rejected";
                break;
            default:
                $delivery_status = 'Something went wrong.';
                break;
        }
        // Needs Fixing
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
