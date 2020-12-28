<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Domain\Contracts\Services\TestingServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{
    /**
     * LoginController constructor.
     * 
     * @param TestingServiceContract $appService
     */
    public function __construct(TestingServiceContract $appService)
    {
        parent::__construct($appService);
        $this->middleware('guest', ['except' => 'logout']);
        $this->middleware('auth:web', ['only' => 'logout']);
    }
    
    /**
     * Show view login
     * 
     * @param Request $request
     * @return type
     */
    public function login(Request $request)
    {
        return $this->respView('auth.login', []);
    }
    
    /**
     * Logout system
     * 
     * @param Request $request
     */
    public function logout(Request $request)
    {
        if ($request->has('logout')) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            return redirect()->route('auth_login');
        }
        return $this->respView('auth.logout', []);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        // Hard code for login
        $credentials = $request->only([
            'email',
            'password'
        ]);

        if (Auth::guard('web')->attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->route('test_index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
