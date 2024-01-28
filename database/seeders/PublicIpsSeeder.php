<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\publicIp;

class PublicIpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        publicIp::create([
            'ip'=>'192.168.1.1',
            'user_id'=>2,
        ]);
    }
}
