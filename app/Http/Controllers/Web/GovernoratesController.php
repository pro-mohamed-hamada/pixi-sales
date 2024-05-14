<?php

namespace App\Http\Controllers\Web;

use App\DataTables\GovernoratesDataTable;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\GovernorateStoreRequest;
use App\Http\Requests\Web\GovernorateUpdateRequest;
use App\Http\Resources\GovernoratesResource;
use App\Services\GovernorateService;
use App\Services\CountryService;
use App\Enum\ActivationStatusEnum;
use Exception;

class GovernoratesController extends Controller
{
    public function __construct(private CountryService $countryService, private GovernorateService $governorateService)
    {

    }

    public function index(GovernoratesDataTable $dataTable, Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>$withRelations])->render('Dashboard.Governorates.index');

    }//end of index

    public function governoratesAjax(Request $request)
    {
        try{
            $filters = $request->all();
            $withRelations = [];
            $cities = $this->governorateService->getAll(filters: $filters, withRelations: $withRelations);
            return GovernoratesResource::collection($cities);
    
        }catch(Exception $e){
            return apiResponse(message: __('lang.something_went_wrong'), code: 442);
        }
        
    }//end of index

    public function edit(Request $request, $id)
    {

        $governorate = $this->governorateService->findById(id: $id);
        if (!$governorate)
        {
            return redirect()->back()->with("message", __('lang.not_found'));
        }
        $countries = $this->countryService->getAll(filters: ['is_active'=>ActivationStatusEnum::ACTIVE]);
        return view('Dashboard.Governorates.edit', compact('countries', 'governorate'));
    }//end of edit

    public function create(Request $request)
    {
        $countries = $this->countryService->getAll(filters: ['is_active'=>ActivationStatusEnum::ACTIVE]);
        return view('Dashboard.Governorates.create', compact('countries'));
    }//end of create

    public function store(GovernorateStoreRequest $request)
    {
        try {
            $this->governorateService->store($request->validated());
            return redirect()->route('governorates.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('governorates.index')->with('message', $e->getMessage());
        }
    }//end of store
    
    public function update(GovernorateUpdateRequest $request, $id)
    {
        try {
            $this->governorateService->update(id: $id, data: $request->validated());
            return redirect()->route('governorates.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('governorates.index')->with('message', $e->getMessage());
        }
    }//end of update

    public function destroy(Request $request, $id)
    {
        try {
            $result = $this->governorateService->destroy($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(),code: 422);
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
