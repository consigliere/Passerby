<?php
/**
 * UserRepositoryInterface.php
 * Created by rn on 11/11/2017 5:33 AM.
 */

namespace App\Components\Passerby\Repositories;

use App\Components\Passerby\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data);

    public function update(User $user, array $data);
}