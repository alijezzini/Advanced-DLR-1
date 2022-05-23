<?php

namespace App\Http\Controllers;

use App\Models\GatewayConnection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Database\Schema;
use Illuminate\Support\Facades\Validator;

class GatewayConnectionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usename' => 'required',
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
            $gateway_connection->api_uri = $request->api_uri;
            $gateway_connection->save();
            $response = [
                'status' => 200,
                'message' => 'Gateway COnnection added successfully',
            ];
            return $response;
        }
    }
}
