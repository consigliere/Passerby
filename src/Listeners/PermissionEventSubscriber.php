<?php
/**
 * PermissionEventSubscriber.php
 * Created by rn on 11/11/2017 6:16 AM.
 */

namespace App\Components\Passerby\Listeners;


class PermissionEventSubscriber
{
    public function subscribe($events)
    {
        $events->listen('permission.create.success', 'App\Components\Passerby\Listeners\PermissionEventSubscriber@onCreateSuccess', 10);
        $events->listen('permission.create.error', 'App\Components\Passerby\Listeners\PermissionEventSubscriber@onCreateError', 10);
    }

    public function onCreateSuccess()
    {

    }
    public function onCreateError()
    {

    }
}