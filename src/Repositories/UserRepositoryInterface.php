<?php
/**
 * UserRepositoryInterface.php
 * Created by @anonymoussc on 11/11/2017 5:33 AM.
 */

namespace App\Components\Passerby\Repositories;

interface UserRepositoryInterface
{
    public function create(array $data);

    public function update(array $data, $id);
}