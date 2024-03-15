<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Source;
use App\QueryFilters\SourcesFilter;
use Illuminate\Database\Eloquent\Model;

class SourceService extends BaseService
{
    public function __construct(private Source $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $sources = $this->getModel()->query()->with($withRelations);
        return $sources->filter(new SourcesFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = [])
    {
        $source = $this->getModel()->create($data);
        if (!$source)
            return false ;
        return $source;
    } //end of store

    public function update($id, array $data = [])
    {
        $source = $this->findById($id);
        $source = $source->update($data);
        if (!$source)
            return false ;
        return $source;
    } //end of update

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $source = $this->findById($id);
        return $source->delete();
    } //end of delete

    // public function status($id)
    // {
    //     $doctor = $this->find($id);
    //     $doctor->is_active = !$doctor->is_active;
    //     return $doctor->save();

    // }//end of status

}
