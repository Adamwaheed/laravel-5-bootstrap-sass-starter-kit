<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Entrust;

class Authenticate
{
		protected $redirectTo = '/admin';
	
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
			if (! Entrust::hasRole('Mod') && ! Entrust::hasRole('Admin')) {
				if ($request->ajax()) {
						return response('Unauthorized.', 401);
				} else {
						return redirect()->guest('auth/login');
				}
			}
			return $next($request);
    }
}
