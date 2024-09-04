<?php

namespace App\Listeners;

use App\Events\Post\PostCreated;
use App\Services\NotificationService;

class SendNotificationToAdmin
{
    private NotificationService $notificationService;

    /**
     * Create the event listener.
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {
        $this->notificationService->sendPostCreatedNotificationToAdmin($event->post);
    }
}
