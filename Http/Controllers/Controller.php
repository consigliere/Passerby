<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/20/19 5:17 PM
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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use JsonSerializable;
use Webpatser\Uuid\Uuid;

/**
 * Class Controller
 * @package App\Components\Passerby\Http\Controllers
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Signal, ErrorLog;

    /**
     * @var string
     */
    protected $euuid;

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
     * @param array $param
     *
     * @return array
     * @internal param $request
     */
    protected function getOption(array $param = []): array
    {
        $request = App::get('request');
        $active  = $param['active'] ?? '';
        $message = $param['message'] ?? '';
        $opt     = [];

        data_set($opt, 'api.hasLink', true);
        data_set($opt, 'api.hasMeta', true);
        data_set($opt, 'log.active', $active);
        data_set($opt, 'log.message', $message);
        data_set($opt, 'refresh.cookie.httpOnly', Config::get('password.refreshToken.cookie.httpOnly'));
        data_set($opt, 'refresh.cookie.expire', Config::get('password.refreshToken.cookie.expire'));

        return Arr::dot($opt);
    }

    /**
     * @param string $type
     * @param array  $param
     *
     * @return array
     * @internal param $request
     */
    protected function getParam(string $type = '', array $param = []): array
    {
        $request   = App::get('request');
        $grantType = $param['grantType'] ?? '';
        $author    = $param['author'] ?? '';
        $email     = $param['email'] ?? '';
        $arg       = [];

        data_set($arg, 'app.name', Config::get('app.name'));
        data_set($arg, 'api.meta.author', $author);
        data_set($arg, 'api.meta.email', $email);
        data_set($arg, 'type', $type);
        data_set($arg, 'auth.user', $request->user() ? $request->user()->toArray() : '');
        data_set($arg, 'link.fullUrl', $request->fullUrl());
        data_set($arg, 'link.url', $request->url());
        data_set($arg, 'grantType', $grantType);

        return Arr::dot($arg);
    }

    /**
     * @return string
     */
    protected function getUuid(): string
    {
        return (string)Uuid::generate(4);
    }

    /**
     * @param       $id
     * @param       $errorObj
     * @param array $param
     *
     * @return array
     */
    protected function getErrorResponse($id, $errorObj, array $param = []): array
    {
        $request       = App::get('request');
        $errorResponse = [];

        data_set($errorResponse, 'error.id', $id);

        if ($errorObj instanceof \Exception) {
            data_set($errorResponse, 'error.code', $errorObj->getCode());
            data_set($errorResponse, 'error.title', $errorObj->getMessage());

            if (Config::get('app.env') !== 'production') {
                data_set($errorResponse, 'error.source.file', $errorObj->getFile());
                data_set($errorResponse, 'error.source.line', $errorObj->getLine());
                data_set($errorResponse, 'error.detail', $errorObj->getTraceAsString());
            }
        }

        data_set($errorResponse, 'link.self', $request->fullUrl());
        data_set($errorResponse, 'meta.copyright', 'copyrightⒸ ' . date('Y') . ' ' . Config::get('app.name'));
        data_set($errorResponse, 'meta.authors', Config::get('scaffold.api.authors'));

        return $errorResponse;
    }
}