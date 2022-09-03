<li class="list-group-item">{{$reply->comment}}</li>
    <ul>
        @foreach($reply->replies as $reply)
            @if($reply->replies->count() > 0)
                @include('comments.replies', ['reply' => $reply])
            @else
                <li class="list-group-item">{{$reply->comment}}</li>
            @endif
        @endforeach
    </ul>


