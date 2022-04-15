<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class Furry extends Controller
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

        $this->assign('title','毛毛 - 控制台');//标题
        $lists = Db::table('furry_list')->paginate(6);
        $this->assign('lists',$lists);
        return $this->fetch('furry/index');
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

        $this->assign('title','添加毛毛 - 控制台');//标题
        return $this->fetch('furry/add');
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

        $furry = Db::table('furry_list')->where('id',$id)->find();
        $this->assign('furry',$furry);
        $this->assign('title','修改 - 控制台');//标题
        return $this->fetch('furry/reset');
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
        $describe = $_POST['describe'];
        $animal = $_POST['animal'];
        $gender = $_POST['gender'];
        $has_fur = $_POST['has_fur'];
        $bilibili_account = $_POST['bilibili_account'];
        $qq = $_POST['qq'];
        $weibo = $_POST['weibo'];
        $twitter = $_POST['twitter'];
        $bilibili_video = $_POST['bilibili_video'];
        $source = $_POST['source'];
        $ruainfo = $_POST['ruainfo'];
        $text_color = $_POST['text_color'];

        $auther_id = Cookie::get('user');

        move_uploaded_file($_FILES["imgfile"]["tmp_name"], "static/images/furry/" . $name . '.jpg');

        $data = [
            'name' => $name,
            'describe' => $describe,
            'animal' => $animal,
            'gender' => $gender,
            'has_fur' => $has_fur,
            'bilibili_account' => $bilibili_account,
            'qq' => $qq,
            'weibo' => $weibo,
            'twitter' => $twitter,
            'source' => $source,
            'auther_id' => $auther_id,
            'ruainfo' => $ruainfo,
            'text_color' => $text_color,
            'bilibili_video' => $bilibili_video
        ];
        Db::table('furry_list')->insert($data);
        header('Location: /admin.php/furry');
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

        $describe = $_POST['describe'];
        $animal = $_POST['animal'];
        $gender = $_POST['gender'];
        $has_fur = $_POST['has_fur'];
        $bilibili_account = $_POST['bilibili_account'];
        $qq = $_POST['qq'];
        $weibo = $_POST['weibo'];
        $twitter = $_POST['twitter'];
        $source = $_POST['source'];
        $ruainfo = $_POST['ruainfo'];
        $text_color = $_POST['text_color'];
        $bilibili_video = $_POST['bilibili_video'];

        $auther_id = Cookie::get('user');

        $data = [
            'describe' => $describe,
            'animal' => $animal,
            'gender' => $gender,
            'has_fur' => $has_fur,
            'bilibili_account' => $bilibili_account,
            'qq' => $qq,
            'weibo' => $weibo,
            'twitter' => $twitter,
            'source' => $source,
            'auther_id' => $auther_id,
            'ruainfo' => $ruainfo,
            'text_color' => $text_color,
            'bilibili_video' => $bilibili_video
        ];
        Db::table('furry_list')->where('id',$_POST['id'])->data($data)->update();
        header('Location: /admin.php/furry');
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

        $id = $_GET['id'];

        $furrya = Db::table('furry_list')->where('id',$id)->find();
        $path = 'static/images/furry/'.$furrya['name'].'.jpg';
        if(file_exists($path)) unlink($path);

        Db::table('furry_list')->where('id',$id)->delete();
        header('Location: /admin.php/furry');
        exit();
    }
}
