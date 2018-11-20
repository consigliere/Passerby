<?php
/**
 * Controller.php
 * Created by @anonymoussc on 10/22/2017 1:26 AM.
 */

namespace App\Components\Passerby\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Components\Signature\Http\Controllers\SignatureController as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}