<?php

namespace App\Services;

use App\Enum\ClientStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Client;
use App\QueryFilters\ClientsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
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
        $data['added_by'] = Auth::user()->id;
        // create the client
        $client = $this->getModel()->create($data);
        
        //start add the client status
        $statusData = $this->prepareStatusData(data: $data);
        $client->history()->create($statusData);
        //end add the client status
        
        // start add the client services
        $servicesData = $this->prepareServicesData(data: $data);
        $client->services()->sync($servicesData);
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
        $statusData['date_time'] = Arr::get(array: $data, key: 'date_time', default: null);
        return $statusData;
    }

    private function prepareServicesData(array $data): array
    {
        $servicesData = [];
        if(Arr::has(array: $data, keys: 'services'))
        {
            for($i=0; $i<count($data['services']); $i++)
            {
                $servicesData[$data['services'][$i]] = ['price'=> $data['prices'][$i] ];
            }
        }
        return $servicesData;
    }
    public function changeStatus(int $id, array $data):bool
    {
        $client = $this->findById($id);
        // $this->checkClientLatestStatus(client: $client, newStatus: $data['status']);
        $client->clientHistory()->create($data);
        if (!$client)
            return false ;
        return true;
    } //end of store

    public function checkClientLatestStatus(Client $client, int $newStatus)
    {
        $latestStatus = $client->latestStatus;
        dd($latestStatus->id);
        if($latestStatus->status == $newStatus)
            throw new Exception(message: __('lang.the_status_can_not_be_the_same'), code: 442);
    }

    public function update(int $id, array $data=[])
    {
        $client = $this->findById($id);
        if (!$client)
            return false;
        DB::beginTransaction();
        $client->update($data);
        //start add the client status
        $statusData = $this->prepareStatusData(data: $data);
        if($statusData)
            $client->history()->create($statusData);
        //end add the client status
        
        // start add the client services
        $servicesData = $this->prepareServicesData(data: $data);
        if($servicesData)
            $client->services()->sync($servicesData);
        // end add the client services
        DB::commit();
        if (!$client)
            return false;
        return $client;
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
