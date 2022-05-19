<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SourceDestination;
class SourceDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SourceDestination::create([
            'destination' => '96103555666',
            'sender_id' => 'microsoft',
            'message_id' => '',
            'time_received' => '2022-07-07 00:00:00',
        ]);
    }
}
