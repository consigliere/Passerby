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

class LoginService
{
    const REFRESH_TOKEN = 'refreshToken';

    private $auth;
    private $cookie;
    private $db;
    private $request;
    private $loginRepository;

    public function __construct(Application $app, LoginRepositoryInterface $loginRepository)
    {
        $this->loginRepository = $loginRepository;

        $this->auth        = $app->make('auth');
        $this->cookie      = $app->make('cookie');
        $this->db          = $app->make('db');
        $this->request     = $app->make('request');
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
            return $this->proxy(new Proxy, 'password', $credential);
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

        return $this->proxy(new Proxy, 'refresh_token', $refreshToken);
    }

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

        $refreshToken = $this->db
            ->table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true,
            ]);

        $accessToken->revoke();

        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));
    }
}