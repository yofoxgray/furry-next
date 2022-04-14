<?php
namespace app\user\controller;

use think\Db;
use think\facade\Cookie;
use think\Controller;

class Register extends Controller
{
    public function index()
    {
        if(Cookie::has('user')){
            header("Location: /");
            exit();
        }else{
            $this->assign('title','注册到网站');//标题
            return $this->fetch("register/index");
        }
    }

    public function sign(){
        $name = $_POST['username'];
        $disname = $_POST['displayname'];
        $des = $_POST['des'];
        $is_furry = $_POST['is_furry'];
        $gender = $_POST['gender'];
        $bacc = $_POST['bacc'];
        $pass = $_POST['password'];

        if(strpos($name,'\\') || strpos($name,'.') || strpos($name,',') || strpos($name,'`')) return 'dc0';
        if(strpos($pass,'\\') || strpos($pass,'.') || strpos($pass,',') || strpos($pass,'`') || strpos($pass,'~')) return 'dc1';
        if(strpos($disname,'\\') || strpos($disname,'.') || strpos($disname,',') || strpos($disname,'`')) return 'dc2';
        if(!empty(Db::table('user_list')->where('username',$name)->find())) return 'has';
        Db::table('user_list')->insert(['username'=>$name,'displayname'=>$disname,'passwordmd5'=>md5($pass),'describe'=>$des,'gender'=>$gender,'type'=>0,'is_furry'=>$is_furry,'baccount'=>$bacc]);
        return "yes";
    }
}
