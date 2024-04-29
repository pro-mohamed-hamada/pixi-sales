<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\NotificationStoreRequest;
use App\Http\Requests\Web\NotificationUpdateRequest;
use App\Http\Resources\NotificationsResource;
use App\Services\NotificationService;
use Exception;

class NotificationsController extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {

    }

    public function index(Request $request)
    {
        // try{
            $filters = $request->all();
            $filters['user_id'] = auth('sanctum')->user()->id;
            $userNotifications = $this->notificationService->getUserNotifications();
            return apiResponse(data: NotificationsResource::collection($userNotifications));
    
        // }catch(Exception $e){
        //     return apiResponse(message: $e->getMessage(), code: 442);
        // }
    }//end of index

    public function markAsRead(string $id)
    {
        try{
            $status = $this->notificationService->markAsRead(id: $id);
            return apiResponse(message: __('lang.success_operation'));
    
        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    } //end of update

    public function destroy(string $id)
    {
        try {
            $result = $this->notificationService->destroy($id);
            return apiResponse(message: __('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 442);
        }
    } //end of destroy

}
