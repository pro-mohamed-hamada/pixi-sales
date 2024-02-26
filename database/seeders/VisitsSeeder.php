<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visit;
use Carbon\Carbon;

class VisitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0; $i<=50;$i++){
            Visit::create([
                'client_id'=>1,
                'date'=> Carbon::now(),
                'city_id'=>1,
                'next_action'=>1,
                'next_action_date'=> Carbon::now()->addDays(10),
                'comment'=>"this is the comment",
            ]);
        }
    }
}
