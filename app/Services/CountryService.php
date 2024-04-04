<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Client;
use App\QueryFilters\ClientsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use App\Models\Country;
use App\QueryFilters\CountriesFilter;
use Illuminate\Database\Eloquent\Model;

class CountryService extends BaseService
{
    public function __construct(private Country $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $countries = $this->getModel()->query()->with($withRelations);
        return $countries->filter(new CountriesFilter($filters));
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
        $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $country = $this->getModel()->create($data);
        if (!$country)
            return false ;
        return $country;
    } //end of store

    public function update($id, array $data = [])
    {
        $country = $this->findById($id);
        if (!$country)
            return false ;
        $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $country = $country->update($data);
        return $country;
    } //end of update

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $country = $this->findById($id);
        return $country->delete();
    } //end of delete

    // public function status($id)
    // {
    //     $doctor = $this->find($id);
    //     $doctor->is_active = !$doctor->is_active;
    //     return $doctor->save();

    // }//end of status

}
