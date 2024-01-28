<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Target;

class TargetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Target::create([
            'name'=>['ar'=>'الزيارات','en'=>'Visits'],
        ]);
        Target::create([
            'name'=>['ar'=>'عقود','en'=>'Proposals'],
        ]);
        Target::create([
            'name'=>['ar'=>'الاجتماعات','en'=>'Meetings'],
        ]);
        Target::create([
            'name'=>['ar'=>'مغلق','en'=>'Closed'],
        ]);
    }
}
