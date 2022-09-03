<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\SetVisibilityCommentRequest;
use App\Http\Requests\Api\Comment\StoreCommentRequest;
use App\Http\Requests\Api\Comment\UpdateCommentRequest;
use App\Http\Requests\Api\Comment\VoteCommentRequest;
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
        return $service->storeComment($request);
    }

    public function update(Comment $comment, UpdateCommentRequest $request, CommentService $service)
    {
       return $service->updateComment($comment, $request);
    }

    //Implemented as Soft Delete, for better tracking
    public function destroy(Comment $comment, CommentService $service)
    {
        return $service->destroyComment($comment);
    }

    public function visible(Comment $comment, SetVisibilityCommentRequest $request, CommentService $service)
    {
        return $service->setVisibility($comment, $request);
    }

    public function vote(VoteCommentRequest $request, CommentService $service)
    {
        return $service->voteOnComment($request);
    }
}
