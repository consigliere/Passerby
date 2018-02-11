<?php
/**
 * InvalidCredentialsException.php
 * Created by @anonymoussc on 10/22/2017 1:29 AM.
 */

namespace App\Components\Passerby\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class InvalidCredentialsException extends UnauthorizedHttpException
{
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct('', $message, $previous, $code);
    }
}