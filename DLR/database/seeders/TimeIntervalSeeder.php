<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimeInterval;

class TimeIntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimeInterval::create([
            'time_interval' => '00:03:00',
        ]);
    }
}
