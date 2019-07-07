<?php
/**
 * LoginMessageEventSubscriber.php
 * Created by @anonymoussc on 02/28/2019 3:04 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/8/19 5:54 AM
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
        $events->listen('login.logout', 'App\Components\Passerby\Listeners\LoginMessageEventSubscriber@onLogoutMessage', 10);
    }

    /**
     * @param array $data
     */
    public function onLoginMessage($data = null): void
    {
        if (isset($data->username, $data->uuid)) {
            $username = $data->username;
            $uuid     = $data->uuid;

            $this->fireLog('info', config('password.log.info.login.message') . " @$username#$uuid");
        } else {
            $this->fireLog('info', config('password.log.info.login.message'));
        }

    }

    /**
     * @param array $data
     */
    public function onLogoutMessage($data = null): void
    {
        if (isset($data->username, $data->uuid)) {
            $username = $data->username;
            $uuid     = $data->uuid;

            $this->fireLog('info', config('password.log.info.logout.message') . " @$username#$uuid");
        } else {
            $this->fireLog('info', config('password.log.info.logout.message'));
        }
    }
}