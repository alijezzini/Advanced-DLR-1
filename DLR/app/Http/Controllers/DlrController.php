<?php

namespace App\Http\Controllers;
use guzzle;
use App\Models\Destination;
use App\Repository\MessageRepository;
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
    public function getMessageIdAndStatus(Request $request)
    {
        $message = MessageRepository::getMessageById($request->message_id);
        if (!$message) {
            return [
                'status' => 'Message Id was not found!'
            ];
        } else {
            return [
                'message_id' => $message[0]->message_id,
                'status' => $message[0]->status,
            ];
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
        return $this->getMessageIdAndStatus($request);
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
