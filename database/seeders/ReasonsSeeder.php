<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Reason;

class ReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reason::create([
            'name'=>['ar'=>'سبب 1', 'en'=>'reason 1'],
        ]);
        Reason::create([
            'name'=>['ar'=>'سبب 2', 'en'=>'reason 2'],
        ]);
        Reason::create([
            'name'=>['ar'=>'سبب 3', 'en'=>'reason 3'],
        ]);
        Reason::create([
            'name'=>['ar'=>'سبب 4', 'en'=>'reason 4'],
        ]);
        Reason::create([
            'name'=>['ar'=>'سبب 5', 'en'=>'reason 5'],
        ]);
    }
}
