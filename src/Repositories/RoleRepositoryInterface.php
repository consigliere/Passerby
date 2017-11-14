<?php
/**
 * RoleRepositoryInterface.php
 * Created by rn on 11/11/2017 6:19 AM.
 */

namespace App\Components\Passerby\Repositories;

use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function create(array $data);

    public function update(Role $role, array $data);
}