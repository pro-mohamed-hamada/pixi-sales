<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WhatsappMessageStoreRequest;
use App\Http\Requests\Api\WhatsappMessageUpdateRequest;
use App\Http\Resources\WhatsappMessagesResource;
use App\Services\WhatsappMessageService;
use Exception;

class WhatsappMessagesController extends Controller
{
    public function __construct(private WhatsappMessageService $whatsappMessageService)
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
            $whatsappMessages = $this->whatsappMessageService->getAll(filters: $filters, withRelations: $withRelations);
            return WhatsappMessagesResource::collection($whatsappMessages);
    
        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WhatsappMessageStoreRequest $request)
    {
        try {
            $whatsappMessage = $this->whatsappMessageService->store($request->validated());
            return apiResponse(data: new WhatsappMessagesResource($whatsappMessage), message: __('lang.success_operation'));
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
            $this->whatsappMessageService->destroy($id);
            return apiResponse(message: __('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    }
}
