<div>
    <h1>You've got a new posted form</h1>

    <p>Posted data: </p>
    <ul>
        @foreach($fields as $field)
            <li>{{$field}}</li>
        @endforeach
    </ul>
</div>
