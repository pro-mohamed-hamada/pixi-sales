<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "type"=> $this->getRawOriginal('type'),
            'profile_image' =>$this->getFirstMediaUrl('users') !=""?$this->getFirstMediaUrl('users') : asset('images/default-image.jpg'),
        ];
    }
}
