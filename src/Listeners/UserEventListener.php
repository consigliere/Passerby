<?php
/**
 * UserEventListener.php
 * Created by rn on 11/11/2017 5:32 AM.
 */

namespace App\Components\Passerby\Listeners;


class UserEventListener
{
    public function subscribe($events)
    {
        $events->listen('user.user.do.something', 'App\Components\Passerby\Listeners\UserEventListener@doSomething', 10);
    }

    public function doSomething()
    {

    }
}