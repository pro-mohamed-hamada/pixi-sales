<?php

namespace App\Http\Resources;

use App\Enum\TargetsEnum;
use App\Enum\ClientStatusEnum;
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
                     "clients" => $this->visits()->distinct()->count('client_id'),
                     "target_done" => $this->targets()->where('target', (string)TargetsEnum::VISIT)->sum('target_done'),
                 ],
                 "calls"=>[
                    "clients" => $this->calls()->distinct()->count('client_id'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::CALL)->sum('target_done'),
                 ],
                 "meetings"=>[
                    "clients" => $this->meetings()->distinct()->count('client_id'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::MEETING)->sum('target_done'),
                 ],
                 "proposals"=>[
                    "clients" => $this->assignedClients()->whereHas('latestStatus', function($query){
                        $query->where('added_by', $this->id)->where('status', ClientStatusEnum::PROPOSAL);
                    })->count('id'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::PROPOSAL)->sum('target_done'),
                 ],
                 "clients"=>[
                    "clients" => $this->addedByClients()->distinct()->count('id'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::CLIENT)->sum('target_done'),
                 ],
                 "whatsapp_messages"=>[
                    "clients" => $this->whatsappMessages()->distinct()->count('client_id'),
                    "target_done" => $this->targets()->where('target', (string)TargetsEnum::WHATSAPP_MESSAGE)->sum('target_done'),
                 ],
                 "amounts"=>[
                    "clients" => $this->assignedClients()->whereHas('latestStatus', function($query){
                        $query->where('added_by', $this->id)->where('status', ClientStatusEnum::CLOSED);
                    })->count('id'),
                     "target_done" => $this->targets()->where('target', (string)TargetsEnum::AMOUNT)->sum('target_done'),
                 ],
             ]
             , null),
            'recent_activities'=>$this->getRecentActivities()
        ];
    }
}
