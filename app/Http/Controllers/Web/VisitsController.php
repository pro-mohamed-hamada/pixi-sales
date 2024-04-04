<?php

namespace App\Http\Controllers\Web;

use App\Enum\ActivationStatusEnum;
use Illuminate\Http\Request;
use App\Services\VisitService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\VisitStoreRequest;
use App\Http\Requests\Web\VisitUpdateRequest;
use App\Services\ClientService;
use App\Services\CountryService;
use App\Services\GovernorateService;
use Exception;

class VisitsController extends Controller
{
    public function __construct(private VisitService $visitService, private ClientService $clientService, private CountryService $countryService)
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

    public function edit(Request $request, $id)
    {
        try{
            $visit = $this->visitService->findById(id: $id);
            $clients = $this->clientService->getAll();
            $countries = $this->countryService->getAll(filters: ['is_active'=>ActivationStatusEnum::ACTIVE]);
            return view('Dashboard.Visits.edit', compact('visit', 'clients', 'countries'));
        }catch(Exception $e){
            return redirect()->back()->with("message", $e->getMessage());
        }
    }//end of edit

    public function create(Request $request)
    {
        $clients = $this->clientService->getAll();//TODO: get only the active clients
        $countries = $this->countryService->getAll(filters: ['is_active'=>ActivationStatusEnum::ACTIVE]);
        return view('Dashboard.Visits.create', compact('clients', 'countries'));
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

    /**
     * Update the specified resource in storage.
     */
    public function update(VisitUpdateRequest $request, string $id)
    {
        try {
            $this->visitService->update($id, $request->validated());
            return redirect()->route('visits.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    }

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
