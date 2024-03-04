<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeviceSerial;

class DeviceSerialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeviceSerial::create([
            'device_serial'=>'serial1',
            'user_id'=>2,
        ]);
    }
}
