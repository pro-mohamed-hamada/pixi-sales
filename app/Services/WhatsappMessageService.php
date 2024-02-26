<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use App\Models\WhatsappMessage;
use App\Models\WhatsappTemplate;
use App\QueryFilters\WhatsappMessagesFilter;
use Illuminate\Database\Eloquent\Model;

class WhatsappMessageService extends BaseService
{
    public function __construct(private WhatsappMessage $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $whatsappMessages = $this->getModel()->query()->with($withRelations);
        return $whatsappMessages->filter(new WhatsappMessagesFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = [])
    {
        $client = Client::find($data['client_id']);
        if(isset($data['whatsapp_template_id']))
        {
            $whatsappTemplate = WhatsappTemplate::find($data['whatsapp_template_id']);
            if(!$client || !$whatsappTemplate)
                return false;
            $data['title'] = $whatsappTemplate->title;
            $data['content'] = $whatsappTemplate->content;
        }else{
            $data['content'] = $data['content'];
        }
        
        $data['phone'] = $client->phone;
        $replaced_values = [
            '@USER_NAME@'=>$client->name,
        ];
        $data['content'] = replaceFlags($data['content'],$replaced_values);
        $whatsappMessage = $this->getModel()->create($data);
        if (!$whatsappMessage)
            return false ;

        return $whatsappMessage;
    } //end of store

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $whatsappMessage = $this->findById($id);
        return $whatsappMessage->delete();
    } //end of delete

}
