<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use URL;
use Cache;
class RedirectIfNotUser1
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
        if (!Auth::guard($guard)->check()) {
			Session::put('user1.url.intended',URL::current());
            return redirect('/User1/Login');
        }
		else
		{
			$usr=\App\User1::find(Auth::user()->id);
			$usr->LastActivity=\Carbon\Carbon::now();
			$usr->save();
			
			Cache::remember('chatNotification-'.Auth::user()->HashCode, 60, function() {
				$msgs=\App\Chatmessage::where('User1ID','')->whereIn('ChatID', function($query){
						$query->select(array('id'))->from('chats')->where('User1ID',Auth::user()->HashCode)->get();
					})->orderBy('id', 'DESC')->take(10)->get();
					return($msgs);
				//return Article::all();
			});
			
			Cache::remember('instantChatUsers-'.Auth::user()->HashCode, 6000, function() {
				 $chatusers=\App\Chat::where('User1ID','=', Auth::user()->HashCode)->get();
				return($chatusers);
			});
			
		}

        return $next($request);
    }
	
	
}
