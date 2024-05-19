<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.clients') }}</div>

        <div class="card-body">
            <div class="">
                <a role="button" class="btn btn-primary " href="{{route('clients.create')}}"><i class="fa fa-plus"></i> {{__('lang.create_client')}}</a>
                <a role="button" class="btn btn-primary " href="{{route('clients.import_view')}}"><i class="fa fa-upload"></i> {{__('lang.import')}}</a>
                <a role="button" target="_blanck" class="btn btn-primary " href="{{route('clients.import_template')}}"><i class="fa fa-download"></i> {{__('lang.download_template')}}</a>
            </div>

            <div class="datatable table-responsive">
                {!! $dataTable->table(['class' => 'table-data table table-bordered text-nowrap border-bottom']) !!}
            </div>
            
        </div>
    </div>
</div>
