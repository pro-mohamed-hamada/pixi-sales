<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IndustriesResource;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\SourcesResource;
use App\Services\IndustryService;

class IndustriesController extends Controller
{
    public function __construct(private IndustryService $industryService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $sources = $this->industryService->getAll(filters: $filters, withRelations: $withRelations);
            return apiResponse(data: IndustriesResource::collection($sources), message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index
}
