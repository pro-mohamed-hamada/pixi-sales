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
            'name'=>'سبب 1',
        ]);
        Reason::create([
            'name'=>'سبب 2',
        ]);
        Reason::create([
            'name'=>'سبب 3',
        ]);
        Reason::create([
            'name'=>'سبب 4',
        ]);
        Reason::create([
            'name'=>'سبب 5',
        ]);
    }
}
