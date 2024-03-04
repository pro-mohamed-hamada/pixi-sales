<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.targets') }}</div>

        <div class="card-body">
            
            <div class="datatable table-responsive">
                
                <table class="targetsTable  table text-center table-bordered  table-hover">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.name') }}</th>
                        <th>{{ __('lang.target_value') }}</th>
                        <th>{{ __('lang.target_done') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($user->targets as $target)
                        <tr>
                            <td>{{ $target->id }}</td>
                            <td>{{ $target->target }}</td>
                            <td>{{ $target->target_value }}</td>
                            <td>{{ $target->target_done }}</td>
                            <td>
                                
                                <ul class="list-group list-group-horizontal">
                                    
                                    <li class="list-group-item"><a href="{{ route('users.edit', $target->user_id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                    
                </table>
            </div>
            
        </div>
    </div>
</div>
