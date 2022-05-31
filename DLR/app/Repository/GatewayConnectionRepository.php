<?php

namespace App\Repository;


use Illuminate\Support\Facades\DB;

class GatewayConnectionRepository
{
    public static function getConnection(
        string $username,
        string $password
    ) {
        $gateway_connection = DB::table('gateway_connections')
            ->where('username', '=', $username)
            ->where('password', '=', $password)
            ->get()
            ->first();

        return $gateway_connection;
    }

    public static function getConnectionById(int $id)
    {
        $gateway_connection = DB::table('gateway_connections')
            ->where('id', '=', $id)
            ->get()
            ->first();

        return $gateway_connection;
    }
}
