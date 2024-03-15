<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Client;
use App\QueryFilters\ClientsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use App\Models\Governorate;
use App\QueryFilters\GovernoratesFilter;
use Illuminate\Database\Eloquent\Model;

class GovernorateService extends BaseService
{
    public function __construct(private Governorate $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $governorates = $this->getModel()->query()->with($withRelations);
        return $governorates->filter(new GovernoratesFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters, withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters, withRelations: $withRelations)->get();
    }

    public function store(array $data = [])
    {
        $governorate = $this->getModel()->create($data);
        if (!$governorate)
            return false ;
        return $governorate;
    } //end of store

    public function update($id, array $data = [])
    {
        $governorate = $this->findById($id);
        $governorate = $governorate->update($data);
        if (!$governorate)
            return false ;
        return $governorate;
    } //end of update

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $governorate = $this->findById($id);
        return $governorate->delete();
    } //end of delete

    // public function status($id)
    // {
    //     $doctor = $this->find($id);
    //     $doctor->is_active = !$doctor->is_active;
    //     return $doctor->save();

    // }//end of status

}
