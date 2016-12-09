<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use URL;
use Cache;

class RedirectIfNotUser2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'user2')
    {
        if (!Auth::guard($guard)->check()) {
			Session::put('user2.url.intended',URL::current());
            return redirect('/User2/Login');
        }
		else
		{
			$usr=\App\User2::find(Auth::guard('user2')->user()->id);
			$usr->LastActivity=\Carbon\Carbon::now();
			$usr->save();
			
			Cache::remember('chatNotification-'.Auth::guard('user2')->user()->HashCode, 60, function() {
				$msgs=\App\Chatmessage::where('User2ID','')->whereIn('ChatID', function($query){
					$query->select(array('id'))->from('chats')->where('User2ID',Auth::guard('user2')->user()->HashCode)->get();
				})->orderBy('id', 'DESC')->take(10)->get();
				return($msgs);
				//return Article::all();
			});
			Cache::remember('instantChatUsers-'.Auth::guard('user2')->user()->HashCode, 60, function() {
				$chatusers=\App\Chat::where('User2ID','=', Auth::guard('user2')->user()->HashCode)->get();
				return($chatusers);
			});
		}

        return $next($request);
    }
	
	
}
