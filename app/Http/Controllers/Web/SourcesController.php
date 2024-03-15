<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\SourceStoreRequest;
use App\Http\Requests\Web\SourceUpdateRequest;
use App\Services\GovernorateService;
use App\Services\SourceService;

class SourcesController extends Controller
{
    public function __construct(private SourceService $sourceService)
    {

    }

    public function index(Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        $sources = $this->sourceService->getAll(filters: $filters, withRelations: $withRelations);
        return View('Dashboard.Sources.index', compact(['sources']));
    }//end of index

    public function edit(Request $request, $id)
    {

        $source = $this->sourceService->findById(id: $id);
        if (!$source)
        {
            return redirect()->back()->with("message", __('lang.not_found'));
        }
        return view('Dashboard.Sources.edit', compact('source'));
    }//end of edit

    public function create(Request $request)
    {
        return view('Dashboard.Sources.create');
    }//end of create

    public function store(SourceStoreRequest $request)
    {
        try {
            $this->sourceService->store($request->validated());
            return redirect()->route('sources.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('sources.index')->with('message', $e->getMessage());
        }
    }//end of store

    public function update(SourceUpdateRequest $request, $id)
    {
        try {
            $this->sourceService->update(id: $id, data: $request->validated());
            return redirect()->route('sources.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('sources.index')->with('message', $e->getMessage());
        }
    }//end of upate

    public function destroy($id)
    {
        try {
            $result = $this->sourceService->destroy($id);
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
