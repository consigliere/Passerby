<?php
/**
 * PermissionRepositoryInterface.php
 * Created by rn on 11/11/2017 6:20 AM.
 */

namespace App\Components\Passerby\Repositories;

use Spatie\Permission\Models\Permission;

interface PermissionRepositoryInterface
{
    public function create(array $data);

    public function update($id, array $data);
}