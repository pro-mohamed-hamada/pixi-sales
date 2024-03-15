<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ReasonStoreRequest;
use App\Http\Requests\Web\ReasonUpdateRequest;
use App\Services\GovernorateService;
use App\Services\ReasonService;

class ReasonsController extends Controller
{
    public function __construct(private ReasonService $reasonService)
    {

    }

    public function index(Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        $reasons = $this->reasonService->getAll(filters: $filters, withRelations: $withRelations);
        return View('Dashboard.Reasons.index', compact(['reasons']));
    }//end of index

    public function edit(Request $request, $id)
    {

        $reason = $this->reasonService->findById(id: $id);
        if (!$reason)
        {
            return redirect()->back()->with("message", __('lang.not_found'));
        }
        return view('Dashboard.Reasons.edit', compact('reason'));
    }//end of edit
    
    public function create(Request $request)
    {
        return view('Dashboard.Reasons.create');
    }//end of create

    public function store(ReasonStoreRequest $request)
    {
        try {
            $this->reasonService->store($request->validated());
            return redirect()->route('reasons.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('reasons.index')->with('message', $e->getMessage());
        }
    }//end of store

    public function update(ReasonUpdateRequest $request, $id)
    {
        try {
            $this->reasonService->update(id: $id, data: $request->validated());
            return redirect()->route('reasons.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('reasons.index')->with('message', $e->getMessage());
        }
    }//end of update

    public function destroy($id)
    {
        try {
            $result = $this->reasonService->destroy($id);
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
