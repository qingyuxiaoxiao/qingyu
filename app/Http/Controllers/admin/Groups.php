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
        $data['groups'] = DB::table('admin_group')->lists();
        return view('admin.groups.index',$data);
    }
}
