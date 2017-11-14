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

    public function list()
    {

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}