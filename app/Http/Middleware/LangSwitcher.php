<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use URL;
use Cache;
class LangSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'user1')
    {
        if(!\Session::has('locale'))
    {
       \Session::put('locale', \Config::get('app.locale'));
    }

		app()->setLocale(\Session::get('locale'));
        return $next($request);
    }
	
	
}
