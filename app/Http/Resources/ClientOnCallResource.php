<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientOnCallResource extends JsonResource
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
            "name"=>$this->name,
            "company_name"=>$this->company_name,
            // "services"=>$this->whenLoaded("services", ClientServicesResource::collection($this->services->whereNotNull('next_action')->last()), null),
            "visits"=>$this->whenLoaded("visits", !empty($this->visits()->whereNotNull('next_action')->latest()->first()) ? new LatestActionResource($this->visits()->whereNotNull('next_action')->latest()->first()):null, null),
            "calls"=>$this->whenLoaded("calls", empty($this->calls()->whereNotNull('next_action')->latest()->first()) ? new LatestActionResource($this->calls()->whereNotNull('next_action')->latest()->first()):null, null),
            "meetings"=>$this->whenLoaded("meetings", empty($this->meetings()->whereNotNull('next_action')->latest()->first()) ? new LatestActionResource($this->meetings()->whereNotNull('next_action')->latest()->first()):null, null),            
        ];
    }
}
