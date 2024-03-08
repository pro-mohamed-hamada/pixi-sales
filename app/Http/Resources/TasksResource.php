<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
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
            "client"=>$this->whenLoaded('client', [
                'id'=>$this->client->id,
                'name'=>$this->client->name,
            ], null),
            "next_action"=>$this->next_action,
            "next_action_date"=>$this->next_action_date,
            "comment"=>$this->comment,
        ];
    }
}