<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HttpsProtocol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
	public function handle($request, Closure $next)
	{
		if (!$request->secure() && env('APP_ENV') === ENV_PRODUCTION) {
			return redirect()->secure($request->getRequestUri());
		}
	
		return $next($request);
	}
	
}
