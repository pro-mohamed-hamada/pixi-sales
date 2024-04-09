<ul class="list-group list-group-horizontal">
    <li class="list-group-item">
        <form method="post" action="{{route('users.destroy', $model->id)}}">
            @csrf
            @method('delete')
            <button type="submit" name="delete" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
        </form>
    </li>
    <li class="list-group-item"><a href="{{ route('users.edit', $model->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
    <li class="list-group-item"><a href="{{ route('users.show', $model->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></li>
    <li class="list-group-item"><a href="{{ route('user.targets', $model->id) }}" class="has-data btn btn-primary">{{__('lang.targets')}}</a></li>
</ul>