<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MeetingStoreRequest;
use App\Http\Requests\Api\MeetingUpdateRequest;
use App\Http\Resources\MeetingsResource;
use App\Services\MeetingService;
use Exception;

class MeetingsController extends Controller
{
    public function __construct(private MeetingService $meetingService)
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
            $meetings = $this->meetingService->getAll(filters: $filters, withRelations: $withRelations);
            return MeetingsResource::collection($meetings);
    
        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MeetingStoreRequest $request)
    {
        try {
            $meeting = $this->meetingService->store($request->validated());
            return apiResponse(data: new MeetingsResource($meeting), message: __('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MeetingUpdateRequest $request, string $id)
    {
        try {
            $meeting = $this->meetingService->update($id, $request->validated());
            return apiResponse(data: new MeetingsResource($meeting), message: __('lang.success_operation'));
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
            $result = $this->meetingService->destroy($id);
            return apiResponse(message: __('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    }
}
