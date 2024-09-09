<?php

namespace App\Services;

use App\Events\Post\PostCreated;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    private const PER_PAGE = 10;

    public function create(string $title, string $description): Post
    {
        $post = Post::create([
            'title' => $title,
            'description' => $description,
        ]);

        PostCreated::dispatch($post);

        return $post;
    }

    public function update(Post $post, string $title, string $description): Post
    {
        $post->update([
            'title' => $title,
            'description' => $description,
        ]);

        return $post;
    }

    public function delete(Post $post): ?bool
    {
        return $post->delete();
    }

    public function getWithPagination(): LengthAwarePaginator
    {
        return Post::paginate(self::PER_PAGE);
    }
}
