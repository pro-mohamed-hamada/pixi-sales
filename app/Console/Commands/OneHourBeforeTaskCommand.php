<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
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
        $user = User::first();
        $user->name ="test cron";
        $user->save();
        // $scheduleFcm = ScheduleFcm::where('action', 'ONE_HOUR_BEFORE_TASK')->first();
        // if($scheduleFcm)
        // {
        //     $visits = Visit::where('next_action_date', Carbon::now()->addHour())->get();
        //     foreach($visits as $visit)
        //     {
        //         $user = User::find($visit->assigned_to);
        //     }
        // }
        
    }
}
