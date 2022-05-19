<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\SourceDestination;

class SourceDestinationController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $input = Request::all();
        SourceDestination::create($input);
        return $input;
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
            'source_destination' => 'required',
            'sender_id' => 'required',
            'message_id' => 'required',
            'time_received' => 'required',
        ]);

        if ($validator->fails()) {
            $respond = [
                'status' => 401,
                'message' => $validator->errors(),
                'data' => null,
            ];

            return $respond;
        } else {
            $source_destination = new SourceDestination;
            $source_destination->source_destination = $request->source_destination;
            $source_destination->sender_id = $request->sender_id;
            $source_destination->message_id = $request->message_id;
            $source_destination->time_received = $request->time_received;
            $source_destination->save();
            $respond = [
                'status' => 200,
                'message' => 'Source/Destination added successfully',
                'data' => $source_destination,
            ];
            return $respond;
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
