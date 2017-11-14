<?php
/**
 * PermissionRepository.php
 * Created by rn on 11/11/2017 6:22 AM.
 */

namespace App\Components\Passerby\Repositories\Permissions;

use App\Components\Passerby\Models\User;
use App\Components\Passerby\Repositories\Repository;
use App\Components\Passerby\Repositories\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends Repository implements PermissionRepositoryInterface
{
    public function getModel()
    {
        return new Permission;
    }

    public function create(array $data)
    {
        $permission = $this->getModel();

        $permission->fill($data);

        $permission->save();

        return $permission;
    }

    public function update($id, $newValue, array $data)
    {
        //$flight = App\Flight::find($id);
        $permission = $this->getModel()->find($id);

        $permission->name = 'New Flight Name';

        $permission->save();

        return $permission;
    }
}