<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CallsResource;
use App\Http\Resources\HomeResource;
use App\Http\Resources\MeetingsResource;
use App\Http\Resources\TasksResource;
use App\Http\Resources\VisitsResource;
use App\Services\CallService;
use App\Services\MeetingService;
use App\Services\VisitService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(
        private VisitService $visitService,
        private CallService $callService,
        private MeetingService $meetingService
    )
    {
        
    }
    public function __invoke()
    {
        try{
            $user = auth()->user()->load(['latestStatus', 'targets']);
            $filters['next_tasks'] = Carbon::now();
            $visits_next_actions = TasksResource::collection($this->visitService->getAll(filters: $filters, withRelations:[]));
            $calls_next_actions = TasksResource::collection($this->callService->getAll(filters: $filters, withRelations:[]));
            $meetings_next_action = TasksResource::collection($this->meetingService->getAll(filters: $filters, withRelations:[]));

            $user['tasks'] = $visits_next_actions->concat($calls_next_actions)->concat($meetings_next_action);

            return  apiResponse(data: new HomeResource($user));  
        }catch(Exception $e){
            return  apiResponse(message: $e->getMessage(), code: 442);  
        }
    }

}
