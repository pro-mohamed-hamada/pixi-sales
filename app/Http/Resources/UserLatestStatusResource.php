<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLatestStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'is_working'=>$this->end_work_time ? false:true,
            'start_work_time'=>$this->start_work_time,
            'end_work_time'=>$this->end_work_time,
            'hours'=>$this->hours,
            'start_work_lat'=>$this->start_work_lat,
            'start_work_lng'=>$this->start_work_lng,
            'end_work_lat'=>$this->end_work_lat,
            'end_work_lng'=>$this->end_work_lng,
        ];
    }
}
