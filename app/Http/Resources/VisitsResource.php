<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitsResource extends JsonResource
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
            "date"=>$this->date,
            "city"=>$this->whenLoaded('city', new CitiesResource($this->city), null),
            "next_action"=>$this->next_action,
            "next_action_date"=>$this->next_action_date,
            "comment"=>$this->comment,
        ];
    }
}
