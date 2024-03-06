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
            ],
            "user_target"=>$this->whenLoaded("targets", UserTargetsResource::collection($this->targets)),
            "personal_achievements"=>$this->whenLoaded("targets",
            [
                "visits"=>[
                    "target_value" => $this->targets()->where('target', (string)TargetsEnum::VISIT)->sum('target_value'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::VISIT)->sum('target_done'),
                ],
                "calls"=>[
                    "target_value" => $this->targets()->where('target', (string)TargetsEnum::CALL)->sum('target_value'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::CALL)->sum('target_done'),
                ],
                "meetings"=>[
                    "target_value" => $this->targets()->where('target', (string)TargetsEnum::MEETING)->sum('target_value'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::MEETING)->sum('target_done'),
                ],
                "proposals"=>[
                    "target_value" => $this->targets()->where('target', (string)TargetsEnum::PROPOSAL)->sum('target_value'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::PROPOSAL)->sum('target_done'),
                ],
                "clients"=>[
                    "target_value" => $this->targets()->where('target', (string)TargetsEnum::CLIENT)->sum('target_value'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::CLIENT)->sum('target_done'),
                ],
                "whatsapp_messages"=>[
                    "target_value" => $this->targets()->where('target', (string)TargetsEnum::WHATSAPP_MESSAGE)->sum('target_value'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::WHATSAPP_MESSAGE)->sum('target_done'),
                ],
            ]
            , null),
       ];
    }

    public $additional =[
        'status'=>true,
        'message'=>'logged_in_successfully'
    ];
}
