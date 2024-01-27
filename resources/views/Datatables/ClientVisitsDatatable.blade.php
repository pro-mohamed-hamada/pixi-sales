<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.visits') }}</div>

        <div class="card-body">
            
           

            <div class="datatable table-responsive">
                <table class="table text-center table-bordered table-hover">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.client_name') }}</th>
                        <th>{{ __('lang.action_type') }}</th>
                        <th>{{ __('lang.comment') }}</th>
                        <th>{{ __('lang.created_at') }}</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($client->visits as $visit)
                        <tr>
                            <td>{{ $visit->id }}</td>
                            <td>{{ $visit->client->name }}</td>
                            <td>{{ $visit->action_type }}</td>
                            <td>{{ $visit->comment }}</td>
                            <td>{{ $visit->created_at }}</td>
                        </tr>
                        @endforeach 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{ $clients->links() }}                 
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>