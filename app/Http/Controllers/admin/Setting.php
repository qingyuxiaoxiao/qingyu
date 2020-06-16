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
}
