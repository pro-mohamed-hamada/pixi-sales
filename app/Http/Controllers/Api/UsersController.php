<?php

namespace App\Http\Controllers\Api;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecentActivitiesResource;
use App\Http\Resources\UsersResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct(private UserService $userService)
    {
        
    }
    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $filters['type'] = UserTypeEnum::EMPLOYEE;
            $withRelations = [];
            $sources = $this->userService->getAll(filters: $filters, withRelations: $withRelations);
            return apiResponse(data: UsersResource::collection($sources));
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index

    public function recentActivities(Request $request)
    {
        try{
            $user = Auth::user();
            return $user->getRecentActivities();
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of recentActivities
}
