<?php

namespace App\Listeners;

use App\Events\Post\PostCreated;
use App\Services\NotificationService;

readonly class SendNotificationToAdmin
{
    /**
     * Create the event listener.
     */
    public function __construct(private NotificationService $notificationService) {}

    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {
        $this->notificationService->sendPostCreatedNotificationToAdmin($event->post);
    }
}
