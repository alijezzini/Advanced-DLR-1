<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    // php artisan db:seed
    public function run()
    {
        $this->call(BlacklistSeeder::class);
        $this->call(GatewayConnectionsSeeder::class);
        $this->call(TimeIntervalSeeder::class);


        // $this->call(MessageSeeder::class);
        // $this->call(SourceDestinationSeeder::class);
    }
}
