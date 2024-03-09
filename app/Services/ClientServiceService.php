<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ClientService;
use App\QueryFilters\ClientServicesFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ClientServiceService extends BaseService
{
    public function __construct(private ClientService $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): Collection
    {
        $client = Client::find($filters['client_id']);
        return $client->services;
    }

    public function store(array $data = []):Client|Model|bool
    {
        $client = Client::where('id', $data['client_id'])->first();
        if(!$client)
            return false;
        // start add the client services
        $servicesData = $this->prepareServicesData(data: $data);
        $client->services()->sync($servicesData);
        return $client;
    } //end of store

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

    /**
     * @throws NotFoundException
     */
    public function destroy(string $id)
    {
        $clientService = $this->findById(id: $id);
        return $clientService->delete();
    } //end of delete

}
