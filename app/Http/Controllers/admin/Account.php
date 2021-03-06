<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Account extends Controller
{
    //登录
    public function login()
    {
        return view('admin.account.login');
    }
    //处理登录
    public function dologin(Request $request)
    {
        $username = $request->username;
        $pwd      = $request->pwd;
        $verifycode = $request->verifycode;
//        dd($username);
        // session中取验证码
        session_start();
        $store_code = $_SESSION['code'];
        if(strtolower($verifycode)!=strtolower($store_code)){
            exit(json_encode(array('code'=>1,'msg'=>'验证码错误'.$store_code)));
        }

        if($username==''){
            exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
        }
        if($pwd==''){
            exit(json_encode(array('code'=>1,'msg'=>'密码不能为空')));
        }
        // 认证用户
        $res = Auth::attempt(['username'=>$username,'password'=>$pwd]);
        if(!$res){
            exit(json_encode(array('code'=>1,'msg'=>'登录失败')));
        }

        // 最后登录时间
        DB::table('admin')->where('username',$username)->update(array('lastlogin'=>time()));
        return json_encode(array('code'=>0,'msg'=>'登录成功'));
    }
    public function logout()
    {
        Auth::logout();
        return json_encode(array('code'=>0,'msg'=>'退出登录成功'));
    }
    public function captcha(){
        VeriCode::create();

    }

    public function xz()
    {
        $dz = 'http://apis.juhe.cn/xzqh/query?fid=&key=f49d9e06ae9d309e1a949cbfe5f54f05';
//        发送请求并且转换为数组
        $res = array(file_get_contents($dz));
        foreach ($res as $key=>$val){
            //使用json_decode 对 JSON 格式的字符串进行解码
            $ress = json_decode($val);
            //转换为数组
            $ress = array($ress->result);

            foreach ($ress as $key=>$vals){
                foreach ($vals as $k=>$value){
                    //将省存入数据库
                    DB::table('sf')->insert(array('code'=>$value->id,'name'=>$value->name,'fid'=>$value->fid,'level_id'=>$value->level_id));
                    //将省fid放入接口中进行查询数据
                    $dsz = 'http://apis.juhe.cn/xzqh/query?fid='.$value->id.'&key=f49d9e06ae9d309e1a949cbfe5f54f05';
                    //        发送请求并且转换为数组
                    $dsz =array(file_get_contents($dsz));
                    foreach ($dsz as $ks=> $va){
                        $rees = json_decode($va);
                        $rees = array($rees->result);
                        foreach ($rees as $keys=>$valuses){
                            foreach ($valuses as $keyse => $valusess){
                                //将城市存入数据库
                                DB::table('sf')->insert(array('code'=>$valusess->id,'name'=>$valusess->name,'fid'=>$valusess->fid,'level_id'=>$valusess->level_id));
                                //将省fid放入接口中进行查询数据
                                $dszs = 'http://apis.juhe.cn/xzqh/query?fid='.$valusess->id.'&key=f49d9e06ae9d309e1a949cbfe5f54f05';
                                //        发送请求并且转换为数组
                                $dszs =array(file_get_contents($dszs));
                                foreach ($dszs as $keysy=>$valusesy){
                                    $reesy = json_decode($valusesy);
                                    $reesy = array($reesy->result);
                                    foreach ($reesy as $keysys=>$vaas){
                                        foreach ($vaas as $keye=>$vaa){
                                            //将城市存入数据库
                                            DB::table('sf')->insert(array('code'=>$vaa->id,'name'=>$vaa->name,'fid'=>$vaa->fid,'level_id'=>$vaa->level_id));
                                            echo '<pre>';
                                            print_r($valusess);
                                        }
                                    }
                                }
//                                echo '<pre>';
//                                print_r($valusess);
                            }
                        }
                        echo '<pre>';
                        print_r($rees);
                    }
                }
            }
        }
    }
    public function cs()
    {
        $res = DB::table('sf')->lists();
//        echo '<pre>';
//        print_r($res);
        foreach ($res as $key=>$values){
            echo '<pre>';
            print_r($values);
//            $dszs = 'http://apis.juhe.cn/xzqh/query?fid='.$valusess->id.'&key=f49d9e06ae9d309e1a949cbfe5f54f05';
        }
    }
    //密码加密
    public function mima()
    {
        $a = 123456;
        $rec = Hash::make($a);
        dd($rec);

        $res = decrypt($rec);
        dd($res);
    }
}
/**
* 验证码类
*/

class VeriCode{
    // 获取验证码配置
    private static function _getCodeConfig(){
        return  [
            // 验证码字符集
            'codeStr' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
            // 验证码个数
            'codeCount' => 4,
            // 字体大小
            'fontsize' =>18,
            // 验证码的宽度
            'width' => 100,
            // 验证码高度
            'height' => 36,
            // 是否有干扰点?true有,false没有
            'disturbPoint' => true,
            // 干扰点个数,disturbPoint开启后生效
            'pointCount' => 200,
            // 是否有干扰条?true有,false没有
            'disturbLine' => true,
            // 干扰条个数,disturbLine开启后生效
            'lineCount' => 3
        ];
    }

    // 创建图片验证码
    public static function create(){
        // 配置
        $config = self::_getCodeConfig();

        //创建画布
        $image = imagecreatetruecolor($config['width'],$config['height']);
        //背景颜色
        $bgcolor=imagecolorallocate($image,255,255,255);
        imagefill($image,0,0,$bgcolor);
        $captch_code = '';//存储验证码
        $captchCodeArr = str_split($config['codeStr']);

        //随机选取4个候选字符
        for($i=0;$i<$config['codeCount'];$i++){
            $fontsize = $config['fontsize'];
            $fontcolor=imagecolorallocate($image,rand(0,120),rand(0,120),rand(0,120));//随机颜色
            $fontcontent = $captchCodeArr[rand(0,strlen($config['codeStr'])-1)];
            $captch_code.=$fontcontent;
            $_x = $config['width']/$config['codeCount'];
            $x=($i*(int)$_x)+rand(5,10);   //随机坐标
            $y=rand(5,10);
            imagestring($image,$fontsize,$x,$y,$fontcontent,$fontcolor);	// 水平地画一行字符串
        }
        session_start();
        $_SESSION['code']=$captch_code;
        //增加干扰点
        if($config['disturbPoint']){
            for($i=0;$i<$config['pointCount'];$i++){
                $pointcolor=imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
                imagesetpixel($image,rand(1,99),rand(1,29),$pointcolor);
            }
        }

        //增加干扰线
        if($config['disturbLine']){
            for($i=0;$i<$config['lineCount'];$i++){
                $linecolor=imagecolorallocate($image,rand(80,280),rand(80,220),rand(80,220));
                imageline($image,rand(1,99),rand(1,29),rand(1,99),rand(1,29),$linecolor);
            }
        }

        //输出格式
        header('content-type:image/png');
        imagepng($image);

        //销毁图片
        imagedestroy($image);
    }
}
