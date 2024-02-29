<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClientServiceStoreRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ClientStoreRequest;
use App\Http\Resources\ClientServicesResource;
use App\Http\Resources\ClientsResource;
use App\Http\Resources\ServicesResource;
use App\Services\ClientService;
use App\Services\ClientServiceService;
use Exception;

class ClientServicesController extends Controller
{
    public function __construct(private ClientServiceService $clientServiceService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $services = $this->clientServiceService->getAll(filters: $filters);
            return apiResponse(data: ClientServicesResource::collection($services), message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index

    public function store(ClientServiceStoreRequest $request)
    {
        try{
            $client = $this->clientServiceService->store(data: $request->Validated());
            if(!$client)
                return apiResponse(message: __('lang.something_went_wrong'), code: 442);
            return apiResponse(data: new ClientsResource($client), message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(), code: 442);
        }
        
    }//end of store

    public function destroy($id)
    {
        try {
            $status = $this->clientServiceService->destroy(id: $id);
            if(!$status)
                return apiResponse(message: __('lang.something_ent_wrong'));
            return apiResponse(message: __('lang.success_operation'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }
}
