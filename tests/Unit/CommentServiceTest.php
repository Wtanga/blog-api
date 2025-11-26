<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CommentService $commentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commentService = new CommentService;
    }

    public function test_create_comment()
    {
        $post = Post::factory()->create();
        $text = 'This is a comment';

        $comment = $this->commentService->create($text, $post);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($text, $comment->text);
        $this->assertEquals($post->id, $comment->post_id);
    }

    public function test_update_comment()
    {
        $comment = Comment::factory()->create();
        $newText = 'Updated comment text';

        $updatedComment = $this->commentService->update($comment, $newText);

        $this->assertInstanceOf(Comment::class, $updatedComment);
        $this->assertEquals($newText, $updatedComment->text);
    }

    public function test_delete_comment()
    {
        $comment = Comment::factory()->create();

        $result = $this->commentService->delete($comment);

        $this->assertTrue($result);
        $this->assertSoftDeleted($comment);
    }
}
