<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Setting extends Controller
{
    //
    public function index()
    {
        $data['setting'] = DB::table('setting')->where('names','site_setting')->item();
        if ($data['setting']){
            $data['setting']['vals'] = json_decode($data['setting']['vals'] ,true);
        }
        return view('admin.setting.index',$data);
    }
    public function save(Request $request)
    {
        $data['title']    = $request->title;
        $data['keywords'] = $request->keywords;
        $data['desc']     = $request->desc;
        $data['tcpbeian'] = $request->tcpbeian;
        $data['gabeian']  = $request->gabeian;
        if (!$data['title']){
            exit(json_encode(array('code'=>1,'msg'=>'网站标题不能为空')));
        }
        $item = DB::table('setting')->where('names','site_setting')->item();
        if ($item){
            DB::table('setting')->where('names','site_setting')->update(array('names'=>'site_setting','vals'=>json_encode($data)));
        }else{
            DB::table('setting')->insert(array('names'=>'site_setting','vals'=>json_encode($data)));
        }
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
    //友情链接
    public function friend_link()
    {
        $data['link'] = DB::table('friend_link')->lists();
        return view('admin.setting.friend_link',$data);
    }
    //添加友链
    public function add_friend()
    {
        return view('admin.setting.add_friend');
    }
    //编辑友链
    public function edit_friend(Request $request)
    {
        $id = $request->id;
        $data['item'] = DB::table('friend_link')->where('id',$id)->item();

        return view('admin.setting.edit_friend',$data);
    }
    //保存友链
    public function save_friend(Request $request)
    {
        $id    = (int)$request->id;
        $data['title'] = trim($request->title);
        $data['url']   = trim($request->url);
        $data['ord']   = trim($request->ord);
        if ($data['title'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>'网站名称不能为空')));
        }
        if ($data['url'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>'网站名称不能为空')));
        }
        //判断该网址是否已经存在
        $res = DB::table('friend_link')->where('url',$data['url'])->first();

        if ($id == 0){
            if ($res){
                exit(json_encode(array('code'=>1,'msg'=>'该网站已经存在')));
            }
            $data['add_time']  = time();
            DB::table('friend_link')->insert($data);
        }else{
            DB::table('friend_link')->where('id',$id)->update($data);
        }

        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }

    //删除友链
    public function del_friend_link(Request $request)
    {
        $id = (int)$request->id;
        DB::table('friend_link')->where('id',$id)->delete();
        exit(json_encode(array('code'=>0,'msg'=>'删除成功')));

    }
}
