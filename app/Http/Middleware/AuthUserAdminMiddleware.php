<?php

namespace App\Http\Middleware;

use App\Model\User as UserModel;
use Closure;

class AuthUserAdminMiddleware
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
        
        $admin_id = session()->get('admin_info')['id'];
        
        if (!is_null($admin_id)) {
            $User = UserModel::findOrFail($admin_id);
            
            if ($User->type === 'A') {
                $is_allow_access = true;
            }
        }
        
        if (!$is_allow_access) {
            
            return redirect()->to('/admin/sign-in');
        }    
        
        return $next($request);
    }
}
