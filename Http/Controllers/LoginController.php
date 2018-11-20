<?php
/**
 * LoginController.php
 * Created by @anonymoussc on 10/31/2018 12:28 PM.
 */

namespace App\Components\Passerby\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Components\Passerby\Requests\LoginRequest;
use App\Components\Passerby\Services\LoginService;

/**
 * Class LoginController
 * @package App\Components\Passerby\Http\Controllers\OAuth\Password
 */
class LoginController extends Controller
{
    /**
     * @var LoginService
     */
    private $loginService;

    /**
     * LoginController constructor.
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request)
    {
        return $this->response($this->loginService->attemptLogin(
            $request->input('email'),
            $request->input('password'))
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function refresh(Request $request)
    {
        return $this->response($this->loginService->attemptRefresh());
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        $this->loginService->logout();

        return $this->response(null, 204);
    }
}
