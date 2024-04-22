<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WhatsappMessagesResource extends JsonResource
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
            'client_id'=>$this->client_id,
            'whatsapp_template_id'=>$this->whatsapp_template_id,
            'title'=>$this->title,
            'content'=>$this->content,
            'phone'=>$this->phone,
            'person_position'=>$this->person_position,
            'whatsapp_url'=>"https://wa.me/".formatPhone(phone: $this->phone, slug: $this->client?->city?->governorate?->country?->slug)."?text=".$this->content,
        ];
    }
}
