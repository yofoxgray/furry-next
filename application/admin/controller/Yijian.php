<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class Yijian extends Controller
{
    public function index()
    {
        if(Cookie::has('user')){
            $users = Db::table('user_list')->where('id',Cookie::get('user'))->find();
            if($users['type'] != 1){
                header('Location: /user.php');
                exit();
            }
        }else{
            header('Location: /');
            exit();
        }

        $this->assign('title','意见 - 控制台');//标题
        $lists = Db::table('yijian_list')->paginate(6);
        $this->assign('lists',$lists);
        return $this->fetch('yijian/list');
    }

    public function rt()
    {
        if(Cookie::has('user')){
            $users = Db::table('user_list')->where('id',Cookie::get('user'))->find();
            if($users['type'] != 1){
                header('Location: /user.php');
                exit();
            }
        }else{
            header('Location: /');
            exit();
        }

        if($_GET){
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }else{
                header('Location: /admin.php/yijian');
                exit();
            }
        }else{
            header('Location: /admin.php/yijian');
            exit();
        }
        $yijian = Db::table('yijian_list')->where('id',$id)->find();
        $this->assign('yijian',$yijian);
        $this->assign('title','回复意见 - 控制台');//标题
        return $this->fetch('yijian/rt');
    }
    public function rt_c()
    {
        if(Cookie::has('user')){
            $users = Db::table('user_list')->where('id',Cookie::get('user'))->find();
            if($users['type'] != 1){
                header('Location: /user.php');
                exit();
            }
        }else{
            header('Location: /');
            exit();
        }

        $return_info = $_POST['return_info'];
        $state = $_POST['state'];

        $data = ['return_info' => $return_info, 'state'=>$state,'return_user' => Cookie::get('user')];
        Db::table('yijian_list')->where('id',$_POST['id'])->data($data)->update();
        header('Location: /admin.php/yijian');
        exit();
    }

    public function del_c(){
        if(Cookie::has('user')){
            $users = Db::table('user_list')->where('id',Cookie::get('user'))->find();
            if($users['type'] != 1){
                header('Location: /user.php');
                exit();
            }
        }else{
            header('Location: /');
            exit();
        }

        if($_GET){
            if(!isset($_GET['id'])) exit("没有传入id");
            else $id = $_GET['id'];
        }else exit("没有传入id");

        Db::table('yijian_list')->where('id',$id)->delete();
        header('Location: /admin.php/yijian');
        exit();
    }
}
