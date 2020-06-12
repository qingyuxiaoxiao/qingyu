<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class menus extends Controller
{
    //菜单列表
    public function index()
    {
        $data['menus'] = DB::table('admin_menu')->where('pid',0)->lists();
        return view('admin.menus.index',$data);
    }
    //添加菜单
    public function add()
    {
        return view('admin.menus.add');
    }
    public function save(Request $request)
    {
        $data['title'] = trim($request->title);
        $data['ord']   = (int)$request->ord;
        $data['controller'] = trim($request->controller);
        $data['action'] = trim($request->action);
        $data['icon'] = trim($request->icon);
        $data['ishidden'] = (int)$request->ishidden;
        $data['status'] = (int)$request->status;
        if ($data['title'] == ''){
            exit(json_decode(array('code'=>1,'msg'=>'菜单名称不能为空')));
        }
        DB::table('admin_menu')->insert($data);
        exit(json_decode(array('code'=>0,'msg'=>'保存成功')));

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
