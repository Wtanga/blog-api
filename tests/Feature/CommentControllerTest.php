<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_comment_for_post()
    {
        $post = Post::factory()->create();

        $response = $this->postJson(route('posts.comments.store', $post), [
            'text' => 'This is a comment.',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'text']]);
    }

    public function test_cannot_create_comment_with_invalid_data()
    {
        $post = Post::factory()->create();

        $response = $this->postJson(route('posts.comments.store', $post), [
            'text' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['text']);
    }

    public function test_can_update_comment()
    {
        $comment = Comment::factory()->create();

        $updatedData = ['text' => 'Updated Text'];
        $response = $this->putJson(route('posts.comments.update', ['post' => $comment->post_id, 'comment' => $comment->id]), $updatedData);
        $response->assertStatus(200)->assertJson(['data' => ['text' => 'Updated Text']]);
        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'text' => 'Updated Text']);
    }

    public function test_can_delete_comment()
    {
        $comment = Comment::factory()->create();
        $response = $this->deleteJson(route('posts.comments.destroy', ['post' => $comment->post_id, 'comment' => $comment->id]));
        $response->assertStatus(200);
        $this->assertSoftDeleted('comments', ['id' => $comment->id]);
    }
}
