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
        GatewayConnection::create([]);
    }
}
