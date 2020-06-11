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
        foreach ($data['admin'] as $key =>$val)
        {
            $group = DB::table('admin_group')->where('gid',$val['gid'])->first();
            $data['admin'][$key]['group_title'] = $group->title;
        }

        return view('admin.admin.index',$data);

    }
    //渲染添加管理员
    public function add()
    {
        $data['groups'] = DB::table('admin_group')->select('gid','title')->lists();
        return view('admin.admin.add',$data);
    }
    //执行管理员添加
    public function save(Request $request)
    {
        $data['username']  = trim($request->username);
        $pwd               = trim($request->pwd);
        $data['gid']       = (int)$request->gid;
        $data['real_name'] = trim($request->real_name);
        $data['phone'] = trim($request->phone);
        $data['status']    = $request->status == 'on'?0:1;
        $data['add_time']  = time();
        if ($data['username'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
        }
        if ($pwd == ''){
            exit(json_encode(array('code'=>1,'msg'=>'密码不能为空')));
        }
        if ($data['gid'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>'角色不能为空')));
        }
        $res = DB::table('admin')->where('username',$data['username'])->first();
        if ($res){
            exit(json_encode(array('code'=>1,'msg'=>'该账户已经存在')));
        }
        //执行保存数据库
        $data['password'] = password_hash($pwd,PASSWORD_DEFAULT);
        DB::table('admin')->insert($data);
        exit(json_encode(array('code'=>0,'msg'=>'账户添加成功')));
    }
    //删除管理员
    public function del(Request $request)
    {
        $aid = (int)$request->aid;
        DB::table('admin')->where('id',$aid)->delete();
        exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
    }
    //编辑管理员
    public function edit($id)
    {
        $data = DB::table('admin')->where('id',$id)->first();
//        echo '<pre>';
//        print_r($data);
        //渲染角色
        $groups = DB::table('admin_group')->select('gid','title')->lists();
//        echo '<pre>';
//        print_r($groups);
        return view('admin.admin.edit',compact('data','groups'));
    }
    public function update(Request $request)
    {
        $data['id']        = (int)$request->id;
        $data['username']  = trim($request->username);
        $data['gid']       = (int)$request->gid;
        $data['real_name'] = trim($request->real_name);
        $data['phone'] = trim($request->phone);
        $data['status']    = $request->status == 'on'?0:1;
        $data['update_time']  = time();
        if ($data['username'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
        }

        if ($data['gid'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>'角色不能为空')));
        }
        $res = DB::table('admin')->where('username',$data['username'])->first();
        if ($res){
            exit(json_encode(array('code'=>1,'msg'=>'该账户已经存在')));
        }
        //执行保存数据库
        DB::table('admin')->where('id',$data['id'] )->update($data);
        exit(json_encode(array('code'=>0,'msg'=>'账户修改成功')));
    }
}
