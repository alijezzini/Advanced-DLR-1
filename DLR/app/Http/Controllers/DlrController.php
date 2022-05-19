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
        $request_status = $request->status;
        switch ($request_status) {
            case '2':
                $status = "Delivered";
                break;
            case '3':
                $status = "Expired";
                break;
            case '4':
                $status = "Deleted";
                break;
            case '5':
                $status = "Undelivered";
                break;
            case '6':
                $status = "Accepted";
                break;
            case '7':
                $status = "Invalid";
                break;
            case '8':
                $status = "Rejected";
                break;
            default:
                $status = 'Something went wrong.';
                break;
        }
        // Needs Fixing
        MessageRepository::updateMessageStatus(
            $request->message_id,
            $status
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
