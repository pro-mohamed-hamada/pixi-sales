<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.activities') }}</div>

        <div class="card-body">
            
           

            <div class="datatable table-responsive">
                <table class="table text-center table-bordered table-hover">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        {{-- <th>{{ __('lang.client_name') }}</th> --}}
                        <th>{{ __('lang.action') }}</th>
                        <th>{{ __('lang.activity') }}</th>
                        <th>{{ __('lang.activity_id') }}</th>
                        <th>{{ __('lang.created_at') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($client->activities as $activity)
                        <tr>
                            <td>{{ $activity->id }}</td>
                            {{-- <td>{{ $activity->client->name }}</td> --}}
                            <td>{{ $activity->action }}</td>
                            <td>{{ $activity->activity_type }}</td>
                            <td>{{ $activity->activity_id }}</td>
                            <td>{{ $activity->created_at }}</td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>