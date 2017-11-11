<?php
/**
 * PermissionEventListener.php
 * Created by rn on 11/11/2017 6:16 AM.
 */

namespace App\Components\Passerby\Listeners;


class PermissionEventListener
{
    public function subscribe($events)
    {
        $events->listen('user.permission.do.something', 'App\Components\Passerby\Listeners\PermissionEventListener@doSomething', 10);
    }

    public function doSomething()
    {

    }
}