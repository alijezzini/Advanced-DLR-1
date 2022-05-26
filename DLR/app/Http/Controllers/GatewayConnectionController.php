<?php

namespace App\Http\Controllers;

use App\Models\GatewayConnection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Database\Schema;
use Illuminate\Support\Facades\Validator;
use App\Services\Bla;

class GatewayConnectionController extends Controller
{

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
            'username' => 'required',
            'password' => 'required',
            'connection_id' => 'required',
            'api_url' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 401,
                'message' => $validator->errors(),
                'data' => null,
            ];

            return $response;
        } else {
            $gateway_connection = new GatewayConnection();
            $gateway_connection->username = $request->username;
            $gateway_connection->password = $request->password;
            $gateway_connection->connection_id = $request->connection_id;
            $gateway_connection->api_url = $request->api_url;
            $gateway_connection->save();
            $response = [
                'status' => 200,
                'message' => 'Gateway Connection added successfully',
            ];
            return $response;
        }
    }
    // public function testing(Request $request){
    //     $url = $request->query('url');
    //     $type = $request->query('type');
    //     $value = $request->query('value');
    //     $apicall = new Bla($type,$url,$value);
    //     return $apicall->requesthandler();
    //  }
}
