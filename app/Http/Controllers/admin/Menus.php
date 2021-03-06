<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class menus extends Controller
{
    //菜单列表
    public function index(Request $request)
    {
        $mid = (int)$request->mid;
        $data['menus'] = DB::table('admin_menu')->where('pid',$mid)->lists();

        $data['pmenu'] = DB::table('admin_menu')->where('mid',$mid)->item();
        $data['mid']   = $mid;
        return view('admin.menus.index',$data);
    }
    //添加菜单
    public function add(Request $request)
    {

        $data['pid'] = (int)$request->pid;
        return view('admin.menus.add',$data);
    }
    //修改菜单
    public function edit(Request $request)
    {
        $mid = (int)$request->mid;
        $data['menu'] = DB::table('admin_menu')->where('mid',$mid)->item();
        return view('admin.menus.edit',$data);
    }

    public function save(Request $request)
    {
        $mid = (int)$request->mid;
        $data['pid'] = (int)$request->pid;
        $data['title'] = trim($request->title);
        $data['ord']   = (int)$request->ord;
        $data['controller'] = trim($request->controller);
        $data['action'] = trim($request->action);

        $data['ishidden'] = (int)$request->ishidden;
        $data['status'] = $request->status== 'on'?0:1;
        if ($data['title'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>'菜单名称不能为空')));
        }
        if ($mid == 0){
            DB::table('admin_menu')->insert($data);
        }else{
            DB::table('admin_menu')->where('mid',$mid)->update($data);
        }

        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));

    }
    //菜单删除
    public function del(Request $request)
    {
        $mid = (int)$request->mid;
        if (DB::table('admin_menu')->where('pid',$mid)->first()){
            exit(json_encode(array('code'=>1,'msg'=>'请先删除子菜单')));
        }else{
            DB::table('admin_menu')->where('mid',$mid)->delete();
        }
        exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
    }
}
