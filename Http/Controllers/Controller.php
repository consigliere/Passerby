<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/16/19 8:13 AM
 */

/**
 * Controller.php
 * Created by @anonymoussc on 10/22/2017 1:26 AM.
 */

namespace App\Components\Passerby\Http\Controllers;

use App\Components\Signal\Shared\ErrorLog;
use App\Components\Signal\Shared\Signal;
use App\Components\Signature\Http\Controllers\SignatureController as BaseController;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use JsonSerializable;

/**
 * Class Controller
 * @package App\Components\Passerby\Http\Controllers
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Signal, ErrorLog;

    /**
     * @param       $data
     * @param int   $statusCode
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response($data, $statusCode = 200, array $headers = ['Content-Type' => 'application/vnd.api+json',]): JsonResponse
    {
        if ($data instanceof Arrayable && !$data instanceof JsonSerializable) {
            $data = $data->toArray();
        }

        return new JsonResponse($data, $statusCode, $headers);
    }

    /**
     * @param       $request
     * @param array $param
     *
     * @return array
     */
    protected function getOption($request, array $param = []): array
    {
        $active  = $param['active'] ?? '';
        $message = $param['message'] ?? '';

        $option = [
            'api'     => [
                'hasLink' => true,
                'hasMeta' => true,
            ],
            'log'     => [
                'active'  => $active,
                'message' => $message,
            ],
            'refresh' => [
                'cookie' => [
                    'httpOnly' => Config::get('password.refreshToken.cookie.httpOnly'),
                    'expire'   => Config::get('password.refreshToken.cookie.expire'),
                ],
            ],
        ];

        return Arr::dot($option);
    }

    /**
     * @param       $request
     * @param array $param
     *
     * @return array
     */
    protected function getParam($request, array $param = []): array
    {
        $type      = $param['type'] ?? '';
        $grantType = $param['grantType'] ?? '';
        $author    = $param['author'] ?? '';
        $email     = $param['email'] ?? '';

        $param = [
            'app'       => [
                'name' => Config::get('app.name'),
            ],
            'api'       => [
                'meta' => [
                    'author' => $author,
                    'email'  => $email,
                ],
            ],
            'type'      => $type,
            'auth'      => [
                'user' => $request->user() ? $request->user()->toArray() : '',
            ],
            'link'      => [
                'fullUrl' => $request->fullUrl(),
                'url'     => $request->url(),
            ],
            'grantType' => $grantType,
        ];

        return Arr::dot($param);
    }
}