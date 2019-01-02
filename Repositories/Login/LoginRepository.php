<?php
/**
 * LoginRepository.php
 * Created by @anonymoussc on 11/10/2017 10:35 AM.
 */

namespace App\Components\Passerby\Repositories\Login;

use Illuminate\Support\Facades\Config;
use App\Components\Passerby\Entities\User;
use App\Components\Passerby\Repositories\Repository;
use App\Components\Passerby\Repositories\LoginRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class LoginRepository
 * @package App\Components\Passerby\Repositories\Login
 */
class LoginRepository extends Repository implements LoginRepositoryInterface
{
    /**
     * @var
     */
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
        $user = $this->getModel();

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $user->fill($data);
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
        $user->fill($data);

        $user->save();

        return $user;
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
            ->update([
                'revoked' => true,
            ]);
    }
}