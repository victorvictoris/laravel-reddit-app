<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Thread\StoreThreadRequest;
use App\Http\Requests\Api\Thread\UpdateThreadRequest;
use App\Models\Thread;
use App\Models\User;
use App\Services\ThreadService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ThreadController extends Controller
{
    public function show(Thread $thread)
    {
        return response()->json(['thread' => $thread]);
    }

    public function store(StoreThreadRequest $request, ThreadService $service)
    {
        $thread = $service->storeThread($request);

        return response()->json(['thread' => $thread]);
    }

    public function update(Thread $thread, UpdateThreadRequest $request, ThreadService $service)
    {
        $response = $service->updateThread($thread, $request);

        if (Arr::exists($response, 'message')) {
            return response()->json(['message' => $response['message']]);
        }

        return response()->json(['thread' => $thread]);
    }

    public function destroy(Thread $thread)
    {
        try {
            $thread->delete();

            return response()->json(['message' => 'You have successfully deleted a thread']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception]);
        }
    }

    public function publish(Thread $thread, Request $request)
    {
        $response = Http::withToken($request->access_token)
            ->asForm()
            ->post('https://oauth.reddit.com/api/submit', [
                'title' => $thread->title,
                'text' => $thread->text,
                'sr' => 'r/'.$thread->subreddit_name,
                'kind' => 'self'
            ]);

        return $response->json();
    }
}
