<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/16/19 8:19 AM
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
     * @param array $data
     */
    public function onLoginMessage(array $data = []): void
    {
        $this->fireLog('info', Config::get('password.log.info.login.message') . ' @' .
            $data['user']->username . '#' . $data['user']->uuid);
    }

    /**
     * @param array $data
     */
    public function onRefreshMessage(array $data = []): void
    {
        $this->fireLog('info', Config::get('password.log.info.refresh.message'));
    }

    /**
     * @param array $data
     */
    public function onLogoutMessage(array $data = []): void
    {
        $this->fireLog('info', Config::get('password.log.info.logout.message') . ' @' .
            $data['username'] . '#' . $data['useruuid'] . ' @tokenID#' . $data['usertokenid']);
    }
}