<?php

namespace App\Repository;


use Illuminate\Support\Facades\DB;

class GatewayConnectionRepository
{

    public static function getGatewayConnection(
        string $username,
        string $password
    ) {
        $gateway_connection = DB::table('gateway_connections')
            ->where('username', '=', $username)
            ->where('password', '=', $password)
            ->get();

        return $gateway_connection;
    }

    // USED
    public static function getGatewayConnectionById(int $id)
    {
        $gateway_connection = DB::table('gateway_connections')
            ->where('id', '=', $id)
            ->get();

        return $gateway_connection[0];
    }
}
