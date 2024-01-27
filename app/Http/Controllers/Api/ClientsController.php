<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ClientStoreRequest;
use App\Services\ClientService;
class ClientsController extends Controller
{
    public function __construct(private ClientService $clientService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $cities = $this->clientService->getAll(filters: $filters, withRelations: $withRelations);
            return ClientsResource::collection($cities);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index
}
