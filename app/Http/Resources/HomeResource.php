<?php

namespace App\Http\Resources;

use App\Enum\TargetsEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user"=>[
                 "id"=> $this->id,
                 "name"=> $this->name,
                 "email"=> $this->email,
                 "latest_status"=>$this->whenLoaded('latestStatus', new UserLatestStatusResource($this->latestStatus), null)
             ],
             "user_target"=>$this->whenLoaded("targets", UserTargetsResource::collection($this->targets->where('created_at', '>=', Carbon::now()->subMonth()))),
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
            'recent_activities'=>$this->getRecentActivities()
        ];
    }
}
