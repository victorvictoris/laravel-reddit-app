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
        return $service->storeThread($request);
    }

    public function update(Thread $thread, UpdateThreadRequest $request, ThreadService $service)
    {
        return $service->updateThread($thread, $request);
    }

    public function destroy(Thread $thread, ThreadService $service)
    {
        $service->destroyThread($thread);
    }

    public function publish(Thread $thread, Request $request, ThreadService $service)
    {
        $service->publishThread($thread, $request);
    }
}
