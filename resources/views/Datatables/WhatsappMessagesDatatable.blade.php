<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.whatsapp_messages') }}</div>

        <div class="card-body">
            <div class="">
                <h5><a role="button" class="btn btn-primary " href="{{route('whatsapp-messages.create')}}"><i class="fa fa-plus"></i> {{__('lang.create_whatsapp_message')}}</a></h5>
            </div>

            <div class="datatable table-responsive">
                {!! $dataTable->table(['class' => 'table-data table table-bordered text-nowrap border-bottom']) !!}
            </div>
            
        </div>
    </div>
</div>
