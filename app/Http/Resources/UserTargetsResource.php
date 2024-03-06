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
            "target"=>$this->target,
            "icon"=>$this->target_icon,
            "target_value"=>$this->target_value,            
            "target_done"=>$this->target_done,            
            "done_persentage"=>($this->target_done/$this->target_value)*100,            
        ];
    }
}
