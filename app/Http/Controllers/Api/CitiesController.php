<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CitiesResource;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\GovernoratesResource;
use App\Services\CityService;

class CitiesController extends Controller
{
    public function __construct(private CityService $cityService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $cities = $this->cityService->getAll(filters: $filters, withRelations: $withRelations);
            return apiResponse(data: CitiesResource::collection($cities), message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index
}
