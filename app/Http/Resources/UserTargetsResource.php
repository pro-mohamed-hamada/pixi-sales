<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTargetsResource extends JsonResource
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
            "target_value"=>$this->pivot->target_value,            
            "meeting_time"=>$this->pivot->meeting_date,            
            "target_done"=>$this->pivot->target_done,            
            "done_persentage"=>($this->pivot->target_done/$this->pivot->target_value)*100,            
        ];
    }
}
