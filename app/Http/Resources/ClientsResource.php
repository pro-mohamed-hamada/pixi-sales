<?php

namespace App\Http\Resources;

use App\Models\WhatsappTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ClientsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->assignedTo;
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "phone"=>$this->phone,
            "industry"=>$this->industry,
            "company_name"=>$this->company_name,
            "city"=>$this->city->name,
            "other_person_name"=>$this->other_person_name,
            "other_person_phone"=>$this->other_person_phone,
            "other_person_position"=>$this->other_person_position,
            "facebook_url"=>$this->facebook_url,
            "source"=>$this->whenLoaded('source', $this->source->title),
            "whatsapp_messages_count"=>$this->whenLoaded('whatsappMessages', $this->whatsappMessages->count()),
            "latest_status"=>$this->whenLoaded("latestStatus", $this->latestStatus),
            "user"=>new UserResource($user),
            "services"=>$this->whenLoaded("services",
            [
                'client_services'=>ClientServicesResource::collection($this->services),
                'whatsapp_templates'=>WhatsappTemplate::where('action', 'Service')->select('id', 'title', 'content')->get(),
            ]
            , null),
            "visits"=>$this->whenLoaded("visits", VisitsResource::collection($this->visits), null),
            "calls"=>$this->whenLoaded("calls", CallsResource::collection($this->calls), null),
            "meetings"=>$this->whenLoaded("meetings", MeetingsResource::collection($this->meetings), null),
            
        ];
    }
}
