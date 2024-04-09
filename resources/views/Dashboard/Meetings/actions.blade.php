<ul class="list-group list-group-horizontal">
    <li class="list-group-item">
        <form method="post" action="{{route('meetings.destroy', $model->id)}}">
            @csrf
            @method('delete')
            <button type="submit" name="delete" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
        </form>
    </li>
    <li class="list-group-item"><a href="{{ route('meetings.edit', $model->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
</ul>