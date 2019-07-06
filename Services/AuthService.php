<?php
/**
 * LoginService.php
 * Created by @anonymoussc on 10/25/2017 4:18 AM.
 */

/**
 * AuthService.php
 * @renamed by @anonymoussc on 05/15/2019 8:46 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/6/19 11:23 PM
 */

namespace App\Components\Passerby\Services;

use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use App\Components\Passerby\Repositories\AuthRepositoryInterface;
use App\Components\Passerby\Services\Auth\Service\Proxy;
use App\Components\Passerby\Services\Auth\Shared\AuthCallable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;

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
     * @var mixed
     */
    private $request;
    /**
     * @var AuthRepositoryInterface
     */
    private $authRepository;
    private $refreshToken;

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
        $this->request = $app->make('request');
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $prop = lcfirst(substr($name, 3));

        return $this->$prop;
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
        if (null !== $user) {
            $proxy = (new Proxy)('password', $data['form'], $user->id);
            $this->logLogin($user);

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
        $token = $this->findInputRefreshToken($data)->verifyInputRefreshToken(null)->getRefreshToken();
        $proxy = (new Proxy)('refresh_token', ['refresh_token' => $token]);

        $this->logRefresh();

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

        $this->logLogout($usertoken, $param);
    }

    /**
     * @param $data
     *
     * @return $this
     */
    private function findInputRefreshToken($data): self
    {
        $this->refreshToken = data_get($data, 'refresh_token');

        return $this;
    }

    /**
     * @param null $token
     *
     * @return $this
     */
    private function verifyInputRefreshToken($token = null): self
    {
        $newToken = $token ?? $this->refreshToken;

        if (isset($newToken) && !empty($newToken) && (null !== $newToken) && (!config('password.refreshToken.cookie.httpOnly'))) {
            $this->refreshToken = $newToken;
        } else {
            $this->refreshToken = $this->request->cookie(self::REFRESH_TOKEN);
        }

        return $this;
    }

    private function logRefresh(): void
    {
        if (config('password.log.info.refresh.active')) {
            event('login.refresh');
        }
    }

    /**
     * @param $user
     */
    private function logLogin($user): void
    {
        if (config('password.log.info.login.active')) {
            event('login.message', [['user' => $user,]]);
        }
    }

    /**
     * @param $usertoken
     * @param $param
     */
    private function logLogout($usertoken, $param): void
    {
        $request  = App::get('request');
        $authUser = $request->user() ? $request->user()->toArray() : '';

        if (config('password.log.info.logout.active')) {
            event('login.logout', [
                [
                    'useruuid'    => $param['auth.user.uuid'],
                    'username'    => $param['auth.user.username'],
                    'usertokenid' => $usertoken->id],
            ]);
        }
    }
}