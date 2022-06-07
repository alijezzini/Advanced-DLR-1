<?php

namespace App\Repository;

use App\Models\GatewayConnection;
use Illuminate\Support\Facades\DB;

class GatewayConnectionsRepository
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

    public static function getConnectionByConnectionId(int $connection_id)
    {
        $gateway_connection = GatewayConnection::where(
            'connection_id',
            '=',
            $connection_id
        )
            ->get()
            ->first();

        return $gateway_connection;
    }

    public static function getConnectionById(int $id)
    {
        $gateway_connection = GatewayConnection::where(
            'id',
            '=',
            $id
        )
            ->get()
            ->first();

        return $gateway_connection;
    }
}
