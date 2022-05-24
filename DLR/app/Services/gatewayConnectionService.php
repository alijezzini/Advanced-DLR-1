<?php

namespace App\Services;

use App\Repository\GatewayConnectionRepository;

class GatewayConnectionService
{
    public static function checkGatewayConnection(
        string $username,
        string $password
    ): bool {
        $gateway_connection = GatewayConnectionRepository::getGatewayConnection(
            $username,
            $password
        );
        if (empty($gateway_connection)) {
            return  [
                'status' => 403,
                'message' => 'Invalid username or password!'
            ];
        } else {
            return true;
        }
    }
    public static function getConnectionId(string $username, string $password){
        $gateway_connection = GatewayConnectionRepository::getGatewayConnection(
            $username,
            $password
        );
        return $gateway_connection[0]->id;
    }
}
