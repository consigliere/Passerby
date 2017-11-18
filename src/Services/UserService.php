<?php
/**
 * UserService.php
 * Created by rn on 11/11/2017 5:31 AM.
 */

namespace App\Components\Passerby\Services;

use Illuminate\Foundation\Application;
use App\Components\Passerby\Exceptions\InvalidCredentialsException;
use App\Components\Passerby\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(Application $app, UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;

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
        return $this->userRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->userRepository->update($data, $id);
    }

    public function delete()
    {

    }
}