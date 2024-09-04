<?php

namespace App\Services;

use App\Events\Post\PostCreated;
use App\Models\Post;

class PostService
{
    public function create(string $title, string $description): Post
    {
        $post = Post::create([
            'title' => $title,
            'description' => $description
        ]);

        PostCreated::dispatch($post);

        return $post;
    }

    public function update(Post $post, string $title, string $description): Post
    {
        $post->update([
            'title' => $title,
            'description' => $description
        ]);

        return $post;
    }

    public function delete(Post $post)
    {
        return $post->delete();
    }

    public function getWithPagination()
    {
        return Post::whereNull('deleted_at')->paginate(10);
    }
}
