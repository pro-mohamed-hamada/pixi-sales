<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientsResource extends JsonResource
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
            "phone"=>$this->phone,
            "industry"=>$this->industry,
            "company_name"=>$this->company_name,
            "city"=>$this->city->name,
            "other_person_name"=>$this->other_person_name,
            "other_person_phone"=>$this->other_person_phone,
            "other_person_position"=>$this->other_person_position,
            "latest_status"=>$this->whenLoaded("latestStatus", $this->latestStatus),
            "services"=>$this->whenLoaded("services", ServicesResource::collection(ServicesResource::collection($this->services))),
            "visits"=>$this->whenLoaded("services", VisitsResource::collection($this->visits)),
            
        ];
    }
}
