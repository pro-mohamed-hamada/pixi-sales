<?php

namespace App\Http\Controllers\Web;

use App\DataTables\WhatsappTemplatesDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\WhatsappTemplateStoreRequest;
use App\Http\Requests\Web\WhatsappTemplateUpdateRequest;
use App\Services\WhatsappTemplateService;
use Exception;

class WhatsappTemplatesController extends Controller
{
    public function __construct(private WhatsappTemplateService $whatsappTemplateService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(WhatsappTemplatesDataTable $dataTable, Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>$withRelations])->render('Dashboard.WhatsappTemplates.index');

    }//end of index

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.WhatsappTemplates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WhatsappTemplateStoreRequest $request)
    {
        try {
            $this->whatsappTemplateService->store($request->validated());
            return redirect()->route('whatsapp-templates.index')->with('message', __('lang.success_operation'));
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
            $whatsappTemplate = $this->whatsappTemplateService->findById(id: $id);
            return view('Dashboard.WhatsappTemplates.edit', compact('whatsappTemplate'));
        }catch(Exception $e){
            return redirect()->back()->with("message", $e->getMessage());
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WhatsappTemplateUpdateRequest $request, string $id)
    {
        try {
            $this->whatsappTemplateService->update($id, $request->validated());
            return redirect()->route('whatsapp-templates.index')->with('message', __('lang.success_operation'));
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
            $result = $this->whatsappTemplateService->destroy($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(),code: 422);
        }
    } //end of destroy
}
