<li class="list-group-item list-group-item-primary">{{$comment->comment}}</li>
<ul>
    @foreach($comment->replies as $reply)
        @if($comment->replies->count() > 0)
            @include('comments.replies', ['reply' => $reply])
        @else
            <li class="list-group-item-primary">{{$reply->comment}}</li>
        @endif
    @endforeach
</ul>

