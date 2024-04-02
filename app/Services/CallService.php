<?php

namespace App\Services;

use App\Enum\ClientActivityActionEnum;
use App\Enum\TargetsEnum;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Call;
use App\Models\User;
use App\QueryFilters\CallsFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = Auth::user();
        $data['added_by'] = $user->id;
        DB::beginTransaction();
        $call = $this->getModel()->create($data);
        $user->increaseUserTarget(TargetsEnum::CALL);
        $call->activities()->create([ 'client_id'=>$call->client->id, 'action'=>ClientActivityActionEnum::ADDED]);
        DB::commit();
        if (!$call)
            return false ;
        return $call;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $call = $this->findById(id: $id);
        $call->update($data);
        $call->activities()->create([ 'client_id'=>$call->client->id, 'action'=>ClientActivityActionEnum::UPDATED]);
        return $call;
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
