<?php
/**
 * PermissionRepository.php
 * Created by @anonymoussc on 11/11/2017 6:22 AM.
 */

namespace App\Components\Passerby\Repositories\Permissions;

use App\Components\Passerby\Repositories\Repository;
use App\Components\Passerby\Repositories\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends Repository implements PermissionRepositoryInterface
{
    private $permission;

    public function getModel()
    {
        return new Permission;
    }

    public function create(array $data = [])
    {
        $this->permission = $this->getModel();

        $this->permission->name = $data['name'];

        $this->permission->save();

        return $this->permission;
    }

    public function update(array $data = [], $id)
    {
        $this->permission = $this->getModel()->find($id);

        $this->permission->name = $data['name'];

        $this->permission->save();

        return $this->permission;
    }
}