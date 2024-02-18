<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Call;
use App\QueryFilters\CallsFilter;
use Illuminate\Database\Eloquent\Model;

class CallService extends BaseService
{
    public function __construct(private Call $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $calls = $this->getModel()->query()->with($withRelations);
        return $calls->filter(new CallsFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = [])
    {
        $call = $this->getModel()->create($data);
        if (!$call)
            return false ;
        return $call;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $call = $this->findById(id: $id);
        
        return $call->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $call = $this->findById($id);
        return $call->delete();
    } //end of delete

}
