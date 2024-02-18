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
        $client = $this->getModel()->create($data);
        $client->clientHistory()->create([
            "status"=>ClientStatusEnum::NEW
        ]);
        if (!$client)
            return false ;
        return $client;
    } //end of store

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
        $client->update($data);
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
