<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ClientService;
use App\QueryFilters\ClientServicesFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
            $client->services()->detach($data['service_id'], ['price'=> $data['price']]);
            $client->services()->attach($data['service_id'], ['price'=> $data['price']]);
        return $client;
    } //end of store

    /**
     * @throws NotFoundException
     */
    public function destroy(string $id)
    {
        $clientService = $this->findById(id: $id);
        return $clientService->delete();
    } //end of delete

}
