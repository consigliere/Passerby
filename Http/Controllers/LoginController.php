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
 * @package App\Components\Passerby\Http\Controllers
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
     * @param \App\Components\Passerby\Services\LoginService $loginService
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
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request): \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
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
