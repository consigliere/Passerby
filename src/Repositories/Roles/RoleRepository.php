<?php
/**
 * RoleRepository.php
 * Created by rn on 11/11/2017 6:22 AM.
 */

namespace App\Components\Passerby\Repositories\Roles;

use App\Components\Passerby\Models\User;
use App\Components\Passerby\Repositories\Repository;
use App\Components\Passerby\Repositories\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleRepository extends Repository implements RoleRepositoryInterface
{
    private $userCfg;

    public function getModel()
    {
        $this->userCfg = config('auth.providers.users.model');

        return new $this->userCfg;
    }

    public function create(array $data)
    {
        Role::create(['name' => 'writer']);
    }

    public function update(array $data, $id)
    {

    }
}