<?php
namespace app\user\controller;

use think\Db;
use think\facade\Cookie;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
        if(Cookie::has('user')){
            header("Location: /");
            exit();
        }else{
            if($_POST && $_POST['return']) $as=$_POST['return'];
            else $as='';
            $this->assign('title','登录');//标题
            $this->assign("return",$as=='no');
            return $this->fetch("login/index");
        }
    }

    public function c(){
        if(Cookie::has('user')) return 'has';
        $name = $_POST['username'];
        $pass = $_POST['password'];
        $userl = Db::table('user_list')->where('username',$name)->find();
        if(is_array($userl)){
            if(md5($pass)==$userl['passwordmd5']){
                Cookie::set('user',$userl['id']);
                Cookie::set('user_md5',md5($userl['id']));
                return 'yes';
            }else{
                return 'not';
            }
        }else{
            return 'not';
        }
    }

    public function out(){
        if(!Cookie::has('user')){
            header("Location: /");
            exit();
        }
        Cookie::delete('user');
        header("Location: /");
        exit();
    }

    public function temp_rg(){
        $ap = $_GET['l'];
        if(mb_strlen($ap) < 2) return 'short';
        Cookie::set('temp-user',$ap,9999999999);
        return 'ok';
    }
}
