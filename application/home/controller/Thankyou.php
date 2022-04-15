<?php
namespace app\home\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class Thankyou extends Controller
{
    public function index()
    {
        $dontshowfirst = Cookie::has('dontshowfirst');
        $this->assign('dontshowfirst', $dontshowfirst);

        $this->assign('title', '感谢！');//标题

        $this->assign('login', Cookie::get('user'));

        return $this->fetch('thankyou/lists');
    }

    public function yijian()
    {
//        if (!Cookie::has('user')) {
//            return"<!DOCTYPE html><html><head><meta charset='UTF-8'><link rel='stylesheet' href='/static/frame/sweetalert2/sweetalert2.min.css'><script src='/static/frame/sweetalert2/sweetalert2.all.min.js'></script></head><body><script>swal.fire('警告','请先登录正常账号','warning').then((result) => {window.open('/user.php/login','_self');})</script></body>";
//        }
        $this->assign('login', Cookie::get('user'));

        if(Cookie::has('user')) $u = Cookie::get('user');
        else $u = Cookie::get('temp-user');

        $lists = Db::table('yijian_list')->where('user_id', $u)->paginate(8);
        $this->assign('lists', $lists);
        $this->assign('title', '意见');//标题
        return $this->fetch('thankyou/yijian');
    }
    public function yijian_get(){
//        if (!Cookie::has('user')) {
//            header('Location: /');
//            exit();
//        }

        $title = $_POST['title'];
        $content = $_POST['content'];
        if(mb_strstr($title,'傻逼') || mb_strstr($content,'傻逼')) return"<!DOCTYPE html><html><head><meta charset='UTF-8'><link rel='stylesheet' href='/static/frame/sweetalert2/sweetalert2.min.css'><script src='/static/frame/sweetalert2/sweetalert2.all.min.js'></script></head><body><script>swal.fire('提示','内容或标题中包含敏感词！','warning').then((result) => {history.back()})</script></body>";
        else if(mb_strstr($title,'s逼') || mb_strstr($content,'s逼')) return"<!DOCTYPE html><html><head><meta charset='UTF-8'><link rel='stylesheet' href='/static/frame/sweetalert2/sweetalert2.min.css'><script src='/static/frame/sweetalert2/sweetalert2.all.min.js'></script></head><body><script>swal.fire('提示','内容或标题中包含敏感词！','warning').then((result) => {history.back()})</script></body>";
        else if(mb_strstr($title,'傻子') || mb_strstr($content,'傻子')) return"<!DOCTYPE html><html><head><meta charset='UTF-8'><link rel='stylesheet' href='/static/frame/sweetalert2/sweetalert2.min.css'><script src='/static/frame/sweetalert2/sweetalert2.all.min.js'></script></head><body><script>swal.fire('提示','内容或标题中包含敏感词！','warning').then((result) => {history.back()})</script></body>";
        else if(mb_strstr($title,'王八蛋') || mb_strstr($content,'王八蛋')) return"<!DOCTYPE html><html><head><meta charset='UTF-8'><link rel='stylesheet' href='/static/frame/sweetalert2/sweetalert2.min.css'><script src='/static/frame/sweetalert2/sweetalert2.all.min.js'></script></head><body><script>swal.fire('提示','内容或标题中包含敏感词！','warning').then((result) => {history.back()})</script></body>";
        else if(mb_strstr($title,'傻b') || mb_strstr($content,'傻b')) return"<!DOCTYPE html><html><head><meta charset='UTF-8'><link rel='stylesheet' href='/static/frame/sweetalert2/sweetalert2.min.css'><script src='/static/frame/sweetalert2/sweetalert2.all.min.js'></script></head><body><script>swal.fire('提示','内容或标题中包含敏感词！','warning').then((result) => {history.back()})</script></body>";

        if(Cookie::has('user')) $u = Cookie::get('user');
        else $u = Cookie::get('temp-user');
        Db::table('yijian_list')->data(['title'=>$title,'content'=>$content,'user_id'=>$u,'return_info'=>'已提交','state'=>0,'return_user'=>-1])->insert();
        header('Location: /thankyou/yijian');
        exit();
    }
}
