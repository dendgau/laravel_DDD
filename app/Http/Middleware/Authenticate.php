<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     * @throws ApiException
     */
    protected function redirectTo($request)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            throw new ApiException('User have not logged yet');
        }
        return route('login');
    }
}
