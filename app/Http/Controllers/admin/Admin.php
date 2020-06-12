<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Admin extends Controller
{
    //
    public function index()
    {
        $data['admin'] = DB::table('admin')->lists();
        $data['db_groups'] = DB::table('admin_group')->select('gid','title')->cates('gid');
        return view('admin.admin.index',$data);
    }
    //渲染添加管理员
    public function add()
    {
        $data['groups'] = DB::table('admin_group')->select('gid','title')->lists();
        return view('admin.admin.add',$data);
    }
    //编辑管理员
    public function edit(Request $request)
    {
        $aid = $request->aid;
        $data['item'] = DB::table('admin')->where('id',$aid)->item();
        //渲染角色
        $data['groups'] = DB::table('admin_group')->select('gid','title')->lists();
        return view('admin.admin.edit',$data);
    }
    //执行管理员添加
    public function save(Request $request)
    {
        $aid               = (int)$request->aid;
        $username          = trim($request->username);
        $pwd               = trim($request->pwd);
        $data['gid']       = (int)$request->gid;
        $data['real_name'] = trim($request->real_name);
        $data['phone'] = trim($request->phone);
        $data['status']    = $request->status == 'on'?0:1;

        if ($aid === 0 && $username == ''){
            exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
        }

        if ($data['gid'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>'角色不能为空')));
        }

        //执行保存数据库
        if ($aid == 0){
            $res = DB::table('admin')->where('username',$username)->first();
            if ($res){
                exit(json_encode(array('code'=>1,'msg'=>'该账户已经存在')));
            }
            if ($pwd == ''){
                exit(json_encode(array('code'=>1,'msg'=>'密码不能为空')));
            }
            $data['username']  = $username;
            $data['add_time']  = time();
            $data['password'] = password_hash($pwd,PASSWORD_DEFAULT);
            DB::table('admin')->insert($data);
        }else{
            if ($pwd){
                $data['password'] = password_hash($pwd,PASSWORD_DEFAULT);
            }
            $data['update_time']  = time();
            DB::table('admin')->where('id',$aid )->update($data);
        }
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
    //删除管理员
    public function del(Request $request)
    {
        $aid = (int)$request->aid;
        DB::table('admin')->where('id',$aid)->delete();
        exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
    }


}
