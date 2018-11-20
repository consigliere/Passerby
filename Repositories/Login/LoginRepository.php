<?php
/**
 * LoginRepository.php
 * Created by @anonymoussc on 11/10/2017 10:35 AM.
 */

namespace App\Components\Passerby\Repositories\Login;

use App\Components\Passerby\Entities\User;
use App\Components\Passerby\Repositories\Repository;
use App\Components\Passerby\Repositories\LoginRepositoryInterface;

class LoginRepository extends Repository implements LoginRepositoryInterface
{
    private $userCfg;

    public function getModel()
    {
        // $this->userCfg = config('auth.providers.apis.model');

        return new User();
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