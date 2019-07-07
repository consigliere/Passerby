<?php
/**
 * BearerToken.php
 * Created by @anonymoussc on 07/07/2019 7:00 PM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/7/19 7:39 PM
 */

namespace App\Components\Passerby\Services\Auth\Responses;

use Illuminate\Support\Facades\App;

/**
 * Class BearerToken
 * @package App\Components\Passerby\Services\Auth\Responses
 */
final class BearerToken
{
    /**
     * @const REFRESH_TOKEN
     */
    const REFRESH_TOKEN = 'refreshToken';

    /**
     * @var bool
     */
    private $cookieHttpOnly;
    /**
     * @var
     */
    private $appCookie;
    /**
     * @var int
     */
    private $cookieExpire;

    /**
     * BearerToken constructor.
     */
    public function __construct()
    {
        $this->appCookie      = App::make('cookie');
        $this->cookieHttpOnly = (boolean)config('password.refreshToken.cookie.httpOnly');
        $this->cookieExpire   = (int)config('password.refreshToken.cookie.expire');
    }

    /**
     * @param       $data
     * @param array $option
     * @param array $param
     *
     * @return mixed
     */
    public function __invoke($data, array $option = [], array $param = [])
    {
        $token['access_token'] = $data->access_token;

        $this->cookieHttpOnly
            ? $this->setCookieWith($data->refresh_token)
            : $token['refresh_token'] = $data->refresh_token;

        $token['expires_in'] = $data->expires_in;

        return $token;
    }

    /**
     * @param $refreshToken
     */
    private function setCookieWith($refreshToken): void
    {
        $this->appCookie->queue(
            self::REFRESH_TOKEN, $refreshToken, $this->cookieExpire, null, null, false, $this->cookieHttpOnly
        );
    }
}