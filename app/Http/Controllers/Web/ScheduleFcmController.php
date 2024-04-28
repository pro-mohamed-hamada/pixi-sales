<?php

namespace App\Http\Controllers\Web;

use App\DataTables\ScheduleFcmDataTable;
use App\Enum\FcmEventsNames;
use App\Http\Requests\Web\ScheduleFcmStoreRequest;
use App\Http\Requests\Web\ScheduleFcmUpdateRequest;
use App\Services\ScheduleFcmService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleFcmController extends Controller
{

    public function __construct(protected ScheduleFcmService $scheduleFcmService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ScheduleFcmDataTable $dataTable, Request $request)
    {
        try{
            $filters = array_filter($request->get('filters', []), function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            return $dataTable->with(['filters'=>$filters])->render('Dashboard.ScheduleFcm.index');
        }catch(Exception $e){
            return redirect()->back()->with("message", $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        try{
            $flags = FcmEventsNames::$FLAGS;
            $fcm_channels = FcmEventsNames::$CHANNELS;
            $triggers = FcmEventsNames::$EVENTS;
            return view('Dashboard.ScheduleFcm.create',compact('flags','fcm_channels','triggers'));
        }catch(Exception $e){
            return redirect()->back()->with("message", $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ScheduleFcmStoreRequest $request)
    {
        try {
            $this->scheduleFcmService->store(data: $request->validated());
            return redirect()->route('schedule-fcm.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request, $id)
    {
        try{

            $scheduleFcm = $this->scheduleFcmService->findById(id: $id);
            $flags = FcmEventsNames::$FLAGS;
            $fcm_channels = FcmEventsNames::$CHANNELS;
            $triggers = FcmEventsNames::$EVENTS;
            return view('Dashboard.ScheduleFcm.edit', compact('scheduleFcm','flags','fcm_channels','triggers'));
        
        }catch(Exception $e){
            return redirect()->back()->with("message", $e->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleFcmUpdateRequest $request, $id)
    {
        try {
            $result = $this->scheduleFcmService->update($id, $request->validated());
            if(!$result)
                return redirect()->route('fcm-messaegs.index')->with('message', __('lang.something_went_wrong'));
            return redirect()->route('schedule-fcm.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $result = $this->scheduleFcmService->destroy($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(),code: 422);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     *
     * status method for change is_active column only
     */
    public function status(Request $request, int $id)
    {
        try {
            $result = $this->scheduleFcmService->status(id: $id);
            if (!$result)
                return redirect()->back()->with("message", __('lang.something_went_wrong'));
            return redirect()->back()->with("message", __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of status
}
