<li class="list-group-item-{{$color}} list-group-item">{{$reply->comment}}</li>
    <ul>
        @foreach($reply->replies as $reply)
            @if($reply->replies->count() > 0)
                @include('comments.replies', ['reply' => $reply, 'color' => \Illuminate\Support\Arr::random($colors)])
            @else
                <li class="list-group-item-{{\Illuminate\Support\Arr::random($colors)}} list-group-item">{{$reply->comment}}</li>
            @endif
        @endforeach
    </ul>


