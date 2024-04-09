<?php

namespace App\Http\Controllers\Web;

use App\DataTables\ClientsDataTable;
use App\Enum\ActivationStatusEnum;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ClientStoreRequest;
use App\Http\Requests\Web\ClientHistoryRequest;
use App\Http\Requests\Web\ClientUpdateRequest;
use App\Services\ClientServiceService;
use App\Services\CountryService;
use App\Services\GovernorateService;
use App\Services\IndustryService;
use App\Services\ReasonService;
use App\Services\ServiceService;
use App\Services\SourceService;
use App\Services\UserService;

class ClientsController extends Controller
{
    public function __construct(private ClientService $clientService,
    private CountryService $countryService,
    private ReasonService $reasonService,
    private SourceService $sourceService,
    private IndustryService $industryService,
    private ServiceService $serviceService,
    private ClientServiceService $clientServiceService,
    private UserService $userService)
    {

    }

    public function index(ClientsDataTable $dataTable, Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = ['latestStatus'];
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>$withRelations])->render('Dashboard.Clients.index');

    }//end of index

    public function clientVisits(Request $request, $id)
    {
        $client = $this->clientService->findById(id: $id, withRelations:['visits']);
        if (!$client)
        {
            return redirect()->back()->with("message", __('lang.not_found'));
        }
        return view('Datatables.ClientVisitsDatatable', compact('client'));
    }//end of create

    public function edit(Request $request, $id)
    {

        $client = $this->clientService->findById(id: $id, withRelations:['city', 'services']);
        if (!$client)
        {
            return redirect()->back()->with("message", __('lang.not_found'));
        }
        $countries = $this->countryService->getAll(filters: ['is_active'=>ActivationStatusEnum::ACTIVE]);
        $reasons = $this->reasonService->getAll();
        $sources = $this->sourceService->getAll();
        $industries = $this->industryService->getAll();
        $services = $this->serviceService->getAll(filters:['is_active'=>ActivationStatusEnum::ACTIVE]);
        $employees = $this->userService->getAll(filters: ['type'=>UserTypeEnum::EMPLOYEE]);
        return view('Dashboard.Clients.edit', compact('countries', 'client', 'reasons', 'services', 'sources', 'industries', 'employees'));
    }//end of create

    public function create(Request $request)
    {
        $countries = $this->countryService->getAll(filters: ['is_active'=>ActivationStatusEnum::ACTIVE]);
        $reasons = $this->reasonService->getAll();
        $sources = $this->sourceService->getAll();
        $industries = $this->industryService->getAll();
        $services = $this->serviceService->getAll(filters:['is_active'=>ActivationStatusEnum::ACTIVE]);
        $employees = $this->userService->getAll(filters: ['type'=>UserTypeEnum::EMPLOYEE]);
        return view('Dashboard.Clients.create', compact('countries', 'reasons', 'services', 'sources', 'industries', 'employees'));
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

    public function destroy(Request $request, $id)
    {
        try {
            $result = $this->clientService->destroy($id);
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
