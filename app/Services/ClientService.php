<?php

namespace App\Services;

use App\Enum\ClientActivityActionEnum;
use App\Enum\ClientStatusEnum;
use App\Enum\TargetsEnum;
use App\Enum\UserTypeEnum;
use App\Exceptions\NotFoundException;
use App\Models\Client;
use App\QueryFilters\ClientsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use App\Models\City;
use App\Models\ClientService as ModelsClientService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ClientService extends BaseService
{
    public function __construct(private Client $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $clients = $this->getModel()->query()->with($withRelations);
        return $clients->filter(new ClientsFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = []):Client|Model|bool
    {
        DB::beginTransaction();
        $user = Auth::user();
        $data['added_by'] = $user->id;
        $data['assigned_to'] = isset($data['assigned_to']) ? $data['assigned_to']:$data['added_by'];

        $city = City::find($data['city_id']);
        if($city)
        {
            $data['phone'] = formatPhone(phone: $data['phone'], slug: $city?->governorate?->country?->slug);
            $data['other_person_phone'] = formatPhone(phone: $data['other_person_phone'], slug: $city?->governorate?->country?->slug);

        }

        // create the client
        $client = $this->getModel()->create($data);
        $user->increaseUserTarget(TargetsEnum::CLIENT);
        //start add the client status
        $statusData = $this->prepareStatusData(data: $data);
        $client->history()->create($statusData);
        $clientStatus = $statusData == ClientStatusEnum::CLOSED ? 1:0;
        if($clientStatus)
        {
            $clientServicesTotalPrice = 0;
            foreach($client->services as $service)
            {
                $clientServicesTotalPrice += $service->pivot->price;
            }
            $user = auth('sanctum')->user();
            $user->increaseUserTarget(TargetsEnum::AMOUNT, $clientServicesTotalPrice);
        }
        //end add the client status
        
        // start add the client services
        $servicesData = $this->prepareServicesData(data: $data);
        if($servicesData)
        {
            $client->services()->sync($servicesData);
            foreach($client->services as $service)
            {
                $clientService = ModelsClientService::where('client_id', $client->id)
                ->where('service_id', $service->id)->first();
                if($clientService)
                    $clientService->activities()->create([ 'client_id'=>$client->id, 'action'=>ClientActivityActionEnum::ADDED]);
            }
        }
        // end add the client services
        DB::commit();
        if (!$client)
            return false ;
        return $client;
    } //end of store

    private function pepareClientData(array $data): array
    {
        $clientData = [];
        return $clientData;
    }

    private function prepareStatusData(array $data): array
    {
        $statusData = [];
        $statusData['status']    = Arr::get(array: $data, key: 'status', default: ClientStatusEnum::NEW);
        $statusData['reason_id'] = Arr::get(array: $data, key: 'reason_id', default: null);
        $statusData['comment']   = Arr::get(array: $data, key: 'comment', default: null);
        $statusData['added_by']   = Auth::user()->id;
        $statusData['date_time'] = Arr::get(array: $data, key: 'date_time', default: null);
        return $statusData;
    }

    private function prepareServicesData(array $data): array
    {
        $servicesData = [];
        $nextAction = isset($data['next_action']) ? $data['next_action']:null;
        $nextActionDate = isset($data['next_action_date']) ? $data['next_action_date']:null;
        $comment = isset($data['comment']) ? $data['comment']:null;
        $addedBy = Auth::user()->id;
        if(Arr::has(array: $data, keys: 'services'))
        {
            for($i=0; $i<count($data['services']); $i++)
            {
                $servicesData[$data['services'][$i]] = ['price'=> $data['prices'][$i], 'next_action'=>$nextAction,'next_action_date'=>$nextActionDate, 'comment'=>$comment, 'added_by'=>$addedBy];
            }
        }
        return $servicesData;
    }
    public function changeStatus(int $id, array $data):bool
    {
        $client = $this->findById($id);
        $client->checkStatus($data['status']);
        $client->history()->create($data);
        
        
        $clientStatus = $data['status'] == ClientStatusEnum::CLOSED ? 1:0;
        if($clientStatus)
        {
            $clientServicesTotalPrice = 0;
            foreach($client->services as $service)
            {
                $clientServicesTotalPrice += $service->pivot->price;
            }
            $user = auth('sanctum')->user();
            $user->increaseUserTarget(TargetsEnum::AMOUNT, $clientServicesTotalPrice);
        }

        if (!$client)
            return false ;
        return true;
    } //end of store

    public function checkClientLatestStatus(Client $client, int $newStatus)
    {
        $latestStatus = $client->latestStatus;
        if($latestStatus->status == $newStatus)
            throw new Exception(message: __('lang.the_status_can_not_be_the_same'), code: 442);
    }

    public function update(int $id, array $data=[])
    {
        $client = $this->findById($id);
        if (!$client)
            return false;
        DB::beginTransaction();
        $data['assigned_to'] = isset($data['assigned_to']) ? $data['assigned_to']:$client->assigned_to;
        $city = City::find($data['city_id']);
        if($city)
        {
            $data['phone'] = formatPhone(phone: $data['phone'], slug: $city?->governorate?->country?->slug);
            $data['other_person_phone'] = formatPhone(phone: $data['other_person_phone'], slug: $city?->governorate?->country?->slug);

        }
        $client->update($data);
        //start add the client status
        $statusData = $this->prepareStatusData(data: $data);
        if($statusData)
        {
            $client->checkStatus($statusData['status']);
            $client->history()->create($statusData);
            $clientStatus = $statusData == ClientStatusEnum::CLOSED ? 1:0;
            if($clientStatus)
            {
                $clientServicesTotalPrice = 0;
                foreach($client->services as $service)
                {
                    $clientServicesTotalPrice += $service->pivot->price;
                }
                $user = auth('sanctum')->user();
                $user->increaseUserTarget(TargetsEnum::AMOUNT, $clientServicesTotalPrice);
            }
        }
        //end add the client status
        
        // start add the client services
        $servicesData = $this->prepareServicesData(data: $data);
        if($servicesData)
        {
            $client->services()->sync($servicesData);
            foreach($client->services as $service)
            {
                $clientService = ModelsClientService::where('client_id', $client->id)
                ->where('service_id', $service->id)->first();
                if($clientService)
                    $clientService->activities()->create([ 'client_id'=>$client->id, 'action'=>ClientActivityActionEnum::UPDATED]);
            }
        }
    
        // end add the client services
        DB::commit();
        if (!$client)
            return false;
        return $client;
    }

    public function reassignClient($id, array $data)
    {
        $client = $this->findById(id: $id);
        $status =$client->update(['assigned_to'=>$data['assigned_to']]);
        return $status;
    }
    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $client = $this->findById($id);
        return $client->delete();
    } //end of delete

    public function status($id)
    {
        $doctor = $this->findById($id);
        $doctor->is_active = !$doctor->is_active;
        return $doctor->save();

    }//end of status

}
