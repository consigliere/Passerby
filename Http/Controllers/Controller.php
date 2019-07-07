<?php
/**
 * Controller.php
 * Created by @anonymoussc on 10/22/2017 1:26 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/8/19 6:00 AM
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
use JsonSerializable;

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
}