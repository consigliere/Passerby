<?php
/**
 * PermissionRepository.php
 * Created by rn on 11/11/2017 6:22 AM.
 */

namespace App\Components\Passerby\Repositories\Permissions;

use App\Components\Passerby\Repositories\Repository;
use App\Components\Passerby\Repositories\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Events\Dispatcher;


class PermissionRepository extends Repository implements PermissionRepositoryInterface
{
    private $permission;
    private $dispatcher;

    public function getModel()
    {
        return new Permission;
    }

    public function create(array $data = [])
    {
        try {
            $this->permission = $this->getModel();

            $this->permission->name = $data['name'];

            $this->permission->save();
        }
        catch (\Exception $e) {
            $this->permission = [
                'status' => false,
                'e'      => $e,
            ];

            return $this->permission;
        }

        return $this->permission;
    }

    public function update(array $data = [])
    {
        //$this->permission = Permission::find($data['id']);

        //return $this->permission;

        try {
            $this->permission = $this->getModel()->find($data['id']);

            $this->permission->name = $data['name'];

            $this->permission->save();
        }
        catch (\Exception $e) {
            $this->permission = [
                'status' => false,
                'e'      => $e,
            ];

            return $this->permission;
        }

        return $this->permission;
    }
}