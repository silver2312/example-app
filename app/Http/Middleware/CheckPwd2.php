<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPwd2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && isset(Auth::user()->ma_c2) ) {
            return $next($request);
        }else{
            return redirect('trang-ca-nhan/cai-dat')->with('error','Bạn chưa có mã cấp 2. Vui lòng vào tạo mã cấp 2.');
        }
    }
}
