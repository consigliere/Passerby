<?php
/**
 * LoginController.php
 * Created by @anonymoussc on 10/31/2018 12:28 PM.
 */

namespace App\Components\Passerby\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Components\Passerby\Requests\LoginRequest;
use App\Components\Passerby\Services\LoginService;

/**
 * Class LoginController
 * @package App\Components\Passerby\Http\Controllers\OAuth\Password
 */
class LoginController extends Controller
{
    /**
     * @var \App\Components\Passerby\Services\LoginService
     */
    private $loginService;

    /**
     * LoginController constructor.
     *
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * @param \App\Components\Passerby\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $email    = $request->input('email');
        $password = $request->input('password');

        try {
            $data = $this->loginService->attemptLogin($email, $password);
        } catch (\Exception $error) {
            $this->fireLog('error', $error->getMessage(), ['error' => $error]);

            return Response::error($error->getMessage(), $error->getCode())
                ->setStatusCode(500);
        }

        return $this->response($data);
    }

    /**
     * Request new access token
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function refresh(Request $request)
    {
        try {
            $data = $this->loginService->attemptRefresh();
        } catch (\Exception $error) {
            $this->fireLog('error', $error->getMessage(), ['error' => $error]);

            return Response::error($error->getMessage(), $error->getCode())
                ->setStatusCode(500);
        }

        return $this->response($data);
    }

    /**
     * Logs out authenticated user
     * @return mixed
     */
    public function logout()
    {
        try {
            $this->loginService->logout();
        } catch (\Exception $error) {
            $this->fireLog('error', $error->getMessage(), ['error' => $error]);

            return Response::error($error->getMessage(), $error->getCode())
                ->setStatusCode(500);
        }

        return $this->response(null, 204);
    }
}
