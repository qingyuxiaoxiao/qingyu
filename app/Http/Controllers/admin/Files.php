<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Files extends Controller
{
    //图片上传
    public function upload_img(Request $request)
    {
        $path = $request->file('file')->store('public/avatars/'.date('Y/m/d'));
        $url = Storage::url($path);
        exit(json_encode(array('code'=>0,'msg'=>'','data'=>array('src'=>$url))));
        // linux 创建软连接 ln -s /www/admin/demo.nmgseozx.com_80/wwwroot/storage/app/public /www/admin/demo.nmgseozx.com_80/wwwroot/public/storage
/*
        //采用原生方式进行上传
        //获取上传文件
        $file = $request->file('file');
        //判断上传文件是否成功
        if(!$file->isValid()){
            return response()->json(['ServerNo'=>'400','ResultData'=>'无效的上传文件']);
        }
        //获取原文件的扩展名
        $ext = $file->getClientOriginalExtension();    //文件拓展名
        //新文件名
        $newfile = md5(time().rand(1000,9999)).'.'.$ext;
        //文件上传的指定路径

        $path = public_path('/uploads/'.date('Y/m/d'));
        //将文件从临时目录移动到本地指定目录
        if(! $file->move($path,$newfile)){
            return response()->json(['ServerNo'=>'400','ResultData'=>'保存文件失败']);
        }
        return response()->json(['ServerNo'=>'200','ResultData'=>$newfile]);
*/
    }
}
