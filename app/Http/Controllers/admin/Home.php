<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Home extends Controller
{
    //后台首页
    public function index(Request $request)
    {
        $data['admin'] = $request->admin;

        $data['menus'] = DB::table('admin_menu')->whereIn('mid',$data['admin']->rights)->where('pid',0)->where('ishidden',0)->where('status',0)->lists();
        foreach ($data['menus'] as $key => $val){
            $childs = DB::table('admin_menu')->whereIn('mid',$data['admin']->rights)->where('pid',$val['mid'])->where('ishidden',0)->where('status',0)->lists();
            $data['menus'][$key]['child'] = $childs;
        }

        return view('admin.home.index',$data);
    }
    public function welcome()
    {
        return view('admin.home.welcome');
    }
}
