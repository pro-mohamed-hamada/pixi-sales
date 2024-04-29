<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

       return [
           'id'=>$this->id,
           'title'=>$this->data['title'],
           'content'=>$this->data['content'],
           'read_at'=>$this->read_at,
           'created_at'=>$this->created_at->format('Y-m-d h:i:s A'),
       ];
    }
}
