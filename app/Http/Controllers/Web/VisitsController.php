<?php

namespace App\Http\Controllers\Web;

use App\Enum\ActivationStatusEnum;
use Illuminate\Http\Request;
use App\Services\VisitService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\VisitStoreRequest;
use App\Services\ClientService;

class VisitsController extends Controller
{
    public function __construct(private VisitService $visitService, private ClientService $clientService)
    {

    }

    public function index(Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        $visits = $this->visitService->getAll(['filters'=>$filters, 'withRelations'=>$withRelations, 'perPage'=>1]);
        return View('Dashboard.Visits.index', compact(['visits']));
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

    public function create(Request $request)
    {
        $clients = $this->clientService->getAll();//TODO: get only the active clients
        return view('Dashboard.Visits.create', compact('clients'));
    }//end of create

    public function store(VisitStoreRequest $request)
    {
        try {
            $this->visitService->store($request->validated());
            return redirect()->route('visits.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('visits.index')->with('message', $e->getMessage());
        }
    }//end of store

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

    public function destroy($id)
    {
        try {
            $result = $this->visitService->destroy($id);
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
