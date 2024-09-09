<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_fetch_all_posts()
    {
        Post::factory()->count(10)->create();
        $response = $this->getJson(route('posts.index'));
        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }

    public function test_can_fetch_a_single_post()
    {
        $post = Post::factory()->has(Comment::factory()->count(5))->create();
        $response = $this->getJson(route('posts.show', $post->id));
        $response->assertStatus(200)->assertJson([
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
            ],
        ])
            ->assertJsonCount(5, 'data.comments');
    }

    public function test_validates_post_creation()
    {
        $response = $this->postJson(route('posts.store'), [
            'title' => 'Shor',
            'description' => 'Too short',
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(['title', 'description']);
    }

    public function test_can_create_a_post()
    {
        $postData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
        $response = $this->postJson(route('posts.store'), $postData);
        $response->assertStatus(201)->assertJson(['data' => ['title' => $postData['title']]]);
        $this->assertDatabaseHas('posts', $postData);
    }

    public function test_can_update_a_post()
    {
        $post = Post::factory()->create();
        $updatedData = ['title' => 'Updated Title', 'description' => 'Updated Description'];
        $response = $this->putJson(route('posts.update', $post->id), $updatedData);
        $response->assertStatus(200)->assertJson(['data' => ['title' => 'Updated Title']]);
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Updated Title']);
    }

    public function test_validates_post_update()
    {
        $post = Post::factory()->create();
        $response = $this->putJson(route('posts.update', $post->id), [
            'title' => 'Shor',
            'description' => 'Too short',
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(['title', 'description']);
    }

    public function test_can_soft_delete_a_post()
    {
        $post = Post::factory()->create();
        $response = $this->deleteJson(route('posts.destroy', $post->id));
        $response->assertStatus(200);
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
        $response = $this->get(route('posts.show', $post->id));
        $response->assertStatus(404);
    }

    public function test_can_get_comments_for_post()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $response = $this->get("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'comments' => [
                        [
                            'text' => $comment->text,
                        ],
                    ],
                ],
            ]);
    }

    public function test_does_not_include_deleted_comments()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        $comment->delete();

        $response = $this->get("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonMissing([
                'text' => $comment->text,
            ]);
    }
}
