<?php
/**
 * Proxy.php
 * Created by @anonymoussc on 01/01/2019 6:20 AM.
 */

namespace App\Components\Passerby\Services\Login\LoginService;

use Illuminate\Support\Facades\App;
use App\Components\Passerby\Exceptions\InvalidCredentialsException;

/**
 * Class Proxy
 * @package App\Components\Passerby\Services\Login\LoginService
 */
class Proxy
{
    const REFRESH_TOKEN = 'refreshToken';

    /**
     * Proxy a request to the OAuth server.
     *
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
        $init['cookie']->queue(
            self::REFRESH_TOKEN,
            $proxy->refresh_token,
            864000, // 10 days
            null,
            null,
            false,
            true // HttpOnly
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