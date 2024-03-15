<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use App\Models\Reason;
use App\QueryFilters\ReasonsFilter;
use Illuminate\Database\Eloquent\Model;

class ReasonService extends BaseService
{
    public function __construct(private Reason $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $reasons = $this->getModel()->query()->with($withRelations);
        return $reasons->filter(new ReasonsFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = [])
    {
        $reason = $this->getModel()->create($data);
        if (!$reason)
            return false ;
        return $reason;
    } //end of store


    public function update($id, array $data = [])
    {
        $reason = $this->findById($id);
        $reason = $reason->update($data);
        if (!$reason)
            return false ;
        return $reason;
    } //end of update

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $reason = $this->findById($id);
        return $reason->delete();
    } //end of delete

    // public function status($id)
    // {
    //     $doctor = $this->find($id);
    //     $doctor->is_active = !$doctor->is_active;
    //     return $doctor->save();

    // }//end of status

}
