<?php
/**
 * LoginRepositoryInterface.php
 * Created by @anonymoussc on 11/10/2017 10:33 AM.
 */

namespace App\Components\Passerby\Repositories;

use App\Components\Passerby\Entities\User;

interface LoginRepositoryInterface
{
    public function create(array $data);

    public function update(User $user, array $data);
}