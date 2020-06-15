<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Groups extends Controller
{
    //角色列表
    public function index()
    {
        $data['groups'] = DB::table('admin_group')->select('gid','title')->lists();
        return view('admin.groups.index',$data);
    }
    //添加角色
    public function add()
    {
        //查询menus 表中，没有被禁用的菜单
        $data['menu_list'] = DB::table('admin_menu')->where('status',0)->lists();
        /*echo '<pre>';
        print_r($data);*/
        return view('admin.groups.add',$data);
    }
    //编辑角色
    public function edit()
    {

    }
    //保存角色
    public function save(Request $request)
    {
        $data['title'] = trim($request->title);
        $menus = $request->menus;
        $menus = array_keys($menus);

        $data['rights'] = json_encode($menus);
        DB::table('admin_group')->insert($data);
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));


    }
    //删除角色
    public function del()
    {

    }
}
