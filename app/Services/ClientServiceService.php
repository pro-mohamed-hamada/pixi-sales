<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Client;
use App\QueryFilters\ClientsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use App\Models\ClientService;
use App\QueryFilters\ClientServicesFilter;
use Illuminate\Database\Eloquent\Model;

class ClientServiceService extends BaseService
{
    public function __construct(private ClientService $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $clientServices = $this->getModel()->query()->with($withRelations);
        return $clientServices->filter(new ClientServicesFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = []):Client|Model|bool
    {
        $client = Client::where('id', $data['client_id'])->first();
        $service = $client->services()->create($data);
        if (!$service)
            return false ;
        return $client;
    } //end of store


    // /**
    //  * @throws NotFoundException
    //  */
    // public function find(int $clientId , array $withRelations = []): Client|Model|bool
    // {
    //     $client =  $this->getModel()->with($withRelations)->find($clientId);
    //     if (!$client)
    //        throw new NotFoundException(trans('lang.not_found'));
    //     return $client;
    // }

    // /**
    //  * @throws NotFoundException
    //  */
    // public function delete($id)
    // {
    //     $doctor = $this->find($id);
    //     $doctor->deleteAttachments();
    //     return $doctor->delete();
    // } //end of delete

}
