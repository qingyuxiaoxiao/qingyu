<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Rightvalidate
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
        $admin = Auth::user();
        $gid = $admin->gid;		// 当前用户的角色gid
        $group = DB::table('admin_group')->where('gid',$gid)->item();
        if(!$group){
            return response('该角色不存在',200);
        }
        $rights = [];
        if($group['rights']){
            $rights  = json_decode($group['rights'],true);
        }

        // 当前用户访问的是哪个菜单？
        $res = $request->route()->action['controller'];
        $res = explode('\\',$res);
        $res = $res[count($res)-1];
        $res = explode('@',$res);
        // 查询当前url对应的菜单

        $cur_menu = DB::table('admin_menu')->where('controller',$res[0])->where('action',$res[1])->item();
        if(!$cur_menu){
            return response('该功能不存在',200);
        }
        if($cur_menu['status']==1){
            return response('该功能已被禁用',200);
        }
        // 判断该mid是否在$rights数组中
        if(!in_array($cur_menu['mid'], $rights)){
            return response('权限不足',200);
        }
        return $next($request);
    }
}
