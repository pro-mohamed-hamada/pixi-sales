<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentActivitiesResource extends JsonResource
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
            "action_type"=>$this->action_type,
            "status"=>$this->whenNotNull($this->status),
            "company_name"=>$this->whenNotNull($this->company_name),
            "city"=>$this->whenNotNull($this->city->name),
            "icon"=>$this->icon,
            "comment"=>$this->comment,
            "created_at"=>$this->created_at->format('Y-m-d h:i:s A'),
        ];
    }
}
