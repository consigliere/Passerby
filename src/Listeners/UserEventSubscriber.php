<?php
/**
 * UserEventSubscriber.php
 * Created by @anonymoussc on 11/11/2017 5:32 AM.
 */

namespace App\Components\Passerby\Listeners;

class UserEventSubscriber
{
    public function subscribe($events)
    {
        $events->listen('user.user.do.something', 'App\Components\Passerby\Listeners\UserEventSubscriber@doSomething', 10);
    }

    public function doSomething()
    {

    }
}