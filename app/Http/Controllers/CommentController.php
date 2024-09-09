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
        return new CommentResource($this->commentService->create(
            $request->string('text')->toString(),
            $post
        ));
    }

    public function update(CommentRequest $request, Post $post, Comment $comment): CommentResource
    {
        return new CommentResource($this->commentService->update(
            $comment,
            $request->string('text')->toString(),
        ));
    }

    public function destroy(Post $post, Comment $comment): JsonResponse
    {
        $this->commentService->delete($comment);

        return response()->json();
    }
}
