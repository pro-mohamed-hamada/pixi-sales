<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\ScheduleFcm;
use App\QueryFilters\ScheduleFcmFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
class ScheduleFcmService extends BaseService
{
    public function __construct(private ScheduleFcm $model)
    {
        
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [], $withRelation = []): Builder
    {
        $scheduleFcm = $this->getModel()->query()->with($withRelation);
        return $scheduleFcm->filter(new ScheduleFcmFilter($filters));
    }

    public function getAll(array $filters = [], array $withRelation = [], $perPage = 15): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet(filters: $filters, withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function store(array $data = [])
    {
        $data['is_active']  = isset($data['is_active'])? 1:0;
        $scheduleFcm = $this->getModel()->create($data);
        return $scheduleFcm;
    }

    /**
     * @throws NotFoundException
     */
    public function update(int $id, array $data): bool
    {
        $scheduleFcm = $this->findById(id: $id);
        $data['is_active']  = isset($data['is_active'])? 1:0;
        return $scheduleFcm->update($data);
    }

    public function destroy(int $id)
    {
        $scheduleFcm = $this->findById(id: $id);
        return $scheduleFcm->delete();
    }
    public function status($id): bool
    {
        $scheduleFcm = $this->findById(id: $id);
        $scheduleFcm->is_active = !$scheduleFcm->is_active;
        return $scheduleFcm->save();

    }//end of status
}