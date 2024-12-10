<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CusAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next){
        if (Auth::check() && Auth::user()->status === 'active' ) {
            // Người dùng đã đăng nhập, tiếp tục xử lý request
            return $next($request);
        } else {
            // Người dùng chưa đăng nhập, bạn có thể redirect hoặc xử lý theo ý muốn của bạn
          return redirect()->route('login/cus',[
                'id' => $request->segment(3)
            ]);
        }
     
        
    }
}
