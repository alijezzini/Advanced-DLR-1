<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;
class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message::create([
            'message_id' => '',
            'sender_id' => 'microsoft',
            'message_text' => 'Hello world',
            'destination' => '96103555666',
            'delivery_status' => '',
            'status' => '',
            'terminator_message_id' => '90357ede-9683-4365-ba23-9052f13fc841',
            'date_received' => '2022-05-04 00:00:00',
            'date_sent' => '2022-06-06 00:00:00',
            'date_dlr' => '',
            'fake' => '0',
        ]);
    }
}
