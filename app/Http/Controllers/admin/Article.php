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
//        $data['article'] = DB::table('article')->lists();
        //实现分页
        //获取分页
        $data['page'] = (int)$request->page;
        $data['pageSize'] = 1;
        $pages = DB::table('article')->pages($data['pageSize']);
        $data['article_list'] = $pages['lists'];
        $data['total']        = $pages['total']; //总数
        return view('admin.article.index',$data);
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
