<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ClientService;
use App\Enum\ActivationStatusEnum;
use App\Http\Requests\Web\CallStoreRequest;
use App\Http\Requests\Web\CallUpdateRequest;
use App\Services\CallService;

class CallsController extends Controller
{
    public function __construct(private CallService $callService, private ClientService $clientService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $calls = $this->callService->getAll(filters: $filters, perPage: 10);
        return View('Dashboard.Calls.index', compact(['calls']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $clients = $this->clientService->getAll(/*filters: ['is_active'=> ActivationStatusEnum::ACTIVE]*/);
        return view('Dashboard.Calls.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CallStoreRequest $request)
    {
        try {
            $this->callService->store($request->validated());
            return redirect()->route('calls.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->route('calls.index')->with('message', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $call = $this->callService->findById(id: $id);
        if (!$call)
        {
            return redirect()->back()->with("message", __('lang.not_found'));
        }
        $clients = $this->clientService->getAll(filters:['is_active'=>ActivationStatusEnum::ACTIVE]);
        return view('Dashboard.Calls.edit', compact('clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CallUpdateRequest $request, string $id)
    {
        try {
            $this->callService->update($id, $request->validated());
            return redirect()->route('calls.index')->with('message', __('lang.success_operation'));
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
            $result = $this->callService->destroy($id);
            if (!$result)
                return redirect()->back()->with("message", __('lang.not_found'));
            return redirect()->back()->with("message", __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    }
}
