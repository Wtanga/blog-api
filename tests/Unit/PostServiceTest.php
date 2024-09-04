<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_post()
    {
        $response = $this->postJson('/api/posts', [
            'title' => 'My First Post',
            'description' => 'This is the description of my first post.',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'title', 'description', 'created_at', 'updated_at']]);
    }

    public function test_cannot_create_post_with_invalid_data()
    {
        $response = $this->postJson('/api/posts', [
            'title' => 'Post',
            'description' => 'Short',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'description']);
    }
}
