<?php
/**
 * RoleController.php
 * Created by @anonymoussc on 11/11/2017 5:15 AM.
 */

namespace App\Components\Passerby\Http\Controllers;

use App\Components\Passerby\Services\RoleService;
use App\Components\Passerby\Requests\RoleCreateRequest;
use App\Components\Passerby\Requests\RoleUpdateRequest;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function get()
    {
        $resourceOptions = $this->parseResourceOptions();

        return $this->response($this->roleService->get($resourceOptions));

    }

    public function create(RoleCreateRequest $request)
    {
        return $this->response($this->roleService->create($request->all()));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        return $this->response($this->roleService->update($request->all(), $id));
    }

    public function delete($id)
    {
        return $this->response($this->roleService->delete($id));
    }
}