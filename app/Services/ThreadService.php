<?php

namespace App\Services;

use App\Http\Requests\Api\Thread\PublishThreadRequest;
use App\Http\Requests\Api\Thread\StoreThreadRequest;
use App\Http\Requests\Api\Thread\UpdateThreadRequest;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ThreadService
{
    public function storeThread(StoreThreadRequest $request)
    {
        return response()->json(['thread' => Thread::create(['title' => $request->title, 'text' => $request->text,
            'subreddit_name' => $request->subreddit_name, 'user_id' => $request->loggedUser()->id])]);
    }

    public function updateThread(Thread $thread, UpdateThreadRequest $request)
    {
        if (Carbon::parse($thread->created_at)->addHours(6) > Carbon::now() &&
            $thread->user_id == $request->loggedUser()->id) {
            $thread->update(['title' => $request->title, 'text' => $request->text,
                'subreddit_name' => $request->subreddit_name]);

            return response()->json(['thread' => $thread]);
        }

        return response()->json(['message' => 'Oops, you can not edit Thread that is created more than six hours ago']);
    }

    public function destroyThread(Thread $thread)
    {
        try {
            $thread->delete();

            return response()->json(['message' => 'You have successfully deleted a thread']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception]);
        }
    }

    public function publishThread(Thread $thread, PublishThreadRequest $request)
    {
        $subredditName = $request->subreddit_name;
        $response = Http::withToken($request->access_token)
            ->asForm()
            ->post('https://oauth.reddit.com/api/submit', [
                'title' => $thread->title,
                'text' => $thread->text,
                'sr' => 'r/'.$subredditName,
                'kind' => 'self'
            ]);

        $thread->subreddit_name = $subredditName;
        $thread->published_at = Carbon::now();
        $thread->save();

        return response()->json(['message' => $response, 'thread' => $thread]);
    }
}
