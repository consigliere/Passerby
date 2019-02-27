<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 2/28/19 6:16 AM
 */

/**
 * Proxy.php
 * Created by @anonymoussc on 01/01/2019 6:20 AM.
 */

namespace App\Components\Passerby\Services\Login\LoginService;

use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\App;

/**
 * Class Proxy
 * @package App\Components\Passerby\Services\Login\LoginService
 */
class Proxy
{
    const REFRESH_TOKEN = 'refreshToken';

    /**
     * @param       $grantType
     * @param array $data
     * @param array $param
     *
     * @return array
     */
    public function __invoke($grantType, array $data = [], array $param = []): array
    {
        $init = $this->init();

        $data  = array_merge($data, $this->clientCredential($grantType));
        $proxy = json_decode($this->proxyResponse($init['apiconsumer'], $data));

        // Create a refresh token cookie
        // 864000 value will make the cookies expire in 10 days
        $init['cookie']->queue(
            self::REFRESH_TOKEN, $proxy->refresh_token, 864000, null, null, false,
            true // httpOnly == true
        );

        return [
            'access_token' => $proxy->access_token,
            'expires_in'   => $proxy->expires_in,
        ];
    }

    /**
     * @return array
     */
    private function init(): array
    {
        $apiConsumer = App::make('apiconsumer');
        $cookie      = App::make('cookie');

        return ['apiconsumer' => $apiConsumer, 'cookie' => $cookie];
    }

    /**
     * @param $type
     *
     * @return array
     */
    private function clientCredential($type): array
    {
        return [
            'client_id'     => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'grant_type'    => $type,
        ];
    }

    /**
     * @param $apiconsumer
     * @param $data
     *
     * @return mixed
     */
    private function proxyResponse($apiconsumer, $data)
    {
        $response = $apiconsumer->post('/oauth/token', $data);

        if (!$response->isSuccessful()) {
            throw new InvalidCredentialsException();
        }

        return $response->getContent();
    }
}