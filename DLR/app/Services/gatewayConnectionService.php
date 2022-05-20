<?php

namespace App\Services;

use App\Repository\GatewayConnectionRepository;

class gatewayConnectionService
{
    public function checkGatewayConnection(
        string $username,
        string $password
    ) {
        $gateway_connection = GatewayConnectionRepository::getSourceConnection(
            $username,
            $password
        );
        if (empty($gateway_conncetion)) {
            return  [
                'status' => 403,
                'message' => 'Invalid username or password!'
            ];
        } else {
            return true;
        }
    }
}
