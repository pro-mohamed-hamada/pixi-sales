<?php

namespace App\Http\Controllers\Web;

use App\DataTables\MeetingsDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ClientService;
use App\Http\Requests\Web\MeetingStoreRequest;
use App\Http\Requests\Web\MeetingUpdateRequest;
use App\Services\MeetingService;
use Exception;

class MeetingsController extends Controller
{
    public function __construct(private MeetingService $meetingService, private ClientService $clientService)
    {
        
    }
    
    public function index(MeetingsDataTable $dataTable, Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>$withRelations])->render('Dashboard.Meetings.index');

    }//end of index

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = $this->clientService->getAll();
        return view('Dashboard.Meetings.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MeetingStoreRequest $request)
    {
        try {
            $this->meetingService->store($request->validated());
            return redirect()->route('meetings.index')->with('message', __('lang.success_operation'));
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
            $meeting = $this->meetingService->findById(id: $id);
            $clients = $this->clientService->getAll();
            return view('Dashboard.Meetings.edit', compact('clients', 'meeting'));
        }catch(Exception $e){
            return redirect()->back()->with("message", $e->getMessage());
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MeetingUpdateRequest $request, string $id)
    {
        try {
            $this->meetingService->update($id, $request->validated());
            return redirect()->route('meetings.index')->with('message', __('lang.success_operation'));
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
            $result = $this->meetingService->destroy($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(),code: 422);
        }
    } //end of destroy
}
