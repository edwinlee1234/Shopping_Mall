<?php

namespace App\Http\Middleware;

use Closure;

class DetectLanguageMiddleware
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
        $language = $request->cookie('shopping_mall_language');

        switch ($language)
        {
            case 'tw':
                app()->setLocale('tw');
                break;
            case 'cn':
                app()->setLocale('cn');
                break;
            default:
                app()->setLocale('en');
                break;                
        }
        
        return $next($request);
    }
}
