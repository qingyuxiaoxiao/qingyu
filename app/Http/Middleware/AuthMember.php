<?php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Closure;

// 前台登录验证中间件
class AuthMember{
    public function handle($request, Closure $next)
    {
    	if(Auth::guard('member')->guest()){
    		if($request->ajax()){
    			$response = array('code'=>401,'msg'=>'no login');
    			return response(json_encode($response),200);
    		}
    		return redirect()->guest('member/login');
    	}
    	return $next($request);
    }
}