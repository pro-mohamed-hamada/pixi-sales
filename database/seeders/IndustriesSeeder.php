<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Industry;
use App\Models\Reason;
use App\Models\Source;

class IndustriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Industry::create([
            'name'=>'عقارات',
        ]);
        Industry::create([
            'name'=>'سيارات',
        ]);
    }
}
