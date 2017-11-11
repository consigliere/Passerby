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

        $this->apiConsumer = $app->make('apiconsumer');
        $this->auth        = $app->make('auth');
        $this->cookie      = $app->make('cookie');
        $this->db          = $app->make('db');
        $this->request     = $app->make('request');
    }
}