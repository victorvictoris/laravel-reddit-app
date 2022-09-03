<?php

namespace App\Services;

use App\Http\Requests\Api\Thread\StoreThreadRequest;
use App\Http\Requests\Api\Thread\UpdateThreadRequest;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ThreadService
{
    public function storeThread(StoreThreadRequest $request)
    {
        return Thread::create(['title' => $request->title, 'text' => $request->text,
            'subreddit_name' => $request->subreddit_name, 'user_id' => $request->loggedUser()->id]);
    }

    public function updateThread(Thread $thread, UpdateThreadRequest $request)
    {
        if (Carbon::parse($thread->created_at)->addHours(6) > Carbon::now() &&
            $thread->user_id == $request->loggedUser()->id) {
            $thread->update(['title' => $request->title, 'text' => $request->text,
                'subreddit_name' => $request->subreddit_name]);

            return $thread;
        }

        return ['message' => 'Oops, you can not edit Thread that is created more than six hours ago'];
    }
}
