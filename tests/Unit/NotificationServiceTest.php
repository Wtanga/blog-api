<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Notifications\PostCreatedNotification;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_post_created_notification_to_admin(): void
    {
        $post = Post::factory()->create();

        Notification::fake();

        $notificationService = new NotificationService(config('admin.email'));

        $notificationService->sendPostCreatedNotificationToAdmin($post);

        Notification::assertSentTimes(PostCreatedNotification::class, 1);
    }
}
