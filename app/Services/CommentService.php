<?php

namespace App\Services;

use App\Http\Requests\Api\Comment\SetVisibilityCommentRequest;
use App\Http\Requests\Api\Comment\StoreCommentRequest;
use App\Http\Requests\Api\Comment\UpdateCommentRequest;
use App\Http\Requests\Api\Comment\VoteCommentRequest;
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Support\Facades\Http;

class CommentService
{
    public function storeComment(StoreCommentRequest $request)
    {
        $user = $request->loggedUser();
        $comment = new Comment();
        if ($parentId = $request->parent_id) {
            if (!Comment::find($parentId)) {
                return ['message' => 'Oops, there is no such a comment to reply at'];
            }
        }
        $comment->parent_id = $request?->parent_id;
        $comment->user_id = $user->id;
        $comment->comment = $request->comment;

        $thread = Thread::find($request->thread_id);
        if (!$thread) {
            return ['message' => 'Oops, there is no such a thread'];
        }

        $thread->comments()->save($comment);
        $thread->refresh();

        return ['comment' => $comment];
    }

    public function updateComment(Comment $comment, UpdateCommentRequest $request)
    {
        return $comment->update($request->validated());
    }

    public function setVisibility(Comment $comment, SetVisibilityCommentRequest $request)
    {
        $thread = Thread::find($comment->commentable->id);
        if ($thread->user_id != $request->loggedUser()->id) {
            return ['message' => 'Oops, you can not change visibility on this comment,
            because you did not create the thread that this comment belongs to'];
        }
        $comment->visible = $request->visible;
        $comment->save();

        return ['comment' => $comment];
    }

    public function voteOnComment(VoteCommentRequest $request)
    {
        //t1 is type prefix for comments,
        // and we get id from comment url (type prefix + comment id = thing)
        $commentId = $request->comment_id;
        $fullName = 't1_'.$commentId;

        $response = Http::withToken($request->access_token)
            ->asForm()
            ->post('https://oauth.reddit.com/api/vote', [
                'dir' => $request->direction,
                'id' => $fullName
            ]);

        if ($response->status() == 404) {
            return ['message' => 'There is no comment with that id'];
        }

        if ($commentId == -1) {
            return ['message' => 'You down-voted on a comment with id: '.$commentId];
        } elseif ($commentId == 0) {
            return ['message' => 'You negated your voting on a comment with id: '.$commentId];
        } else {
            return ['message' => 'You up-voted on a comment with id: '.$commentId];
        }
    }
}
