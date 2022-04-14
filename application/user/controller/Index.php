<?php
namespace app\user\controller;

use think\Db;
use think\facade\Cookie;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        if(Cookie::has('user')){
            $users = Db::table('user_list')->where('id',Cookie::get('user'))->find();
            if($users['type'] == 1){
                header("Location: /admin.php");
                exit();
            }
        }else{
            header("Location: /user.php/login");
            exit();
        }

        $this->assign('login', Cookie::get('user'));
        $this->assign('title','个人设置 - 控制台');//标题
        $this->assign('user',Db::table('user_list')->where('id',Cookie::get('user'))->find());
        return $this->fetch('index/index');
    }
    public function avpt()
    {
        if(Cookie::has('user')){
            $users = Db::table('user_list')->where('id',Cookie::get('user'))->find();
            if($users['type'] == 1){
                header("Location: /admin.php");
                exit();
            }
        }
        $this->assign('login', Cookie::get('user'));
        $this->assign('title','修改头像 - 控制台');//标题
        $this->assign('user',Db::table('user_list')->where('id',Cookie::get('user'))->find());
        return $this->fetch('index/avpt');
    }
    public function reset_cp()
    {
        if(Cookie::has('user')){
            if($_POST['id'] != Cookie::get('user')){
                header('Location: /');
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
        $baccount = $_POST['baccount'];

        if($password == '')
            $data = ['displayname' => $disname, 'gender' => $gender, 'describe' => $describe, 'is_furry'=>$is_furry, 'baccount' => $baccount];
        else
            $data = ['displayname' => $disname, 'gender' => $gender, 'describe' => $describe, 'passwordmd5' => md5($password), 'is_furry'=>$is_furry, 'baccount' => $baccount];
        Db::table('user_list')->where('id',$id)->data($data)->update();
        header('Location: /user.php');
        exit();
    }
    public function avpt_cp()
    {
        if(Cookie::has('user')){
            if($_POST['id'] != Cookie::get('user')){
                header('Location: /');
                exit();
            }
        }else{
            header('Location: /');
            exit();
        }

        $id = $_POST['id'];

        $ipd = Db::table('user_list')->where('id',$id)->value('username');

        $ends = substr($_FILES['img']['name'],strpos($_FILES['img']['name'], '.'));
        if($ends != '.jpg' && $ends != '.png') return '请上传图片文件';
        move_uploaded_file($_FILES["img"]["tmp_name"], "static/images/user/" . $ipd . '.jpg');

        header('Location: /user.php/index/avpt');
        exit();
    }
}
