<?php

namespace App\Http\Resources;

use App\Models\WhatsappTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ClientActivitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "action"=>$this->action,            
            "activity"=>$this->activity_type,            
            "activity_id"=>$this->activity_id,            
            "created_at"=>$this->created_at->format('Y-m-d h:i:s A'),            
        ];
    }
}
