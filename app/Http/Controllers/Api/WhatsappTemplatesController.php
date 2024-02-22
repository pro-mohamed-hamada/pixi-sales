<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CallStoreRequest;
use App\Http\Requests\Api\CallUpdateRequest;
use App\Http\Resources\CallsResource;
use App\Http\Resources\WhatsappTemplatesResource;
use App\Services\CallService;
use App\Services\WhatsappTemplateService;
use Exception;

class WhatsappTemplatesController extends Controller
{
    public function __construct(private WhatsappTemplateService $whatsappTemplateService)
    {
        
    }

    public function __invoke(Request $request)
    {
        try{
            $filters = $request->all();
            $whatsappTemplates = $this->whatsappTemplateService->getAll(filters: $filters);
            return WhatsappTemplatesResource::collection($whatsappTemplates);
    
        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    }

}
