<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GovernorateService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\GovernoratesResource;
use App\Http\Resources\ReasonsResource;
use App\Services\ReasonService;

class ReasonsController extends Controller
{
    public function __construct(private ReasonService $reasonService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $reasons = $this->reasonService->getAll(filters: $filters, withRelations: $withRelations);
            return ReasonsResource::collection($reasons);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index
}
