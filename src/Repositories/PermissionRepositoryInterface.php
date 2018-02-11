<?php
/**
 * PermissionRepositoryInterface.php
 * Created by @anonymoussc on 11/11/2017 6:20 AM.
 */

namespace App\Components\Passerby\Repositories;

interface PermissionRepositoryInterface
{
    public function create(array $data);

    public function update(array $data, $id);
}