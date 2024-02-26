<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VisitsResource;
use App\Services\VisitService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\Api\VisitStoreRequest;
use App\Http\Requests\Api\VisitUpdateRequest;

class VisitsController extends Controller
{
    public function __construct(private VisitService $visitService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $cities = $this->visitService->getAll(filters: $filters, withRelations: $withRelations);
            return VisitsResource::collection($cities);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index

    public function store(VisitStoreRequest $request)
    {
        try{
            $visit = $this->visitService->store(data: $request->Validated());
            if(!$visit)
                return apiResponse(message: __('lang.something_went_wrong'));
            return apiResponse(data: new VisitsResource($visit), message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of store

    /**
     * Update the specified resource in storage.
     */
    public function update(VisitUpdateRequest $request, string $id)
    {
        try {
            $visit = $this->visitService->update($id, $request->validated());
            return apiResponse(data: new VisitsResource($visit), message: __('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    }
}
