<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.visits') }}</div>

        <div class="card-body">
            
           

            <div class="datatable table-responsive">
                <table class="table text-center table-bordered table-hover">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.client_name') }}</th>
                        <th>{{ __('lang.date') }}</th>
                        <th>{{ __('lang.city') }}</th>
                        <th>{{ __('lang.next_action') }}</th>
                        <th>{{ __('lang.next_action_date') }}</th>
                        <th>{{ __('lang.comment') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($client->visits as $visit)
                        <tr>
                            <td>{{ $visit->id }}</td>
                            <td>{{ $visit->client->name }}</td>
                            <td>{{ $visit->date }}</td>
                            <td>{{ $visit->city->name }}</td>
                            <td>{{ $visit->next_action }}</td>
                            <td>{{ $visit->next_action_date }}</td>
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