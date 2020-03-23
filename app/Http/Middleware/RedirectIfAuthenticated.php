<?php

namespace App\Http\Middleware;

use App\Cache\RedisManage;
use App\Constants\Constant;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        if (Auth::guard($guard)->check()) {
//            return redirect(RouteServiceProvider::HOME);
//        }
        if(!$request->filled('user_id') || !$request->filled('token')) {
            return redirect(RouteServiceProvider::HOME);
        }
        
        $redis = new RedisManage();

        $userKey = sprintf(Constant::REDIS_USER,$request->input('user_id'));
        $user = $redis->get($userKey);

        if(is_null($user)){
            return redirect(RouteServiceProvider::HOME);
        }

        $userTokenKey = sprintf(Constant::REDIS_USER_TOKEN,$request->input('user_id'));
        $token = $redis->get($userTokenKey);

        if(is_null($token)){
            return redirect(RouteServiceProvider::HOME);
        }
        if(!Str::contains($token, $request->input('token'))) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
