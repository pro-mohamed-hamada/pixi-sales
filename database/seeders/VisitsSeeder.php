<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visit;
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
                'action_type'=> 1,
                'comment'=>"this is the comment",
            ]);
        }
    }
}
