<?php
/**
 * LoginService.php
 * Created by @anonymoussc on 10/25/2017 4:18 AM.
 */

namespace App\Components\Passerby\Services;

use Illuminate\Foundation\Application;
use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use App\Components\Passerby\Repositories\LoginRepositoryInterface;
use App\Components\Passerby\Services\Login\LoginService\Proxy;
use App\Components\Passerby\Services\Login\Shared\LoginCallable;

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
     * @param $email
     * @param $password
     *
     * @return array
     */
    public function attemptLogin($email, $password): array
    {
        $user       = $this->loginRepository->getWhere('email', $email)->first();
        $credential = ['username' => $email, 'password' => $password];

        if ($user !== null) {
            $proxy = $this->proxy(new Proxy, 'password', $credential);

            # Log Info
            $this->fireLog('info', 'Login@ User ' . $user->name . ' with ID ' . $user->id . ' has been successfully login.');

            return $proxy;
        }

        throw new InvalidCredentialsException();
    }

    /**
     * @return array
     */
    public function attemptRefresh(): array
    {
        $refreshToken = ['refresh_token' => $this->request->cookie(self::REFRESH_TOKEN)];

        # Info
        $this->fireLog('info', 'Refresh@ Access Token refreshed');

        return $this->proxy(new Proxy, 'refresh_token', $refreshToken);
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

        # Info
        $this->fireLog('info', 'Logout@ User with ID ' . $usertoken->user_id . ' using access token with ID ' .
            $usertoken->id . ' has been successfully logs out');
    }
}