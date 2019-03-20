<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 3/21/19 5:36 AM
 */

/**
 * LoginMessageEventSubscriber.php
 * Created by @anonymoussc on 02/28/2019 3:04 AM.
 */

namespace App\Components\Passerby\Listeners;

use App\Components\Signal\Shared\Signal;
use Illuminate\Support\Facades\Config;

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
     * @param array $user ['username'], $user['userid']
     */
    public function onLoginMessage(array $user): void
    {
        $this->fireLog('info', Config::get('password.log.info.login.message') . ' @UserID: ' . $user['userid']);
    }

    /**
     *
     */
    public function onRefreshMessage(): void
    {
        $this->fireLog('info', Config::get('password.log.info.refresh.message'));
    }


    /**
     * @param array $user ['userid'], $user['usertokenid']
     */
    public function onLogoutMessage(array $user): void
    {
        $this->fireLog('info', Config::get('password.log.info.logout.message') . ' @UserID: ' . $user['userid']);
    }
}