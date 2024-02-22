<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ClientService;
use App\Http\Requests\Web\WhatsappMessageStoreRequest;
use App\Http\Requests\Web\WhatsappMessageUpdateRequest;
use App\Services\WhatsappMessageService;
use App\Services\WhatsappTemplateService;
use Exception;

class WhatsappMessagesController extends Controller
{
    public function __construct(private WhatsappMessageService $whatsappMessageService, private ClientService $clientService, private WhatsappTemplateService $whatsappTemplateService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $whatsappMessages = $this->whatsappMessageService->getAll(filters: $filters, perPage: 10);
        return View('Dashboard.WhatsappMessages.index', compact(['whatsappMessages']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = $this->clientService->getAll();
        $whatsappTemplates = $this->whatsappTemplateService->getAll();
        return view('Dashboard.WhatsappMessages.create', compact('clients', 'whatsappTemplates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WhatsappMessageStoreRequest $request)
    {
        try {
            $result = $this->whatsappMessageService->store($request->validated());
            if(!$result)
                return redirect()->back()->with('message', __('lang.something_went_wrong'));
            return redirect()->route('whatsapp-messages.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $result = $this->whatsappMessageService->destroy($id);
            if (!$result)
                return redirect()->back()->with("message", __('lang.not_found'));
            return redirect()->back()->with("message", __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    }
}
