<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function __construct(private readonly PostService $postService) {}

    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection($this->postService->getWithPagination());
    }

    public function store(PostRequest $request): PostResource
    {
        $validated = $request->validated();
        return new PostResource($this->postService->create($validated['title'], $validated['description']));
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post->load('comments'));
    }

    public function update(PostRequest $request, Post $post): PostResource
    {
        $validated = $request->validated();
        return new PostResource($this->postService->update($post, $validated['title'], $validated['description']));
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->postService->delete($post);

        return response()->json();
    }
}
