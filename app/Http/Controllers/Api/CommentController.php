<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\SetVisibilityCommentRequest;
use App\Http\Requests\Api\Comment\StoreCommentRequest;
use App\Http\Requests\Api\Comment\UpdateCommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CommentController extends Controller
{
    public function show(Comment $comment)
    {

        return response()->json(['comment' => $comment]);
    }

    public function store(StoreCommentRequest $request, CommentService $service)
    {
        $response = $service->storeComment($request);

        if (Arr::exists($response, 'message')) {

            return response()->json(['message' => $response['message']], 404);
        } else {

            return response()->json(['comment' => $response['comment']]);
        }
    }

    public function update(Comment $comment, UpdateCommentRequest $request, CommentService $service)
    {
        $service->updateComment($comment, $request);

        return response()->json(['comment' => $comment]);
    }

    //Implemented as Soft Delete, for better tracking
    public function destroy(Comment $comment)
    {
        try {
            $comment->delete();

            return response()->json(['message' => 'You have successfully deleted a comment.']);
        } catch (\Exception $exception) {

            return response()->json(['message' => $exception]);
        }
    }

    public function visible(Comment $comment, SetVisibilityCommentRequest $request, CommentService $service)
    {
        $response = $service->setVisibility($comment, $request);

        if (Arr::exists($response, 'message')) {

            return response()->json(['message' => $response['message']], 403);
        } else {

            return response()->json(['comment' => $response['comment']]);
        }
    }
}
