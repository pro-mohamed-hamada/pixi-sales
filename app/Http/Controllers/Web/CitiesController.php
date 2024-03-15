<?php

namespace App\Http\Controllers\Web;

use App\Enum\ActivationStatusEnum;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CityStoreRequest;
use App\Http\Requests\Web\CityUpdateRequest;
use App\Http\Resources\CitiesResource;
use App\Services\CityService;
use App\Services\GovernorateService;
use Exception;

class CitiesController extends Controller
{
    public function __construct(private CityService $cityService, private GovernorateService $governorateService)
    {

    }

    public function index(Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        $cities = $this->cityService->getAll(filters: $filters, withRelations: $withRelations, perPage: 100);
        return View('Dashboard.Cities.index', compact(['cities']));
    }//end of index

    public function citiesAjax(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $cities = $this->cityService->getAll(filters: $filters, withRelations: $withRelations);
            return CitiesResource::collection($cities);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index

    public function edit(Request $request, $id)
    {

        $city = $this->cityService->findById(id: $id);
        if (!$city)
        {
            return redirect()->back()->with("message", __('lang.not_found'));
        }
        $governorates = $this->governorateService->getAll();//TODO: get only the active governorates
        return view('Dashboard.Cities.edit', compact('governorates', 'city'));
    }//end of edit

    public function create(Request $request)
    {
        $governorates = $this->governorateService->getAll();//TODO: get only the active governorates
        return view('Dashboard.Cities.create', compact('governorates'));
    }//end of create

    public function store(CityStoreRequest $request)
    {
        try {
            $this->cityService->store($request->validated());
            return redirect()->route('cities.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('cities.index')->with('message', $e->getMessage());
        }
    }//end of store
    
    public function update(CityUpdateRequest $request, $id)
    {
        try {
            $this->cityService->update(id: $id, data: $request->validated());
            return redirect()->route('cities.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('cities.index')->with('message', $e->getMessage());
        }
    }//end of update

    public function destroy($id)
    {
        try {
            $result = $this->cityService->destroy($id);
            if (!$result)
                return redirect()->back()->with("message", __('lang.not_found'));
            return redirect()->back()->with("message", __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of destroy

    // public function show(Request $request, $id)
    // {
    //     userCan(request: $request, permission: 'view_category');
    //     $category = $this->categoryService->find($id);
    //     if (!$category)
    //     {
    //         $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.category_not_found')];
    //         return back()->with('toast', $toast);
    //     }
    //    return view('dashboard.categories.show', compact('category'));
    // } //end of show

    // public function changeStatus(Request $request)
    // {
    //     try {
    //         $result =  $this->categoryService->changeStatus($request->id);
    //         if (!$result)
    //             return apiResponse(message: trans('lang.not_found'), code: 404);
    //         return apiResponse(message: trans('lang.success'));
    //     } catch (\Exception $exception) {
    //         return apiResponse(message: $exception->getMessage(), code: 422);
    //     }

    // } //end of changeStatus
}
