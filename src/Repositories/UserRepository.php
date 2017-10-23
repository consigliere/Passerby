<?php
/**
 * UserRepository.php
 * Created by rn on 10/22/2017 1:31 AM.
 */

namespace App\Components\Passerby\Repositories;

use App\Components\Passerby\Models\User;

class UserRepository extends DatabaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
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