<?php
/**
 * PermissionController.php
 * Created by rn on 11/11/2017 5:29 AM.
 */

namespace App\Components\Passerby\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Components\Passerby\Requests\PermissionCreateRequest;
use App\Components\Passerby\Requests\PermissionUpdateRequest;
use App\Components\Passerby\Services\PermissionService;


class PermissionController
{
    private $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function create(PermissionCreateRequest $request)
    {
        $name = $request->input('name');

        $this->permissionService->create(['name' => $name]);

        //$permission       = new Permission();
        //$permission->name = $name;

        //$permission->save();

//        if (!empty($request['roles'])) { //If one or more role
//            foreach ($roles as $role) {
//                $r          = Role::where('id', '=', $role)->firstOrFail();
//                $permission = Permission::where('name', '=', $name)->first();
//                $r->givePermissionTo($permission);
//            }
//        }

        //return redirect()->route('permissions.index')->with('flash_message', 'Permission' . $permission->name . ' added!');
    }

    public function update(PermissionUpdateRequest $request)
    {
        $id    = $request->input('id');
        $value = $request->input('name');
    }

}