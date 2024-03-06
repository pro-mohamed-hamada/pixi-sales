<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {
        try{
            $user = Auth::user();
            return  apiResponse(data: new HomeResource($user));  
        }catch(Exception $e){
            return  apiResponse(message: $e->getMessage(), code: 442);  
        }
    }
}
