<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use App\Models\Service;
use App\QueryFilters\ServicesFilter;
use Illuminate\Database\Eloquent\Model;

class ServiceService extends BaseService
{
    public function __construct(private Service $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $services = $this->getModel()->query()->with($withRelations);
        return $services->filter(new ServicesFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

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

}
