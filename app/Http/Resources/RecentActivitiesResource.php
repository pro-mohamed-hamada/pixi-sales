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
            "status"=>$this->status,
            "icon"=>$this->icon,
            "comment"=>$this->comment,
            "created_at"=>$this->created_at,
        ];
    }
}
