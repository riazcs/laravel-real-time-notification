<?php

namespace App\Listeners;

use App\Events\PostLikeNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostLikeNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PostLikeNotificationEvent  $event
     * @return void
     */
    public function handle(PostLikeNotificationEvent $event)
    {
        //
    }
}
