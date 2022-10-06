<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Thread\StoreThreadRequest;
use App\Models\Thread;
use App\Services\ThreadService;

class ThreadController extends Controller
{
    public function __construct(private Thread $thread, private StoreThreadRequest $request,
                                private ThreadService $service)
    {
    }

    public function show()
    {
        return response()->json(['thread' => $this->thread]);
    }

    public function store()
    {
        try {
            $thread = $this->service
                ->storeThread($this->request->title, $this->request->text,
                    $this->request->subreddit_name, $this->request->loggedUser());
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }

        return response()->json(['thread' => $thread]);
    }

    public function update()
    {
        try {
            $thread = $this->service
                ->updateThread($this->thread, $this->request->title,
                    $this->request->subreddit_name, $this->request->text, $this->request->loggedUser());
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }

        return $thread;
    }

    public function destroy()
    {
        try {
            $this->thread->delete();

            return response()->json(['message' => 'You have successfully deleted a thread']);
        } catch (\Exception $exception) {

            return response()->json(['message' => $exception->getMessage()]);
        }
    }

    public function publish()
    {
        $this->service->publishThread($this->thread, $this->request->subreddit_name, $this->request->access_token);
    }
}
