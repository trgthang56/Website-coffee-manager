<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
       
            if(Auth::user()->role > 4 && Auth::user()->status === 'active'){
        
                return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
            }
           
        // Kiểm tra quyền của người dùng
       

        return $next($request);
    }
}
