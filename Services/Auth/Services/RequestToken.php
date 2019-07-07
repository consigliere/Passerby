<?php
/**
 * Proxy.php
 * Created by @anonymoussc on 01/01/2019 6:20 AM.
 */

/**
 * RequestToken.php
 * Renamed by @anonymoussc on 07/07/2019 7:36 PM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/7/19 10:13 PM
 */

namespace App\Components\Passerby\Services\Auth\Services;

use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use App\Components\Passerby\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\App;

/**
 * Class Proxy
 * @package App\Components\Passerby\Services\Auth\Service
 */
final class RequestToken
{
    /**
     * @var $apiConsumer
     */
    private $apiConsumer;
    /**
     * @var mixed
     */
    private $passwordClientId;
    /**
     * @var mixed
     */
    private $passwordClientSecret;
    /**
     * @var \App\Components\Passerby\Repositories\AuthRepositoryInterface
     */
    private $authRepository;
    /**
     * @var $requestToken
     */
    private $requestToken;
    /**
     * @var string
     */
    private $apiEndpoint;

    /**
     * Proxy constructor.
     *
     * @param \App\Components\Passerby\Repositories\AuthRepositoryInterface $AuthRepository
     */
    public function __construct(AuthRepositoryInterface $AuthRepository)
    {
        $this->apiConsumer          = App::make('apiconsumer');
        $this->authRepository       = $AuthRepository;
        $this->apiEndpoint          = '/oauth/token';
        $this->passwordClientId     = config('password.client.id');
        $this->passwordClientSecret = config('password.client.secret');
    }

    /**
     * @param       $grantType
     * @param array $data
     * @param null  $userId
     * @param array $param
     *
     * @return array
     */
    public function __invoke($grantType, array $data = [], $userId = null, array $param = [])
    {
        $data         = array_merge($data, $this->clientCredential($grantType, $userId));
        $requestToken = $this->httpPostRequestToken($data)->requestTokenIsSuccessful()->requestTokenGetContent()->requestToken;

        return json_decode($requestToken, false);
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
     * @param $userId
     *
     * @return string
     */
    private function loadScope($userId): string
    {
        $permissions = new \Illuminate\Database\Eloquent\Collection;
        $user        = $this->loadUserWithAllByUid($userId);
        $scope       = '';

        if (null !== $user) {
            $userroles = $user->roles;
            $userroles->prepend($user->role);

            foreach ($userroles as $role) {
                $permissions = $permissions->merge($role->permissions);
            }

            $newPerm = [];
            foreach ($permissions as $k => $perm) {
                $newPerm[$k] = $perm['key'];
            }

            $scope = implode(' ', $newPerm);
        }

        return $scope;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    private function httpPostRequestToken($data): self
    {
        $this->requestToken = $this->apiConsumer->post($this->apiEndpoint, $data);

        return $this;
    }

    /**
     * @param null $token
     *
     * @return $this
     */
    private function requestTokenIsSuccessful($token = null): self
    {
        $newToken = $token ?? $this->requestToken;

        if (!$newToken->isSuccessful()) {
            throw new InvalidCredentialsException();
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function requestTokenGetContent(): self
    {
        $this->requestToken = $this->requestToken->getContent();

        return $this;
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    private function loadUserWithAllByUid($userId)
    {
        return $this->authRepository->userWithRolePermissions($userId);
    }
}