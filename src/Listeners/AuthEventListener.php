<?php
/**
 * AuthEventListener.php
 * Created by rn on 10/23/2017 1:00 AM.
 */

namespace App\Components\Passerby\Listeners;


class AuthEventListener
{
    public function subscribe($events)
    {
        $events->listen('user.login', 'App\Components\Passerby\Listeners\AuthEventListener@onUserLogin', 10);
        $events->listen('user.logout', 'App\Components\Passerby\Listeners\AuthEventListener@onUserLogout', 10);
        $events->listen('user.register', 'App\Components\Passerby\Listeners\AuthEventListener@onUserRegister', 10);
        $events->listen('user.resend', 'App\Components\Passerby\Listeners\AuthEventListener@resend', 10);
        $events->listen('user.reset', 'App\Components\Passerby\Listeners\AuthEventListener@passwordReset', 10);
    }

    public function onUserLogin()
    {

    }

    public function onUserLogout()
    {

    }

    public function onUserRegister()
    {

    }

    public function resend()
    {

    }

    public function passwordReset()
    {

    }
}