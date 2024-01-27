<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;
class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create([
            'name'=>["ar"=>"جديد", "en"=>"New"],
        ]);
        Status::create([
            'name'=>["ar"=>"تم التواصل", "en"=>"Contacted"],
        ]);
        Status::create([
            'name'=>["ar"=>"مهتم", "en"=>"Interested"],
        ]);
        Status::create([
            'name'=>["ar"=>"غير مهتم", "en"=>"Not interested"],
        ]);
        Status::create([
            'name'=>["ar"=>"مغلق", "en"=>"Closed"],
        ]);
        Status::create([
            'name'=>["ar"=>"مفقود", "en"=>"Lost"],
        ]);
    }
}
