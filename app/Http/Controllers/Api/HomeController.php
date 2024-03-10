<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CallsResource;
use App\Http\Resources\HomeResource;
use App\Http\Resources\MeetingsResource;
use App\Http\Resources\TasksResource;
use App\Http\Resources\VisitsResource;
use App\Services\CallService;
use App\Services\ClientServiceService;
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
        private MeetingService $meetingService,
        private ClientServiceService $clientServiceService
    )
    {
        
    }
    public function index()
    {
        try{
            $user = auth()->user()->load(['latestStatus', 'targets', 'visits', 'calls', 'clients', 'meetings']);

            return  apiResponse(data: new HomeResource($user));  
        }catch(Exception $e){
            return  apiResponse(message: $e->getMessage(), code: 442);  
        }
    }

    public function tasks(Request $request)
    {
        try{
            $user = auth()->user();
            $filters = $request->all();
            $filters['added_by'] = $user->id;
            $filters['next_tasks'] = Carbon::now();
            $visits_next_actions = TasksResource::collection($this->visitService->getAll(filters: $filters, withRelations:[]));
            $calls_next_actions = TasksResource::collection($this->callService->getAll(filters: $filters, withRelations:[]));
            $meetings_next_action = TasksResource::collection($this->meetingService->getAll(filters: $filters, withRelations:[]));
            $services_next_action = TasksResource::collection($this->clientServiceService->getAll(filters: $filters, withRelations: []));

            $tasks = $visits_next_actions->concat($calls_next_actions)->concat($meetings_next_action)->concat($services_next_action);

            return  apiResponse(data: $tasks);  
        }catch(Exception $e){
            return  apiResponse(message: $e->getMessage(), code: 442);  
        }
    }

}
