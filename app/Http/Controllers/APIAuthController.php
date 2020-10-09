<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Contracts\Services\TestingServiceContract;
use Illuminate\Http\JsonResponse;
use Validator;

/**
 * Class AuthController
 * @copyright https://www.positronx.io/laravel-jwt-authentication-tutorial-user-login-signup-api/
 * @inheritDoc https://jwt-auth.readthedocs.io/en/develop/auth-guard/
 * @package App\Http\Controllers
 */
class APIAuthController extends Controller
{
    /**
     * AuthController constructor.
     * @param TestingServiceContract $appService
     */
    public function __construct(TestingServiceContract $appService)
    {
        parent::__construct($appService);
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @param LoginFormRequest $request
     * @return mixed
     */
    public function login(LoginFormRequest $request)
    {
        if (!$token = auth()->attempt($request->only(['email', 'password']))) {
            return $this->respApiNoData('Unauthorized', 401);
        }
        return $this->respApi($this->createNewToken($token));
    }

    /**
     * Register a User.
     *
     * @param RegisterFormRequest $request
     * @return JsonResponse
     */
    public function register(RegisterFormRequest $request)
    {
        /** @var $userRepo UserRepositoryContract */
        $userRepo = app(UserRepositoryContract::class);

        $user = $userRepo->create(array_merge(
            $request->only('name', 'email', 'password'),
            ['password' => bcrypt($request->get('password'))]
        ));

        return $this->respApi($user);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return $this->respApiNoData('User successfully signed out');
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function profile()
    {
        return $this->respApi(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return array
     */
    protected function createNewToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ];
    }

}
