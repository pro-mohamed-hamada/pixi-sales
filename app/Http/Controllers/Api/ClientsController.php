<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClientHistoryStoreRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ClientStoreRequest;
use App\Http\Requests\Api\ClientUpdateRequest;
use App\Http\Requests\Api\ReassignClientRequest;
use App\Http\Resources\ClientOnCallResource;
use App\Http\Resources\ClientsResource;
use App\Services\ClientService;
use Exception;

class ClientsController extends Controller
{
    public function __construct(private ClientService $clientService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = ['visits', 'calls', 'meetings', 'whatsappMessages'];
            $clients = $this->clientService->getAll(filters: $filters, withRelations: $withRelations);
            return ClientsResource::collection($clients);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index

    public function getClientOnCall(Request $request)
    {
        // try{
            $filters = $request->all();
            $withRelations = ['visits', 'calls', 'meetings', 'whatsappMessages'];
            $clients = $this->clientService->getAll(filters: $filters, withRelations: $withRelations);
            return apiResponse(data: ClientOnCallResource::collection($clients), message: __('lang.success_operation'));
    
        // }catch(Exception $e){
        //     return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        // }
        
    }//end of getClientOnCall

    public function store(ClientStoreRequest $request)
    {
        try{
            $client = $this->clientService->store(data: $request->Validated());
            if(!$client)
                return apiResponse(message: __('lang.something_went_wrong'), code: 442);
            return apiResponse(data: new ClientsResource($client), message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of store

    public function update(ClientUpdateRequest $request, string $id)
    {
        try{
            $client = $this->clientService->update(id: $id, data: $request->Validated());
            if(!$client)
                return apiResponse(message: __('lang.something_went_wrong'), code: 442);
            return apiResponse(data: new ClientsResource($client), message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of update

    public function reassignClient(ReassignClientRequest $request, string $id)
    {
        try{
            $status = $this->clientService->reassignClient(id: $id, data: $request->Validated());
            if(!$status)
                return apiResponse(message: __('lang.something_went_wrong'), code: 442);
            return apiResponse(message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of reassignClient

    public function show($id)
    {
        try {
           $withRelations = [];
            $client = $this->clientService->findById(id: $id, withRelations: $withRelations);
            return apiResponse(data: new ClientsResource($client), message: __('lang.success_operation'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }

    public function changeStatus($id, ClientHistoryStoreRequest $request)
    {
        try {
            $status = $this->clientService->changeStatus(id: $id, data: $request->Validated());
            if(!$status)
                return apiResponse( message:  __('lang.something_went_wrong'), code: 442);
            return apiResponse( message: __('lang.success_operation'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }
}
