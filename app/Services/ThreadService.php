<?php

namespace App\Services;

use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ThreadService
{
    public function storeThread($title, $text, $subreddit_name, $user_id)
    {

        $thread = Thread::create(['title' => $title, 'text' => $text,
            'subreddit_name' => $subreddit_name, 'user_id' => $user_id]);

        if (!$thread) {
            throw new \Exception('Thread not created. Try again later');
        }

        return response()->json(['thread' => $thread]);
    }

    public function updateThread(Thread $thread, $title, $text, $subreddit_name, $user_id)
    {
        if ($thread->user_id != $user_id) {
            throw new \Exception('Thread that you try to upload is not yours.');
        }

        if (Carbon::parse($thread->created_at)->addHours(6) > Carbon::now()) {
            throw new \Exception('Oops, you can not edit Thread that is created more than six hours ago');
        }

        $thread->update(['title' => $title, 'text' => $text,
            'subreddit_name' => $subreddit_name]);

        return response()->json(['thread' => $thread]);
    }

    public function publishThread(Thread $thread, $subreddit_name, $access_token)
    {
        $subredditName = $subreddit_name;
        $response = Http::withToken($access_token)
            ->asForm()
            ->post('https://oauth.reddit.com/api/submit', [
                'title' => $thread->title,
                'text' => $thread->text,
                'sr' => 'r/' . $subredditName,
                'kind' => 'self'
            ]);

        $thread->subreddit_name = $subredditName;
        $thread->published_at = Carbon::now();
        $thread->save();

        return response()->json(['message' => $response, 'thread' => $thread]);
    }
}
