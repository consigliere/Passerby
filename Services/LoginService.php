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

/**
 * Class LoginService
 * @package App\Components\Passerby\Services
 */
class LoginService extends Service
{
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
     * @param Application              $app
     * @param LoginRepositoryInterface $loginRepository
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
     * Attempt to create an access token using user credentials
     *
     * @param string $email
     * @param string $password
     *
     * @return array
     */
    public function attemptLogin($email, $password): array
    {
        $user       = $this->loginRepository->getWhere('email', $email)->first();
        $credential = ['username' => $email, 'password' => $password];

        if ($user !== null) {
            $proxy = $this->proxy(new Proxy, 'password', $credential);

            # Info
            $this->fireLog('info', 'User ' . $user->name . ' with ID ' . $user->id . ' has been successfully login.');

            return $proxy;
        }

        throw new InvalidCredentialsException();
    }

    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     */
    public function attemptRefresh(): array
    {
        $refreshToken = ['refresh_token' => $this->request->cookie(self::REFRESH_TOKEN)];

        # Info
        $this->fireLog('info', 'Access Token refreshed');

        return $this->proxy(new Proxy, 'refresh_token', $refreshToken);
    }

    /**
     * @param       $proxy
     * @param       $grantType
     * @param array $data
     * @param array $param
     *
     * @return array
     */
    public function proxy($proxy, $grantType, array $data = [], array $param = []): array
    {
        return $proxy($grantType, $data, $param);
    }

    /**
     * Logs out the user. Revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     */
    public function logout(): void
    {
        $accessToken = $this->auth->user()->token();

        $usertoken = $accessToken;

        $refreshToken = $this->loginRepository->logout($accessToken->id);

        $accessToken->revoke();

        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));

        # Info
        $this->fireLog('info', 'User with ID ' . $usertoken->user_id . ' using access token with ID ' .
            $usertoken->id . ' has been successfully logs out');
    }
}