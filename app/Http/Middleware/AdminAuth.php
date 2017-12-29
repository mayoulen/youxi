<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class AdminAuth
{

    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if (!$this->auth->guard('admin')->check() 
            || !$this->auth->guard('admin')->user()->is_admin
            ) {

            return redirect()->route('admin_show_login');

        }

        $this->auth->shouldUse('admin');

        return $next($request);
    }

}
