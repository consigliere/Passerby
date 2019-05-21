<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/21/19 1:28 PM
 */

/**
 * LoginService.php
 * Created by @anonymoussc on 10/25/2017 4:18 AM.
 */

/**
 * AuthService.php
 * @renamed by @anonymoussc on 05/15/2019 8:46 AM.
 */

namespace App\Components\Passerby\Services;

use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use App\Components\Passerby\Repositories\AuthRepositoryInterface;
use App\Components\Passerby\Services\Auth\Service\Proxy;
use App\Components\Passerby\Services\Auth\Shared\AuthCallable;
use Illuminate\Foundation\Application;

/**
 * Class AuthService
 * @package App\Components\Passerby\Services
 */
class AuthService extends Service
{
    use AuthCallable;

    const REFRESH_TOKEN = 'refreshToken';

    /**
     * @var \Illuminate\Auth\AuthManager|mixed
     */
    private $auth;
    /**
     * @var mixed
     */
    private $cookie;
    /**
     * @var \Illuminate\Database\DatabaseManager|mixed
     */
    private $db;
    /**
     * @var mixed
     */
    private $request;
    /**
     * @var AuthRepositoryInterface
     */
    private $authRepository;

    /**
     * AuthService constructor.
     *
     * @param \Illuminate\Foundation\Application                            $app
     * @param \App\Components\Passerby\Repositories\AuthRepositoryInterface $AuthRepository
     */
    public function __construct(Application $app, AuthRepositoryInterface $AuthRepository)
    {
        $this->authRepository = $AuthRepository;

        $this->auth    = $app->make('auth');
        $this->cookie  = $app->make('cookie');
        $this->db      = $app->make('db');
        $this->request = $app->make('request');
    }

    public function attemptLogin(array $data = [], array $option = [], array $arg = []): array
    {
        $user = $this->authRepository->getUserByUsernameOrEmail(data_get($data, 'form.username'))->first();

        if ($user !== null) {
            $proxy = (new Proxy)('password', $data['form']);

            if (config('password.log.info.login.active')) {
                event('login.message', [['user' => $user,]]);
            }

            return $proxy;
        }

        throw new InvalidCredentialsException();
    }

    public function attemptRefresh(array $data = [], array $option = [], array $arg = []): array
    {
        if (isset($data['refresh_token']) && !empty($data['refresh_token']) && ($data['refresh_token'] !== null) && (!$option['refresh.cookie.httpOnly'])) {
            $token = $data['refresh_token'];
        } else {
            $token = $this->request->cookie(self::REFRESH_TOKEN);
        }

        $proxy = (new Proxy)('refresh_token', ['refresh_token' => $token]);

        if (config('password.log.info.refresh.active')) {
            event('login.refresh');
        }

        return $proxy;
    }

    public function logout(array $data = [], array $option = [], array $arg = []): void
    {
        $accessToken  = $this->auth->user()->token();
        $usertoken    = $accessToken;
        $refreshToken = $this->authRepository->logout($accessToken->id);

        $accessToken->revoke();

        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));

        if (config('password.log.info.logout.active')) {
            event('login.logout', [['useruuid' => $arg['auth.user.uuid'], 'username' => $arg['auth.user.username'], 'usertokenid' => $usertoken->id]]);
        }
    }
}