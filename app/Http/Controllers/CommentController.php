<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function __construct(private readonly CommentService $commentService) {}

    public function store(CommentRequest $request, Post $post): CommentResource
    {
        $validated = $request->validated();
        return new CommentResource($this->commentService->create($validated['text'], $post));
    }

    public function update(CommentRequest $request, Post $post, Comment $comment): CommentResource
    {
        $validated = $request->validated();
        return new CommentResource($this->commentService->update($comment, $validated['text']));
    }

    public function destroy(Post $post, Comment $comment): JsonResponse
    {
        $this->commentService->delete($comment);

        return response()->json();
    }
}
