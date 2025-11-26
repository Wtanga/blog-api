<?php

namespace App\Services;

use App\Models\Post;
use App\Notifications\PostCreatedNotification;
use Illuminate\Support\Facades\Notification;

readonly class NotificationService
{
    public function __construct(private string $email) {}

    public function sendPostCreatedNotificationToAdmin(Post $post): void
    {
        Notification::route('mail', $this->email)->notify(new PostCreatedNotification($post));
    }
}
