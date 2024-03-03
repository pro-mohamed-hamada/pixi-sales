<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\Sourcesresource;
use App\Services\SourceService;

class SourcesController extends Controller
{
    public function __construct(private SourceService $sourceService)
    {

    }

    public function index(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $sources = $this->sourceService->getAll(filters: $filters, withRelations: $withRelations);
            return Sourcesresource::collection($sources);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index
}
