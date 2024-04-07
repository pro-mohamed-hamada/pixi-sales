<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountriesResource;
use Exception;
use Illuminate\Http\Request;
use App\Services\CountryService;

class CountriesController extends Controller
{
    public function __construct(private CountryService $countryService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $governorates = $this->countryService->getAll(filters: $filters, withRelations: $withRelations);
            return CountriesResource::collection($governorates);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index
}
