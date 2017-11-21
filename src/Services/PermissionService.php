<?php
/**
 * PermissionService.php
 * Created by rn on 11/11/2017 6:17 AM.
 */

namespace App\Components\Passerby\Services;

use Illuminate\Foundation\Application;
use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use App\Components\Passerby\Repositories\PermissionRepositoryInterface;

class PermissionService
{
    public function __construct(Application $app, PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function get(array $options = [])
    {
        return $this->permissionRepository->get($options);
    }

    public function create(array $data)
    {
        return $this->permissionRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->permissionRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->permissionRepository->delete($id);
    }

    public function deleteWhereArray(array $clauses)
    {
        return $this->permissionRepository->deleteWhereArray($clauses);
    }
}