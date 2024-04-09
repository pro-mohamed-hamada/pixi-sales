<ul class="list-group list-group-horizontal">
    <li class="list-group-item">
        <form method="post" action="{{route('whatsapp-messages.destroy', $model->id)}}">
            @csrf
            @method('delete')
            <button type="submit" name="delete" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
        </form>
    </li>
</ul>