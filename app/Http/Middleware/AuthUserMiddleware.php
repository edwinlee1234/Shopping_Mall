<?php

namespace App\Http\Middleware;

use Closure;

class AuthUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $is_allow_access = false;
        
        $admin_id = session()->get('user_info')['id'];
        
        if (!is_null($admin_id)) {

            $is_allow_access = true;
        }
        
        if (!$is_allow_access) {
            
            return redirect()->to('/user/auth/sign-in');
        }    
                
        return $next($request);
    }
}
