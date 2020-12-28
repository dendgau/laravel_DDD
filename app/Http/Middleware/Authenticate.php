<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     * @throws ApiException
     */
    protected function redirectTo($request)
    {
        if ($request->is('api/*')) {
            throw new ApiException('User have not logged yet', $request->all());
        }
        return route('auth_login');
    }
}
