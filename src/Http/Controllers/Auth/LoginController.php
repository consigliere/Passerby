<?php
/**
 * LoginController.php
 * Created by rn on 10/24/2017 3:52 AM.
 */

namespace App\Components\Passerby\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Components\Passerby\Requests\LoginRequest;
use App\Components\Passerby\Http\Controllers\Controller;
use App\Components\Passerby\Services\AuthService;

class LoginController extends Controller
{
    private $loginProxy;

    public function __construct(AuthService $loginProxy)
    {
        $this->loginProxy = $loginProxy;
    }

    public function login(LoginRequest $request)
    {
        $email    = $request->input('email');
        $password = $request->input('password');

        return $this->response($this->loginProxy->attemptLogin($email, $password));
    }

    public function refresh(Request $request)
    {
        return $this->response($this->loginProxy->attemptRefresh());
    }

    public function logout()
    {
        $this->loginProxy->logout();

        return $this->response(null, 204);
    }
}