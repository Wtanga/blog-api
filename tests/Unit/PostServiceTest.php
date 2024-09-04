<?php

namespace Tests\Unit\Services;

use App\Events\Post\PostCreated;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    protected PostService $postService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->postService = new PostService;
    }

    public function test_CreatePost()
    {
        Event::fake();

        $title = 'New Post';
        $description = 'Post description';

        $post = $this->postService->create($title, $description);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals($title, $post->title);
        $this->assertEquals($description, $post->description);

        Event::assertDispatched(PostCreated::class, function ($event) use ($post) {
            return $event->post->is($post);
        });
    }

    public function test_UpdatePost()
    {
        $post = Post::factory()->create();
        $newTitle = 'Updated Title';
        $newDescription = 'Updated Description';

        $updatedPost = $this->postService->update($post, $newTitle, $newDescription);

        $this->assertInstanceOf(Post::class, $updatedPost);
        $this->assertEquals($newTitle, $updatedPost->title);
        $this->assertEquals($newDescription, $updatedPost->description);
    }

    public function test_DeletePost()
    {
        $post = Post::factory()->create();

        $result = $this->postService->delete($post);

        $this->assertTrue($result);
        $this->assertSoftDeleted($post);
    }

    public function test_GetWithPagination()
    {
        Post::factory()->count(20)->create();

        $paginator = $this->postService->getWithPagination();

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertEquals(10, $paginator->perPage());
    }
}
