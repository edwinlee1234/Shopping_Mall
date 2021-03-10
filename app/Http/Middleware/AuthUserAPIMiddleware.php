<?php

namespace App\Http\Middleware;

use Closure;
use App\Interfaces\Error as IError;

class AuthUserAPIMiddleware
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
            $res = [
                'result' => false,
                'errorCode' => IError::NOT_AUTH,
            ];

            return $res;
        }

        return $next($request);
    }
}
