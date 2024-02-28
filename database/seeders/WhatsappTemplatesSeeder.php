<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Reason;
use App\Models\WhatsappTemplate;

class WhatsappTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WhatsappTemplate::create([
            'title'=>'title 1',
            'content'=>'content 1',
            'action'=>'New',
        ]);
        WhatsappTemplate::create([
            'title'=>'title 1',
            'content'=>'content 1',
            'action'=>'CALL',
        ]);
        WhatsappTemplate::create([
            'title'=>'title 1',
            'content'=>'content 1',
            'action'=>'MEETING',
        ]);
        WhatsappTemplate::create([
            'title'=>'title 1',
            'content'=>'content 1',
            'action'=>'VISIT',
        ]);
        
    }
}
