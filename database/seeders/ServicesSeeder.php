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
            'name'=>["ar"=>"تطبيق هاتف", "en"=>"Mobile app"],
            'is_active'=>1,
        ]);
        Service::create([
            'name'=>["ar"=>"موقع الكترونى", "en"=>"ًWeb site"],
            'is_active'=>1,
        ]);
        Service::create([
            'name'=>["ar"=>"تطبيق سطح مكتب", "en"=>"ًDesktop app"],
            'is_active'=>1,
        ]);
    }
}
