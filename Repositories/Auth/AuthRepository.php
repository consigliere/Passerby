<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/15/19 9:21 AM
 */

/**
 * LoginRepository.php
 * Created by @anonymoussc on 11/10/2017 10:35 AM.
 */

/**
 * AuthRepository.php
 * @renamed by @anonymoussc on 05/15/2019 9:12 AM.
 */

namespace App\Components\Passerby\Repositories\Auth;

use App\Components\Passerby\Entities\User;
use App\Components\Passerby\Repositories\AuthRepositoryInterface;
use App\Components\Passerby\Repositories\Repository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

/**
 * Class AuthRepository
 * @package App\Components\Passerby\Repositories\Auth
 */
class AuthRepository extends Repository implements AuthRepositoryInterface
{
    private $userCfg;

    /**
     * @return mixed
     */
    public function getModel()
    {
        $this->userCfg = Config::get('auth.providers.apis.model');

        return new $this->userCfg;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        // Example
        $user = $this->getModel();

        $data['uuid']     = Uuid::generate(5, $data['username'], Uuid::NS_DNS);
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $user->save();

        return $user;
    }

    /**
     * @param \App\Components\Passerby\Entities\User $user
     * @param array                                  $data
     *
     * @return \App\Components\Passerby\Entities\User
     */
    public function update(User $user, array $data): User
    {

    }

    /**
     * @param $accessTokenId
     *
     * @return int
     */
    public function logout($accessTokenId)
    {
        return DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessTokenId)
            ->update(['revoked' => true,]);
    }

    /**
     * @param string $username
     *
     * @return mixed
     */
    public function getUserByUsernameOrEmail(string $username)
    {
        return $this->getModel()::where('username', $username)->orWhere('email', $username);
    }
}