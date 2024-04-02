<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.sources') }}</div>

        <div class="card-body">
            <div class="">
                <h5><a role="button" class="btn btn-primary " href="{{route('sources.create')}}"><i class="fa fa-plus"></i> {{__('lang.create_source')}}</a></h5>
            </div>

            <div class="datatable table-responsive">
                
                {{ $dataTable->table() }}
            </div>
            
        </div>
    </div>
</div>
    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
