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


class PermissionController extends Controller
{
    private $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function get()
    {
        $resourceOptions = $this->parseResourceOptions();

        return $this->response($this->permissionService->get($resourceOptions));

    }

    public function create(PermissionCreateRequest $request)
    {
        return $this->response($this->permissionService->create($request->all()));
    }

    public function update(PermissionUpdateRequest $request, $id)
    {
        return $this->response($this->permissionService->update($request->all(), $id));
    }

}