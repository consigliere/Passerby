<?php
/**
 * Controller.php
 * Created by @anonymoussc on 10/22/2017 1:26 AM.
 */

namespace App\Components\Passerby\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Components\Signature\Http\Controllers\SignatureController as BaseController;
use App\Components\Signal\Shared\Signal;
use App\Components\Signal\Shared\ErrorLog;

/**
 * Class Controller
 * @package App\Components\Passerby\Http\Controllers
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Signal, ErrorLog;
}