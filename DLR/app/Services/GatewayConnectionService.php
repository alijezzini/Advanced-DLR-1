<?php

namespace App\Services;

use App\Repository\GatewayConnectionRepository;

class gatewayConnectionService
{
    public function checkGatewayConnection(
        string $username,
        string $password
    ): bool {
        $gateway_connection = GatewayConnectionRepository::getSourceConnection(
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
}
