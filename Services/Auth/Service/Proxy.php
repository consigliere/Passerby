<?php
/**
 * Proxy.php
 * Created by @anonymoussc on 01/01/2019 6:20 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/7/19 6:50 AM
 */

namespace App\Components\Passerby\Services\Auth\Service;

use Api\User\Entities\User;
use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Class Proxy
 * @package App\Components\Passerby\Services\Auth\Service
 */
final class Proxy
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
        $this->apiConsumer          = App::make('apiconsumer');
        $this->appCookie            = App::make('cookie');
        $this->cookieHttpOnly       = (boolean)Config::get('password.refreshToken.cookie.httpOnly');
        $this->cookieExpire         = (int)Config::get('password.refreshToken.cookie.expire');
        $this->passwordClientId     = Config::get('password.client.id');
        $this->passwordClientSecret = Config::get('password.client.secret');
    }

    /**
     * @param       $grantType
     * @param array $data
     * @param null  $userId
     * @param array $param
     *
     * @return array
     */
    public function __invoke($grantType, array $data = [], $userId = null, array $param = []): array
    {
        $data  = array_merge($data, $this->clientCredential($grantType, $userId));
        $proxy = json_decode($this->proxyResponse($data));

        $token['access_token'] = $proxy->access_token;
        $this->cookieHttpOnly
            ? $this->setCookieWith($proxy->refresh_token)
            : $token['refresh_token'] = $proxy->refresh_token;
        $token['expires_in'] = $proxy->expires_in;

        return $token;
    }

    /**
     * @param      $type
     *
     * @param null $userId
     *
     * @return array
     */
    private function clientCredential($type, $userId = null): array
    {
        $credential = [
            'client_id'     => $this->passwordClientId,
            'client_secret' => $this->passwordClientSecret,
            'grant_type'    => $type,
        ];

        if (class_exists(\App\Components\Scaffold\Providers\ScaffoldServiceProvider::class)) {
            if ($type === 'password' && null !== $userId) {
                $credential['scope'] = $this->loadScope($userId);
            }
        }

        return $credential;
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
        $this->appCookie->queue(
            self::REFRESH_TOKEN, $refreshToken, $this->cookieExpire, null, null, false, $this->cookieHttpOnly
        );
    }

    /**
     * @param $userId
     *
     * @return string
     */
    private function loadScope($userId): string
    {
        $permissions = new \Illuminate\Database\Eloquent\Collection;
        $user        = User::where('id', $userId)->with('role', 'role.permissions')->with('roles', 'roles.permissions')->first();
        $scope       = '';

        if (null !== $user) {
            $userroles = $user->roles;
            $userroles->prepend($user->role);

            foreach ($userroles as $role) {
                $permissions = $permissions->merge($role->permissions);
            }

            $newPerm = [];
            $i       = 0;
            foreach ($permissions as $perm) {
                $newPerm[$i] = $perm['key'];

                $i++;
            }

            $scope = implode(' ', $newPerm);
        }

        return $scope;
    }
}