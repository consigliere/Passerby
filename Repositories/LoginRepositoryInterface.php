<?php
/**
 * LoginRepositoryInterface.php
 * Created by @anonymoussc on 11/10/2017 10:33 AM.
 */

namespace App\Components\Passerby\Repositories;

use App\Components\Passerby\Entities\User;

/**
 * Interface LoginRepositoryInterface
 * @package App\Components\Passerby\Repositories
 */
interface LoginRepositoryInterface
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