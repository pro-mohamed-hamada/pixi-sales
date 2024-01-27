<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ActivityLog;
use Carbon\Carbon;
class ActivityLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ActivityLog::create([
            'user_id'=>2,
            'login_time'=> Carbon::now()->setTimezone('Africa/Cairo'),
            'logout_time'=> Carbon::now()->addDay()->addMinutes(30)->setTimezone('Africa/Cairo'),
            'hours'=> Carbon::now()->addDay()->setTimezone('Africa/Cairo')->floatDiffInHours(Carbon::now()->setTimezone('Africa/Cairo')),
            'login_lat'=>"29.076361",
            'login_lng'=>"31.097000",
            'logout_lat'=>"26.679272679115716",
            'logout_lng'=>"31.49068689922373",
        ]);
    }
}
