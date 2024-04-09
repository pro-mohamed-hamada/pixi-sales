<?php

namespace App\Http\Controllers\Web;

use App\DataTables\ServicesDataTable;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ServiceStoreRequest;
use App\Http\Requests\Web\ServiceUpdateRequest;
use App\Services\GovernorateService;
use App\Services\ServiceService;

class ServicesController extends Controller
{
    public function __construct(private ServiceService $serviceService)
    {

    }

    public function index(ServicesDataTable $dataTable, Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>$withRelations])->render('Dashboard.Services.index');

    }//end of index

    public function edit(Request $request, $id)
    {

        $service = $this->serviceService->findById(id: $id);
        if (!$service)
        {
            return redirect()->back()->with("message", __('lang.not_found'));
        }
        return view('Dashboard.Services.edit', compact('service'));
    }//end of edit

    public function create(Request $request)
    {
        return view('Dashboard.Services.create');
    }//end of create

    public function store(ServiceStoreRequest $request)
    {
        try {
            $this->serviceService->store($request->validated());
            return redirect()->route('services.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('services.index')->with('message', $e->getMessage());
        }
    }//end of store

    public function update(ServiceUpdateRequest $request, $id)
    {
        try {
            $this->serviceService->update(id: $id, data: $request->validated());
            return redirect()->route('services.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('services.index')->with('message', $e->getMessage());
        }
    }//end of update

    public function destroy(Request $request, $id)
    {
        try {
            $result = $this->serviceService->destroy($id);
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
