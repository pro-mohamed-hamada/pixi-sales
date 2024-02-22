<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CallStoreRequest;
use App\Http\Requests\Api\CallUpdateRequest;
use App\Http\Resources\CallsResource;
use App\Services\CallService;
use Exception;

class CallsController extends Controller
{
    public function __construct(private CallService $callService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $calls = $this->callService->getAll(filters: $filters, withRelations: $withRelations);
            return CallsResource::collection($calls);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CallStoreRequest $request)
    {
        try {
            $call = $this->callService->store($request->validated());
            return apiResponse(data: new CallsResource($call), message: __('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CallUpdateRequest $request, string $id)
    {
        try {
            $call = $this->callService->update($id, $request->validated());
            return apiResponse(data: new CallsResource($call), message: __('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $result = $this->callService->destroy($id);
            return apiResponse(message: __('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    }
}
