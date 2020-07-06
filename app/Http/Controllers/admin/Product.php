<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Controller
{
    //商品列表
    public function index(Request $request)
    {
        $data['page'] = (int)$request->page;
        $data['pageSize'] = 3;
        $pages = DB::table('product')->orderBy('id','desc')->pages($data['pageSize']);
        $data['product_list'] = $pages['lists'];
        $data['total'] = $pages['total'];
//         当前列表中包含哪些商品分类？
        $cate_ids = array_column($pages['lists'],'cid');
//        商品分类
        $data['cates'] = [];
        if($cate_ids){
            $cate_ids = array_unique($cate_ids);
            $data['cates'] = DB::table('product_cate')->whereIn('id',$cate_ids)->cates('id');
        }
        return view('admin.product.index',$data);
    }
    //商品添加
    public function add(Request $request)
    {
        $pro_id = (int)$request->pro_id;
        $data['item'] = DB::table('product')->where('id',$pro_id)->item();
        if ($data['item']){
            $cate_item = DB::table('product_cate')->where('id',$data['item']['cid'])->item();
            $data['item']['cate_title'] = $cate_item['title'];
        }
        $data['detail'] = DB::table('product_detail')->where('proid',$pro_id)->item();
        return view('admin.product.add',$data);
    }
    //保存商品
    public function save(Request $request)
    {
        $pro_id = (int)$request->pro_id;
        $data['title'] = trim($request->title);
        $data['subtitle'] = trim($request->subtitle);
        $data['price'] = $request->price;
        $data['stock'] = (int)$request->stock;
        $data['cid'] = (int)$request->cid;
        $data['thumb'] = trim($request->thumb);
        $data['keywords'] = trim($request->keywords);
        $data['descs'] = trim($request->descs);
        $data['status'] =(int)$request->status;
        $contents = trim($request->contents);
        if($pro_id==0){
            $data['add_time'] = time();
            $pro_id = DB::table('product')->insertGetId($data);
            DB::table('product_detail')->insert(['proid'=>$pro_id,'contents'=>$contents]);
        }else{
            DB::table('product')->where('id',$pro_id)->update($data);
            DB::table('product_detail')->where('proid',$pro_id)->update(['contents'=>$contents]);
        }
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
    //搜索商品分类
    public function search_product_cates(Request $request)
    {
        $wd = trim($request->wd);
        $lists = DB::table('product_cate')->where('title','like','%'.$wd.'%')->limit(20)->lists();
        exit(json_encode(array('code'=>0,'data'=>$lists)));
    }
}
