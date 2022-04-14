<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class User extends Controller
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

        $this->assign('nowId',Cookie::get('user'));

        $this->assign('title','用户 - 控制台');//标题
        $lists = Db::table('user_list')->paginate(6);
        $this->assign('lists',$lists);
        return $this->fetch('user/list');
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

        $this->assign('title','添加用户 - 控制台');//标题
        return $this->fetch('user/add');
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
                header('Location: /admin.php/user');
                exit();
            }
        }else{
            header('Location: /admin.php/user');
            exit();
        }

        $nowUser = Cookie::get('user');
        $this->assign('nowUser',$nowUser);
        $user = Db::table('user_list')->where('id',$id)->find();
        $this->assign('user',$user);
        $this->assign('title','修改 - 控制台');//标题
        return $this->fetch('user/reset');
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

        $username = $_POST['username'];
        $disname = $_POST['disname'];
        $gender = $_POST['gender'];
        $describe = $_POST['describe'];
        $password = md5($_POST['password']);
        $is_furry = $_POST['is_furry'];
        $group = $_POST['type'];
        $baccount = $_POST['baccount'];

        move_uploaded_file($_FILES["imgfile"]["tmp_name"], "static/images/user/" . $username . '.jpg');

        $data = ['username' => $username, 'displayname' => $disname, 'gender' => $gender, 'describe' => $describe, 'passwordmd5' => $password, 'type' => $group, 'is_furry'=>$is_furry, 'baccount' => $baccount];
        Db::table('user_list')->insert($data);
        header('Location: /admin.php/user');
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

        $id = $_POST['id'];
        $disname = $_POST['disname'];
        $gender = $_POST['gender'];
        $describe = $_POST['describe'];
        $password = $_POST['password'];
        $is_furry = $_POST['is_furry'];
        $group = $_POST['type'];
        $baccount = $_POST['baccount'];

        if($password == '')
            $data = ['displayname' => $disname, 'gender' => $gender, 'describe' => $describe, 'type' => $group, 'is_furry'=>$is_furry, 'baccount' => $baccount];
        else
            $data = ['displayname' => $disname, 'gender' => $gender, 'describe' => $describe, 'passwordmd5' => md5($password), 'type' => $group, 'is_furry'=>$is_furry, 'baccount' => $baccount];
        Db::table('user_list')->where('id',$id)->data($data)->update();
        header('Location: /admin.php/user');
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


        $auser = Db::table('user_list')->where('id',$id)->find();
        $path = 'static/images/user/'.$auser['username'].'.jpg';

        Db::table('user_list')->where('id',$id)->delete();
        if(file_exists($path)) unlink($path);
        header('Location: /admin.php/user');
        exit();
    }
}
