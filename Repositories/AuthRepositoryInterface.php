<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/15/19 9:21 AM
 */

/**
 * LoginRepositoryInterface.php
 * Created by @anonymoussc on 11/10/2017 10:33 AM.
 */

/**
 * AuthRepositoryInterface.php
 * @renamed by @anonymoussc on 05/15/2019 9:20 AM.
 */

namespace App\Components\Passerby\Repositories;

use App\Components\Passerby\Entities\User;

/**
 * Interface AuthRepositoryInterface
 * @package App\Components\Passerby\Repositories
 */
interface AuthRepositoryInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param \App\Components\Passerby\Entities\User $user
     * @param array                                  $data
     *
     * @return mixed
     */
    public function update(User $user, array $data);
}