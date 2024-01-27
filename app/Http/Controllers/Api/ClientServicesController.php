<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ClientStoreRequest;
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
            $withRelations = [];
            $services = $this->clientServiceService->getAll(filters: $filters, withRelations: $withRelations);
            return ServicesResource::collection($services);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index

    public function store(ClientStoreRequest $request)
    {
        try{
            $client = $this->clientService->store(data: $request->Validated());
            if(!$client)
                return apiResponse(message: __('lang.something_went_wrong'));
            return apiResponse(data: new ClientsResource($client), message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of store

    public function show($id)
    {
        try {
           $withRelations = [];
            $client = $this->clientService->find(clientId: $id, withRelations: $withRelations);
            return apiResponse(data: new ClientsResource($client), message: __('lang.success_operation'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }
}
