<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Call;
use App\Models\WhatsappTemplate;
use App\QueryFilters\CallsFilter;
use App\QueryFilters\WhatsappTemplatesFilter;
use Illuminate\Database\Eloquent\Model;

class WhatsappTemplateService extends BaseService
{
    public function __construct(private WhatsappTemplate $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $whatsappTempaltes = $this->getModel()->query()->with($withRelations);
        return $whatsappTempaltes->filter(new WhatsappTemplatesFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = [])
    {
        $data['is_active'] = isset($data['is_active']) ? 1:0;
        $whatsappTemlate = $this->getModel()->create($data);
        if (!$whatsappTemlate)
            return false ;
        return $whatsappTemlate;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $data['is_active'] = isset($data['is_active']) ? 1:0;
        $whatsappTemplate = $this->findById(id: $id);
        $whatsappTemplate->update($data);
        return $whatsappTemplate;
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $whatsappTemplate = $this->findById($id);
        return $whatsappTemplate->delete();
    } //end of delete

}
