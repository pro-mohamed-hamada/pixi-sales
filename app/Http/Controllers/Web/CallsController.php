<?php

namespace App\Http\Controllers\Web;

use App\DataTables\CallsDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ClientService;
use App\Enum\ActivationStatusEnum;
use App\Http\Requests\Web\CallStoreRequest;
use App\Http\Requests\Web\CallUpdateRequest;
use App\Services\CallService;
use Exception;

class CallsController extends Controller
{
    public function __construct(private CallService $callService, private ClientService $clientService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CallsDataTable $dataTable, Request $request)
    {

        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>$withRelations])->render('Dashboard.Calls.index');

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
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        try{
            $call = $this->callService->findById(id: $id);
            $clients = $this->clientService->getAll();
            return view('Dashboard.Calls.edit', compact('clients', 'call'));
        }catch(Exception $e){
            return redirect()->back()->with("message", $e->getMessage());
        }
        
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
    public function destroy(Request $request, $id)
    {
        try {
            $result = $this->callService->destroy($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(),code: 422);
        }
    } //end of destroy
}
