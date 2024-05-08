<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ScheduleFcm;
use App\Models\Visit;
use Carbon\Carbon;
class OneHourBeforeTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:one-hour-before-task-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $scheduleFcm = ScheduleFcm::where('trigger', 'ONE_HOUR_BEFORE_TASK')->first();
        if($scheduleFcm)
        {
            $visits = Visit::whereDate('next_action_date',"=", Carbon::now('Africa/Cairo')->addHour()->format('Y-m-d'))
            ->whereTime("next_action_date", Carbon::now('Africa/Cairo')->addHour()->format('H:i'))->get();
            foreach($visits as $visit)
            {
                $user = User::find($visit->added_by);
                User::SendNotification(fcm: $scheduleFcm, users: [$user]);
            }
        }
        
    }
}
