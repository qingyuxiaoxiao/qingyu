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
    public function add(Request $request)
    {
        $gid = (int)$request->gid;

        $data['cur_group'] = DB::table('admin_group')->where('gid',$gid)->item();
        //默认值赋值
        if (!$data['cur_group']){
            $data['cur_group']['gid']    = 0;
            $data['cur_group']['title']  = '';
            $data['cur_group']['rights'] = [];
        }
        if ($data['cur_group'] && $data['cur_group']['rights']){
            $data['cur_group']['rights'] = json_decode($data['cur_group']['rights']);
        }
        //查询menus 表中，没有被禁用的菜单
        $data['menu_list'] = DB::table('admin_menu')->where('pid',0)->where('status',0)->lists();
        $all_menu          = DB::table('admin_menu')->where('status',0)->lists();
        foreach ($data['menu_list'] as $key => $value){
            $data['menu_list'][$key]['children'] = [];
            foreach ($all_menu as $k => $val){
                if ($value['mid'] == $val['pid']){
                    $data['menu_list'][$key]['children'][] = $val;
                }
            }
        }

        return view('admin.groups.add',$data);
    }

    //保存角色
    public function save(Request $request)
    {
        $gid = (int)$request->gid;

        $data['title'] = trim($request->title);
        $menus = $request->menus;
        $menus = array_keys($menus);

        $data['rights'] = json_encode($menus);

        if ($gid==0){
            DB::table('admin_group')->insert($data);
        }else{
            DB::table('admin_group')->where('gid',$gid)->update($data);
        }
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
    //删除角色
    public function del(Request $request)
    {
        $gid = (int)$request->gid;
        DB::table('admin_group')->where('gid',$gid)->delete();
        exit(json_encode(array('code'=>0,'msg'=>'删除成功')));

    }
}
