<?php

namespace Database\Seeders;

use App\Enum\ClientStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = Client::create([
            'name'=>'client 1',
            'phone'=>'+201101865213',
            'industry'=>'industry 1',
            'company_name'=>'company 1',
            'city_id'=>1,
            'other_person_name'=>'person 2',
            'other_person_phone'=>'01034374784',
            'other_person_position'=>"employee",

        ]);

        $client->history()->create([
            'status'=>ClientStatusEnum::NEW
        ]);
    }
}
