<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show(Comment $comment)
    {
        return response()->json(['comment' => $comment]);

    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy(Comment $comment)
    {
        try {
            $comment->delete();

            return response()->json(['message' => 'You have successfully deleted a comment.']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception]);
        }
    }

    public function setVisibility(Comment $comment)
    {

    }
}
