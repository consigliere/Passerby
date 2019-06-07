<?php
/**
 * Proxy.php
 * Created by @anonymoussc on 01/01/2019 6:20 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 6/7/19 7:23 AM
 */

namespace App\Components\Passerby\Services\Auth\Service;

use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Class Proxy
 * @package App\Components\Passerby\Services\Auth\Service
 */
class Proxy
{
    /**
     * @const
     */
    const REFRESH_TOKEN = 'refreshToken';

    /**
     * @var
     */
    private $appCookie;
    /**
     * @var
     */
    private $apiConsumer;

    /**
     * @var bool
     */
    private $cookieHttpOnly;
    /**
     * @var int
     */
    private $cookieExpire;
    /**
     * @var mixed
     */
    private $passwordClientId;
    /**
     * @var mixed
     */
    private $passwordClientSecret;

    /**
     * Proxy constructor.
     */
    public function __construct()
    {
        $this->apiConsumer = App::make('apiconsumer');
        $this->appCookie   = App::make('cookie');

        $this->cookieHttpOnly       = (boolean)Config::get('password.refreshToken.cookie.httpOnly');
        $this->cookieExpire         = (int)Config::get('password.refreshToken.cookie.expire');
        $this->passwordClientId     = Config::get('password.client.id');
        $this->passwordClientSecret = Config::get('password.client.secret');
    }

    /**
     * @param       $grantType
     * @param array $data
     * @param array $param
     *
     * @return array
     */
    public function __invoke($grantType, array $data = [], array $param = []): array
    {
        $data  = array_merge($data, $this->clientCredential($grantType));
        $proxy = json_decode($this->proxyResponse($data));

        $token['access_token'] = $proxy->access_token;

        $this->cookieHttpOnly
            ? $this->setCookieWith($proxy->refresh_token)
            : $token['refresh_token'] = $proxy->refresh_token;

        $token['expires_in'] = $proxy->expires_in;

        return $token;
    }

    /**
     * @param $type
     *
     * @return array
     */
    private function clientCredential($type): array
    {
        return [
            'client_id'     => $this->passwordClientId,
            'client_secret' => $this->passwordClientSecret,
            'grant_type'    => $type,
        ];
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    private function proxyResponse($data)
    {
        $response = $this->apiConsumer->post('/oauth/token', $data);

        if (!$response->isSuccessful()) {
            throw new InvalidCredentialsException();
        }

        return $response->getContent();
    }

    /**
     * @param $refreshToken
     */
    private function setCookieWith($refreshToken): void
    {
        // Create a refresh token cookie
        $this->appCookie->queue(
            self::REFRESH_TOKEN,
            $refreshToken,
            $this->cookieExpire,
            null,
            null,
            false,
            $this->cookieHttpOnly
        );
    }
}