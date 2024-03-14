<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name'=>"تطبيق هاتف",
            'is_active'=>1,
        ]);
        Service::create([
            'name'=>"موقع الكترونى",
            'is_active'=>1,
        ]);
        Service::create([
            'name'=>"تطبيق سطح مكتب",
            'is_active'=>1,
        ]);
    }
}
