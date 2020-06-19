<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Article extends Controller
{
    //文章列表
    public function index(Request $request)
    {
        $data['cate']  = DB::table('article_cate')->cates('id');
        $data['admin']   = DB::table('admin')->cates('id');
//      $data['article'] = DB::table('article')->lists();
        //实现分页
        $data['page'] = (int)$request->page;//获取分页
        $data['pageSize'] = 3;
        $pages = DB::table('article')->orderBy('id','desc')->pages($data['pageSize']);
        $data['article_list'] = $pages['lists'];
        $data['total']        = $pages['total']; //总数
        return view('admin.article.index',$data);
    }
    //文章添加
    public function add(Request $request)
    {
        $aid = (int)$request->aid;
        $data['article']  = DB::table('article')->where('id',$aid)->item();
        $data['contents'] = DB::table('article_detail')->where('aid',$aid)->item();
        $data['cates']    = DB::table('article_cate')->lists();
        $data['labels']    = DB::table('article_label')->lists();
        return view('admin.article.add',$data);
    }
    //文章保存
    public function save(Request $request)
    {
        $aid              = (int)$request->aid;
        $data['cid']      = (int)$request->cid;
        $data['title']    = trim($request->title);
        $data['subtitle'] = trim($request->subtitle);
        $data['thumb']    = trim($request->thumb);
        $data['keywords'] = trim($request->keywords);
        $data['descs']    = trim($request->descs);
        $data['auth_id']  = $request->admin->id;
        $data['status']   = (int)$request->status;



        $contents = trim($request->contents);
        //敏感词判断
        $swd_list = DB::table('article_swd')->lists();
        foreach ($swd_list as $swd){
            if (strpos($contents,$swd['name']) != false){
                exit(json_encode(array('code'=>1,'msg'=>'文章内容含有敏感词'.$swd['name'])));
            }
        }
        //        判断
        if ($data['cid'] == ""){
            exit(json_encode(array('code'=>1,'msg'=>'请选择分类')));
        }
        if ($data['title'] == ""){
            exit(json_encode(array('code'=>1,'msg'=>'请输入标题')));
        }
        if ($aid == 0){
            $data['add_time'] = time();
            $aid = DB::table('article')->insertGetId($data);
            if ($aid>0){
                DB::table('article_detail')->insert(array('aid'=>$aid,'contents'=>$contents));
            }
        }else{
            DB::table('article')->where('id',$aid)->update($data);
            DB::table('article_detail')->where('aid',$aid)->update(array('aid'=>$aid,'contents'=>$contents));
        }
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));

    }
    //文章删除
    public function del(Request $request)
    {
        $aid = (int)$request->aid;
        DB::table('article')->where('id',$aid)->delete();
        DB::table('article_detail')->where('aid',$aid)->delete();
        exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
    }

    //分类列表
    public function cates()
    {
        $data['cate'] = DB::table('article_cate')->lists();
        return view('admin.article.cates',$data);
    }
    //分类添加
    public function add_cate(Request $request)
    {
        $id = (int)$request->id;
        $data['cat'] = DB::table('article_cate')->where('id',$id)->item();
        if (!$data['cat']){
            $data['cat']['id'] = '';
            $data['cat']['title'] = '';
        }

        return view('admin.article.add_cate',$data);
    }
    //保存分类
    public function save_cate(Request $request)
    {
        $id = (int)$request->id;
        $title = trim($request->title);
        if ($title == ''){
            exit(json_encode(array('code'=>1,'msg'=>'分类名称不能为空')));
        }
        $res = DB::table('article_cate')->where('title',$title)->first();
        if ($id == 0){
            if ($res){
                exit(json_encode(array('code'=>1,'msg'=>'该账户已经存在')));
            }
            DB::table('article_cate')->insert(array('title'=>$title));
        }else{
            DB::table('article_cate')->where('id',$id)->update(array('title'=>$title));
        }
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
    public function del_cate(Request $request)
    {
        $id = (int)$request->id;
        //判断该分类下是否有文章，如果有文章将弹出提示，反之进行删除
        if ( DB::table('article')->where('cid',$id)->first()){
            exit(json_encode(array('code'=>1,'msg'=>'该分类下有文章无法删除')));
        }else{
            DB::table('article_cate')->where('id',$id)->delete();
        }
        exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
    }
}
