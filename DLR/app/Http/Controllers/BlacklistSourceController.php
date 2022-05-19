<?php

namespace App\Http\Controllers;

use App\Models\BlacklistSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BlacklistSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function listall()
    {
        $source = BlacklistSource::all();
        $sender_idblacklist = [
            'status' => 200,
            'message' => 'get all sender id black list successfully',
            'data' => $source,
        ];
        return $sender_idblacklist;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //create
    function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_id' => 'required',

        ]);

        if ($validator->fails()) {
            $respond = [
                'status' => 401,
                'message' => $validator->errors()->first(),
                'data' => null,
            ];

            return $respond;
        } else {
            $source = new BlacklistSource;
            $source->sender_id = $request->sender_id;
            $source->save();
            $respond = [
                'status' => 200,
                'message' => 'Sender ID added successfully',
                'data' => $source,
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
    public function destroy($sender_id)
    {

        $data = BlacklistSource::where('sender_id', $sender_id);
        if (isset($data)) {
            $data->delete();
            $respond = [
                'status' => 200,
                'message' => 'sender_id deleted successfully',
                'data' => $data,
            ];
            return $respond;
        } else {
            $error = [
                'satus' => 400,
                'message' => 'sender_id not found',
                'data' => $data,
            ];
            return $error;
        }
    }
}
