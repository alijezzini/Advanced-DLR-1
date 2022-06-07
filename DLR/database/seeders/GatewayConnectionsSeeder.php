<?php

namespace Database\Seeders;

use App\Models\GatewayConnection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GatewayConnectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GatewayConnection::create([
            'username' => 'whatmt',
            'password' => 'Wh!t@2',
            'connection_id' => '6357',
            'api_url' => 'https://httpsmsc.montymobile.com/HTTP/api/Vendor/DLRListener?'
        ]);

    }
}
