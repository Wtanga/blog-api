<?php

namespace App\Listeners;

use App\Events\Post\PostCreated;
use App\Notifications\PostCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendNotificationToAdmin
{
    private mixed $email;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->email = config('admin.email');
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {
        Notification::route('mail', $this->email)->notify(new PostCreatedNotification($event->post));
    }
}
