<?php
/**
 * LoginController.php
 * Created by @anonymoussc on 10/31/2018 12:28 PM.
 */

/**
 * AuthController.php
 * @renamed by @anonymoussc on 05/15/2019 7:55 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/12/19 8:59 PM
 */

namespace App\Components\Passerby\Http\Controllers;

use App\Components\Passerby\Requests\AuthLoginRequest;
use App\Components\Passerby\Services\AuthService;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Components\Passerby\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @var \App\Components\Passerby\Services\AuthService
     */
    private $authService;

    /**
     * LoginController constructor.
     *
     * @param \App\Components\Passerby\Services\AuthService $AuthService
     */
    public function __construct(AuthService $AuthService)
    {
        $this->authService = $AuthService;
        $this->euuid       = randomUuid();
    }

    /**
     * @param \App\Components\Passerby\Requests\AuthLoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $data   = [
            'form' => $request->all(),
        ];

        try {
            $data = $this->authService->attemptLogin($data);
        } catch (\Exception $error) {
            $this->fireLog('error', $error->getMessage(), ['error' => $error, 'uuid' => $this->euuid]);

            return response()->ApiError($this->euuid, $error);
        }

        return response()->Api($data);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request): \Illuminate\Http\JsonResponse
    {
        $data   = [
            'refresh_token' => $request->has('refreshToken') ? $request->refreshToken : [],
        ];

        try {
            $data = $this->authService->attemptRefresh($data);
        } catch (\Exception $error) {
            $this->fireLog('error', $error->getMessage(), ['error' => $error, 'uuid' => $this->euuid]);

            return response()->ApiError($this->euuid, $error);
        }

        return response()->Api($data);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->authService->logout();
        } catch (\Exception $error) {
            $this->fireLog('error', $error->getMessage(), ['error' => $error, 'uuid' => $this->euuid]);

            return response()->ApiError($this->euuid, $error);
        }

        return response()->Api(null, 204);
    }
}
