<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/15/19 9:06 AM
 */

/**
 * LoginCallable.php
 * Created by @anonymoussc on 01/10/2019 6:11 AM.
 */

/**
 * AuthCallable.php
 * @renamed by @anonymoussc on 05/15/2019 9:03 AM.
 */

namespace App\Components\Passerby\Services\Auth\Shared;

/**
 * Trait AuthCallable
 * @package App\Components\Passerby\Services\Auth\Shared
 */
trait AuthCallable
{
    /**
     * @param       $proxy
     * @param       $grantType
     * @param array $data
     * @param array $param
     *
     * @return array
     */
    public function proxy(Callable $proxy, $grantType, array $data = [], array $param = []): array
    {
        return $proxy($grantType, $data, $param);
    }
}