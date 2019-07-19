<?php
/**
 * Controller.php
 * Created by @anonymoussc on 10/22/2017 1:26 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/19/19 11:34 PM
 */

namespace App\Components\Passerby\Http\Controllers;

use App\Components\Signal\Shared\ErrorLog;
use App\Components\Signal\Shared\Signal;
use App\Components\Signature\Http\Controllers\SignatureController as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

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
}