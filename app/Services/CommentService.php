<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;

class CommentService
{
    public function create(string $text, Post $post): Comment
    {
        return $post->comments()->create(['text' => $text]);
    }

    public function update(Comment $comment, string $text): Comment
    {
        $comment->update(['text' => $text]);

        return $comment;
    }

    public function delete(Comment $comment): ?bool
    {
        return $comment->delete();
    }
}
