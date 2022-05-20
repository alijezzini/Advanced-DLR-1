<?php

namespace App\Repository;


use Illuminate\Support\Facades\DB;

class GatewayConnectionRepository
{

    public static function getSourceConnection(
        string $username,
        string $password
    ) {
        $gateway_connection = DB::table('gateway_connections')
            ->where('username', '=', $username)
            ->where('password', '=', $password)
            ->get();

        return $gateway_connection;
    }
}
