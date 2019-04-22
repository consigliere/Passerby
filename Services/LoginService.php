<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 4/22/19 2:24 PM
 */

/**
 * LoginService.php
 * Created by @anonymoussc on 10/25/2017 4:18 AM.
 */

namespace App\Components\Passerby\Services;

use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use App\Components\Passerby\Repositories\LoginRepositoryInterface;
use App\Components\Passerby\Services\Login\LoginService\Proxy;
use App\Components\Passerby\Services\Login\Shared\LoginCallable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

/**
 * Class LoginService
 * @package App\Components\Passerby\Services
 */
class LoginService extends Service
{
    use LoginCallable;

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
     * @var LoginRepositoryInterface
     */
    private $loginRepository;

    /**
     * LoginService constructor.
     *
     * @param \Illuminate\Foundation\Application                             $app
     * @param \App\Components\Passerby\Repositories\LoginRepositoryInterface $loginRepository
     */
    public function __construct(Application $app, LoginRepositoryInterface $loginRepository)
    {
        $this->loginRepository = $loginRepository;

        $this->auth    = $app->make('auth');
        $this->cookie  = $app->make('cookie');
        $this->db      = $app->make('db');
        $this->request = $app->make('request');
    }

    /**
     * @param $username
     * @param $password
     *
     * @return array
     */
    public function attemptLogin($username, $password): array
    {
        $user = $this->loginRepository->getUserByUsernameOrEmail($username)->first();

        if ($user !== null) {
            $proxy = $this->proxy(new Proxy, 'password', ['username' => $username, 'password' => $password]);

            if (Config::get('password.log.info.login.active')) {
                Event::dispatch('login.message', [['username' => $user->name, 'userid' => $user->id]]);
            }

            return $proxy;
        }

        throw new InvalidCredentialsException();
    }

    /**
     * @param array $param
     *
     * @return array
     */
    public function attemptRefresh(array $param = []): array
    {
        $token = (
            (!Config::get('password.refreshToken.cookie.httpOnly.')) &&
            (true === isset($param['refresh_token'])) &&
            ($param['refresh_token'] !== '')
        )
            ? $param['refresh_token']
            : $this->request->cookie(self::REFRESH_TOKEN);

        $proxy = $this->proxy(new Proxy, 'refresh_token', ['refresh_token' => $token]);

        if (Config::get('password.log.info.refresh.active')) {
            Event::dispatch('login.refresh');
        }

        return $proxy;
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $accessToken  = $this->auth->user()->token();
        $usertoken    = $accessToken;
        $refreshToken = $this->loginRepository->logout($accessToken->id);

        $accessToken->revoke();

        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));

        if (Config::get('password.log.info.logout.active')) {
            Event::dispatch('login.logout', [['userid' => $usertoken->user_id, 'usertokenid' => $usertoken->id]]);
        }
    }
}