<?php
namespace app\home\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class Info extends Controller
{
    public function index()
    {
        header("Location: /");
        exit();
    }

    public function furry(){
        if(is_array($_GET)){
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }else{
                header('Location: /');
                exit('没有id');
            }
        }else {
            header('Location: /');
            exit('没有id');
        }

        $this->assign('title','资料卡');//标题
        $furry = Db::table('furry_list')->where('id',$id)->find(); //传入列表数据
        $this->assign('furry',$furry);

        return $this->fetch('info/furry');
    }
    public function photo(){
        if(is_array($_GET)){
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }else{
                header('Location: /');
                exit('没有id');
            }
        }else {
            header('Location: /');
            exit('没有id');
        }

        $this->assign('title','资料卡');//标题
        $photo= Db::table('photo_list')->where('id',$id)->find(); //传入列表数据
        $this->assign('photo',$photo);

        return $this->fetch('info/photo');
    }

    public function user(){
        if(is_array($_GET)){
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }else{
                header('Location: /');
                exit('没有id');
            }
        }else {
            header('Location: /');
            exit('没有id');
        }

        $this->assign('title','用户资料');//标题
        $user= Db::table('user_list')->where('id',$id)->find(); //传入列表数据
        $this->assign('user',$user);
        $furry_list= Db::table('furry_list')->where('auther_id',$id)->select(); //传入列表数据
        $this->assign('furry_list',$furry_list);
        $photo_list= Db::table('photo_list')->where('auther_id',$id)->select(); //传入列表数据
        $this->assign('photo_list',$photo_list);
        return $this->fetch('info/user');
    }
}
