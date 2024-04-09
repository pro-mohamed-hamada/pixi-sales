<?php

namespace App\Http\Controllers\Web;

use App\DataTables\ActivityLogsDataTable;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;
use App\Http\Controllers\Controller;

class ActivityLogsController extends Controller
{
    public function __construct(private ActivityLogService $activityLogService)
    {

    }

    public function index(ActivityLogsDataTable $dataTable, Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>$withRelations])->render('Dashboard.ActivityLogs.index');

    }//end of index

    // public function edit(Request $request, $id)
    // {
    //     userCan(request: $request, permission: 'edit_category');
    //     $category = $this->categoryService->find($id);
    //     if (!$category)
    //     {
    //         $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.category_not_found')];
    //         return back()->with('toast', $toast);
    //     }
    //     return view('dashboard.categories.edit', compact('category'));
    // }//end of edit

    // public function create(Request $request)
    // {
    //     userCan(request: $request, permission: 'create_category');
    //     return view('dashboard.categories.create');
    // }//end of create

    // public function store(CategoryRequest $request)
    // {
    //     userCan(request: $request, permission: 'create_category');
    //     try {
    //         $this->categoryService->store($request->validated());
    //         $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.success_operation')];
    //         return redirect()->route('categories.index')->with('toast', $toast);
    //     } catch (\Exception $ex) {
    //         $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
    //         return redirect()->back()->with('toast', $toast);
    //     }
    // }//end of store

    // public function update(CategoryRequest $request, $id)
    // {
    //     userCan(request: $request, permission: 'edit_category');
    //     try {
    //         $this->categoryService->update($id, $request->validated());
    //         $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
    //         return redirect(route('categories.index'))->with('toast', $toast);
    //     } catch (\Exception $ex) {

    //         $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
    //         return redirect()->back()->with('toast', $toast);
    //     }
    // } //end of update

    public function destroy(Request $request, $id)
    {
        try {
            $result = $this->activityLogService->destroy($id);
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
