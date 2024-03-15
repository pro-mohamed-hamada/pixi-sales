<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\GovernoratesSeeder;
use Database\Seeders\CitiesSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\ActivityLogsSeeder;
use Database\Seeders\VisitsSeeder;
use Database\Seeders\ServicesSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(GovernoratesSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(IndustriesSeeder::class);
        $this->call(SourcesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ClientsSeeder::class);
        $this->call(ActivityLogsSeeder::class);
        $this->call(VisitsSeeder::class);
        $this->call(ServicesSeeder::class);
        $this->call(ReasonsSeeder::class);
        $this->call(DeviceSerialsSeeder::class);
        $this->call(WhatsappTemplatesSeeder::class);
    }
}
