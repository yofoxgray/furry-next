<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class Notice extends Controller
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

        $this->assign('title','公告 - 控制台');//标题
        $lists = Db::table('notice_list')->paginate(6);
        $this->assign('lists',$lists);
        return $this->fetch('notice/list');
    }

    public function add()
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

        $this->assign('title','添加公告 - 控制台');//标题
        return $this->fetch('notice/add');
    }
    public function reset()
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
                header('Location: /admin.php/furry');
                exit();
            }
        }else{
            header('Location: /admin.php/furry');
            exit();
        }
        $notice = Db::table('notice_list')->where('id',$id)->find();
        $this->assign('notice',$notice);
        $this->assign('title','添加公告 - 控制台');//标题
        return $this->fetch('notice/reset');
    }

    public function add_c()
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

        $name = $_POST['name'];
        $type = $_POST['type'];

        $data = ['name' => $name, 'type'=>$type,'create_time' => time()];
        Db::table('notice_list')->insert($data);
        header('Location: /admin.php/notice');
        exit();
    }
    public function reset_c()
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

        $name = $_POST['name'];
        $type = $_POST['type'];

        $data = ['name' => $name, 'type'=>$type,'create_time' => time()];
        Db::table('notice_list')->where('id',$_POST['id'])->data($data)->update();
        header('Location: /admin.php/notice');
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

        Db::table('notice_list')->where('id',$id)->delete();
        header('Location: /admin.php/notice');
        exit();
    }
}
