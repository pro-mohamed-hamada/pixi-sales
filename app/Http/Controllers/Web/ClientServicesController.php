<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ClientService;
use App\Enum\ActivationStatusEnum;
use App\Http\Requests\Web\ClientServiceStoreRequest;
use App\Http\Requests\Web\ClientServiceUpdateRequest;
use App\Services\ClientServiceService;
use Exception;

class ClientServicesController extends Controller
{
    public function __construct(private ClientServiceService $clientServiceService, private ClientService $clientService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $clientServices = $this->clientServiceService->getAll(filters: $filters, perPage: 10);
        return View('Dashboard.ClientServices.index', compact(['clientServices']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = $this->clientService->getAll(/*filters: ['is_active'=> ActivationStatusEnum::ACTIVE]*/);
        return view('Dashboard.ClientServices.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientServiceStoreRequest $request)
    {
        try {
            $this->clientServiceService->store($request->validated());
            return redirect()->route('clientServices.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        try{
            $clientService = $this->clientServiceService->findById(id: $id);
            $clients = $this->clientService->getAll();
            return view('Dashboard.ClientServices.edit', compact('clients', 'clientService'));
        }catch(Exception $e){
            return redirect()->back()->with("message", $e->getMessage());
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientServiceUpdateRequest $request, string $id)
    {
        try {
            $this->clientServiceService->update($id, $request->validated());
            return redirect()->route('clientServices.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $result = $this->clientServiceService->destroy($id);
            if (!$result)
                return redirect()->back()->with("message", __('lang.not_found'));
            return redirect()->back()->with("message", __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    }
}
