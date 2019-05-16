<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/16/19 8:19 AM
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
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

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

    /**
     * @param array $data
     * @param array $option
     * @param array $param
     *
     * @return array
     */
    public function attemptLogin(array $data = [], array $option = [], array $param = []): array
    {
        $user = $this->authRepository->getUserByUsernameOrEmail(data_get($data, 'form.username'))->first();

        if ($user !== null) {
            $proxy = $this->proxy(new Proxy, 'password', $data['form']);

            if (Config::get('password.log.info.login.active')) {
                Event::dispatch('login.message', [['user' => $user,]]);
            }

            return $proxy;
        }

        throw new InvalidCredentialsException();
    }

    /**
     * @param array $data
     * @param array $option
     * @param array $param
     *
     * @return array
     */
    public function attemptRefresh(array $data = [], array $option = [], array $param = []): array
    {
        if (isset($data['refresh_token']) && !empty($data['refresh_token']) && ($data['refresh_token'] !== null) && (!$option['refresh.cookie.httpOnly'])) {
            $token = $data['refresh_token'];
        } else {
            $token = $this->request->cookie(self::REFRESH_TOKEN);
        }

        $proxy = $this->proxy(new Proxy, 'refresh_token', ['refresh_token' => $token]);

        if (Config::get('password.log.info.refresh.active')) {
            Event::dispatch('login.refresh');
        }

        return $proxy;
    }

    /**
     * @param array $data
     * @param array $option
     * @param array $param
     */
    public function logout(array $data = [], array $option = [], array $param = []): void
    {
        $accessToken  = $this->auth->user()->token();
        $usertoken    = $accessToken;
        $refreshToken = $this->authRepository->logout($accessToken->id);

        $accessToken->revoke();

        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));

        if (Config::get('password.log.info.logout.active')) {
            Event::dispatch('login.logout', [['useruuid' => $param['auth.user.uuid'], 'username' => $param['auth.user.username'], 'usertokenid' => $usertoken->id]]);
        }
    }
}