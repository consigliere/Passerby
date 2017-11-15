<?php
/**
 * RoleEventSubscriber.php
 * Created by rn on 11/11/2017 6:23 AM.
 */

namespace App\Components\Passerby\Listeners;


class RoleEventSubscriber
{
    public function subscribe($events)
    {
        $events->listen('user.role.do.something', 'App\Components\Passerby\Listeners\RoleEventSubscriber@doSomething', 10);
    }

    public function doSomething()
    {

    }
}