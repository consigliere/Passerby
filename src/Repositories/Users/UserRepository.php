<?php
/**
 * UserRepository.php
 * Created by rn on 11/11/2017 5:34 AM.
 */

namespace App\Components\Passerby\Repositories\Users;

use App\Components\Passerby\Models\User;
use App\Components\Passerby\Repositories\Repository;
use App\Components\Passerby\Repositories\UserRepositoryInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{
    private $userCfg;

    public function getModel()
    {
        $this->userCfg = config('auth.providers.users.model');

        return new $this->userCfg;
    }

    public function create(array $data)
    {
    }

    public function update(array $data, $id)
    {
    }
}