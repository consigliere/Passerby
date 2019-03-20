<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 3/20/19 11:00 AM
 */

/**
 * Proxy.php
 * Created by @anonymoussc on 01/01/2019 6:20 AM.
 */

namespace App\Components\Passerby\Services\Login\LoginService;

use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Class Proxy
 * @package App\Components\Passerby\Services\Login\LoginService
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
    private $httpOnly;

    /**
     * Proxy constructor.
     */
    public function __construct()
    {
        $this->apiConsumer = App::make('apiconsumer');
        $this->appCookie   = App::make('cookie');

        $this->httpOnly = (boolean)Config::get('password.refreshToken.cookie.httpOnly');
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

        $this->httpOnly
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
            'client_id'     => Config::get('password.client.id'),
            'client_secret' => Config::get('password.client.secret'),
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
        $expire = (int)Config::get('password.refreshToken.cookie.expire');

        // Create a refresh token cookie
        $this->appCookie->queue(
            self::REFRESH_TOKEN,
            $refreshToken,
            $expire,
            null,
            null,
            false,
            $this->httpOnly
        );
    }
}