<?php

namespace App\Http\Controllers\Web;

use App\Enum\ActivationStatusEnum;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ClientStoreRequest;
use App\Http\Requests\Web\ClientHistoryRequest;
use App\Http\Requests\Web\ClientUpdateRequest;
use App\Services\ClientServiceService;
use App\Services\GovernorateService;
use App\Services\ReasonService;
use App\Services\ServiceService;
use App\Services\SourceService;

class ClientsController extends Controller
{
    public function __construct(private ClientService $clientService,
    private GovernorateService $governorateService,
    private ReasonService $reasonService,
    private SourceService $sourceService,
    private ServiceService $serviceService,
    private ClientServiceService $clientServiceService)
    {

    }

    public function index(Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = ['latestStatus'];
        $clients = $this->clientService->getAll(['filters'=>$filters, 'withRelations'=>$withRelations, 'perPage'=>1]);
        return View('Dashboard.Clients.index', compact(['clients']));
    }//end of index

    public function edit(Request $request, $id)
    {

        $client = $this->clientService->findById(id: $id, withRelations:['city', 'services']);
        if (!$client)
        {
            return redirect()->back()->with("message", __('lang.not_found'));
        }
        $governorates = $this->governorateService->getAll();//TODO: get only the active governorates
        $reasons = $this->reasonService->getAll();
        $sources = $this->sourceService->getAll();
        $services = $this->serviceService->getAll(filters:['is_active'=>ActivationStatusEnum::ACTIVE]);
        return view('Dashboard.Clients.edit', compact('governorates', 'client', 'reasons', 'services', 'sources'));
    }//end of create

    public function create(Request $request)
    {
        $governorates = $this->governorateService->getAll();//TODO: get only the active governorates
        $reasons = $this->reasonService->getAll();
        $sources = $this->sourceService->getAll();
        $services = $this->serviceService->getAll(filters:['is_active'=>ActivationStatusEnum::ACTIVE]);
        return view('Dashboard.Clients.create', compact('governorates', 'reasons', 'services', 'sources'));
    }//end of create

    public function store(ClientStoreRequest $request)
    {
        try {
            $this->clientService->store($request->validated());
            return redirect()->route('clients.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('message', $e->getMessage());
        }
    }//end of store

    public function update(ClientUpdateRequest $request, $id)
    {
        try {
            $this->clientService->update($id, $request->validated());
            return redirect()->route('clients.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of update
    public function changeStatus(ClientHistoryRequest $request, $id)
    {
        try {
            $this->clientService->changeStatus($id, $request->validated());
            return redirect()->route('clients.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of change the client status

    public function clientServices(ClientHistoryRequest $request, $id)
    {
        try {
            $this->clientServiceService->store($id, $request->validated());
            return redirect()->route('clients.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of cleint services

    public function destroy($id)
    {
        try {
            $result = $this->clientService->destroy($id);
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
