<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 2/28/19 3:54 AM
 */

/**
 * LoginMessageEventSubscriber.php
 * Created by @anonymoussc on 02/28/2019 3:04 AM.
 */

namespace App\Components\Passerby\Listeners;

use App\Components\Signal\Shared\Signal;

/**
 * Class LoginEventSubscriber
 * @package App\Components\Passerby\Listeners
 */
class LoginMessageEventSubscriber
{
    use Signal;

    /**
     * @param $events
     */
    public function subscribe($events): void
    {
        $events->listen('login.message', 'App\Components\Passerby\Listeners\LoginMessageEventSubscriber@onLoginMessage', 10);
        $events->listen('login.refresh', 'App\Components\Passerby\Listeners\LoginMessageEventSubscriber@onRefreshMessage', 10);
        $events->listen('login.logout', 'App\Components\Passerby\Listeners\LoginMessageEventSubscriber@onLogoutMessage', 10);
    }


    /**
     * @param array $user
     */
    public function onLoginMessage(array $user): void
    {
        $this->fireLog('info', 'Login@ User ' . $user['username'] . ' with ID ' . $user['userid'] .
            ' has been successfully login.');
    }

    /**
     *
     */
    public function onRefreshMessage(): void
    {
        $this->fireLog('info', 'Refresh@ Access Token refreshed');
    }


    /**
     * @param array $user
     */
    public function onLogoutMessage(array $user): void
    {
        $this->fireLog('info', 'Logout@ User with ID ' . $user['userid'] . ' using access token with ID ' . $user['usertokenid'] .
            ' has been successfully logs out');
    }
}