<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ServicesResource;
use App\Services\ServiceService;
use Exception;

class ServicesController extends Controller
{
    public function __construct(private ServiceService $serviceService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $services = $this->serviceService->getAll(filters: $filters, withRelations: $withRelations);
            return ServicesResource::collection($services);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index

}
