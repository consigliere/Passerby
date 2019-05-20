<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/20/19 2:17 PM
 */

/**
 * LoginController.php
 * Created by @anonymoussc on 10/31/2018 12:28 PM.
 */

/**
 * AuthController.php
 * @renamed by @anonymoussc on 05/15/2019 7:55 AM.
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
        $this->euuid       = $this->getUuid();
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
        $option = $this->getOption();
        $param  = $this->getParam();

        try {
            $data = $this->authService->attemptLogin($data, $option, $param);
        } catch (\Exception $error) {
            $this->fireLog('error', $error->getMessage(), ['error' => $error, 'uuid' => $this->euuid]);

            return $this->response($this->getErrorResponse($this->euuid, $error), 500);
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
        $data   = [
            'refresh_token' => $request->has('refreshToken') ? $request->refreshToken : [],
        ];
        $option = $this->getOption();
        $param  = $this->getParam();

        try {
            $data = $this->authService->attemptRefresh($data, $option, $param);
        } catch (\Exception $error) {
            $this->fireLog('error', $error->getMessage(), ['error' => $error, 'uuid' => $this->euuid]);

            return $this->response($this->getErrorResponse($this->euuid, $error), 500);
        }

        return $this->response($data);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $data   = [];
        $option = $this->getOption();
        $param  = $this->getParam();

        try {
            $this->authService->logout($data, $option, $param);
        } catch (\Exception $error) {
            $this->fireLog('error', $error->getMessage(), ['error' => $error, 'uuid' => $this->euuid]);

            return $this->response($this->getErrorResponse($this->euuid, $error), 500);
        }

        return $this->response(null, 204);
    }
}
