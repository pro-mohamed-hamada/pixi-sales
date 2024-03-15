<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Client;
use App\QueryFilters\ClientsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use App\Models\City;
use App\Models\Governorate;
use App\QueryFilters\CitiesFilter;
use Illuminate\Database\Eloquent\Model;

class CityService extends BaseService
{
    public function __construct(private City $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $cities = $this->getModel()->query()->with($withRelations);
        return $cities->filter(new CitiesFilter($filters));
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
        $city = $this->getModel()->create($data);
        if (!$city)
            return false ;
        return $city;
    } //end of store

    public function update($id, array $data = [])
    {
        $city = $this->findById($id);
        $city = $city->update($data);
        if (!$city)
            return false ;
        return $city;
    } //end of update

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $city = $this->findById($id);
        return $city->delete();
    } //end of delete

    // public function status($id)
    // {
    //     $doctor = $this->find($id);
    //     $doctor->is_active = !$doctor->is_active;
    //     return $doctor->save();

    // }//end of status

}
