<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Reason;
use App\Models\Source;

class SourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Source::create([
            'title'=>['ar'=>'فيسبوك', 'en'=>'facebook'],
        ]);
        Source::create([
            'title'=>['ar'=>'الموقع', 'en'=>'website'],
        ]);
    }
}
