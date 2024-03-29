<?php

namespace App\Http\Resources;

use App\Enum\ImageTypeEnum;
use App\Enum\TargetsEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class AuthUserResource extends JsonResource
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
           "token"=>$request->bearerToken()?? $this->getToken(),
           "token_type"=>'Bearer',
           "user"=>[
                "id"=> $this->id,
                "name"=> $this->name,
                "email"=> $this->email,
                'profile_image' =>$this->getFirstMediaUrl('users') !=""?$this->getFirstMediaUrl('users') : asset('images/default-image.jpg'),
            ],
       ];
    }

    public $additional =[
        'status'=>true,
        'message'=>'logged_in_successfully'
    ];
}
