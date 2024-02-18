<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GovernorateService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\GovernoratesResource;

class GovernoratesController extends Controller
{
    public function __construct(private GovernorateService $governorateService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $governorates = $this->governorateService->getAll(filters: $filters, withRelations: $withRelations);
            return apiResponse(data: GovernoratesResource::collection($governorates), message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index
}
