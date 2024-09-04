<?php

namespace Tests\Unit;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_comment_for_post()
    {
        $post = Post::factory()->create();

        $response = $this->postJson('/api/posts/'.$post->id.'/comments', [
            'text' => 'This is a comment.',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'text']]);
    }

    public function test_cannot_create_comment_with_invalid_data()
    {
        $post = Post::factory()->create();

        $response = $this->postJson('/api/posts/'.$post->id.'/comments', [
            'text' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['text']);
    }
}
