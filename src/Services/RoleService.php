<?php
/**
 * RoleService.php
 * Created by rn on 11/11/2017 6:18 AM.
 */

namespace App\Components\Passerby\Services;

use Illuminate\Foundation\Application;
use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use App\Components\Passerby\Repositories\RoleRepositoryInterface;

class RoleService
{
    public function __construct(Application $app, RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;

        $this->apiConsumer = $app->make('apiconsumer');
        $this->auth        = $app->make('auth');
        $this->cookie      = $app->make('cookie');
        $this->db          = $app->make('db');
        $this->request     = $app->make('request');
    }

    public function get(array $options = [])
    {

    }

    public function create(array $data)
    {
        return $this->roleRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->roleRepository->update($data, $id);
    }

    public function delete()
    {

    }
}