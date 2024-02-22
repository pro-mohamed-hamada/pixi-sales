<?php

namespace App\Http\Controllers\Web;

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
    public function index(Request $request)
    {
        $filters = $request->all();
        $whatsappTemplates = $this->whatsappTemplateService->getAll(filters: $filters, perPage: 10);
        return View('Dashboard.WhatsappTemplates.index', compact('whatsappTemplates'));
    }

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
    public function destroy(string $id)
    {
        try {
            $result = $this->whatsappTemplateService->destroy($id);
            if (!$result)
                return redirect()->back()->with("message", __('lang.not_found'));
            return redirect()->back()->with("message", __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    }
}
