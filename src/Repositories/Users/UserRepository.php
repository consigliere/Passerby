<?php
/**
 * UserRepository.php
 * Created by rn on 10/22/2017 1:31 AM.
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
        $user = $this->getModel();

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $user->fill($data);
        $user->save();

        return $user;
    }

    public function update(User $user, array $data)
    {
        $user->fill($data);

        $user->save();

        return $user;
    }
}