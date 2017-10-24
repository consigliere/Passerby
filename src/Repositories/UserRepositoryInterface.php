<?php
/**
 * UserRepositoryInterface.php
 * Created by rn on 10/23/2017 12:58 AM.
 */

namespace App\Components\Passerby\Repositories;

use App\Components\Passerby\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data);

    public function update(User $user, array $data);
}
