<?php
/**
 * LoginCallable.php
 * Created by @anonymoussc on 01/10/2019 6:11 AM.
 */

/**
 * AuthCallable.php
 * @renamed by @anonymoussc on 05/15/2019 9:03 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 6/7/19 7:23 AM
 */

namespace App\Components\Passerby\Services\Auth\Shared;

/**
 * Trait AuthCallable
 * @package App\Components\Passerby\Services\Auth\Shared
 */
trait AuthCallable
{
    /**
     * @deprecated
     *
     * @param callable $proxy
     * @param          $grantType
     * @param array    $data
     * @param array    $option
     * @param array    $param
     *
     * @return array
     */
    public function proxy(Callable $proxy, $grantType, array $data = [], array $option = [], array $param = []): array
    {
        return $proxy($grantType, $data, $option, $param);
    }
}