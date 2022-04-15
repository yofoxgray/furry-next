<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class Photo extends Controller
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

        $this->assign('title','返图 - 控制台');//标题
        $lists = Db::table('photo_list')->paginate(6);
        $this->assign('lists',$lists);
        return $this->fetch('photo/index');
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

        $this->assign('title','添加返图 - 控制台');//标题
        return $this->fetch('photo/add');
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

        $title = $_POST['title'];
        $content = $_POST['content'];
        $source = $_POST['source'];

        $auther_id = Cookie::get('user');

        if($_FILES){
            mkdir("static/images/photo/" . $title);
            if(isset($_FILES['img1'])) move_uploaded_file($_FILES["img1"]["tmp_name"], "static/images/photo/" . $title . '/img1.jpg');
            if(isset($_FILES['img2'])) move_uploaded_file($_FILES["img2"]["tmp_name"], "static/images/photo/" . $title . '/img2.jpg');
            if(isset($_FILES['img3'])) move_uploaded_file($_FILES["img3"]["tmp_name"], "static/images/photo/" . $title . '/img3.jpg');
            if(isset($_FILES['img4'])) move_uploaded_file($_FILES["img4"]["tmp_name"], "static/images/photo/" . $title . '/img4.jpg');
            if(isset($_FILES['img5'])) move_uploaded_file($_FILES["img5"]["tmp_name"], "static/images/photo/" . $title . '/img5.jpg');
            if(isset($_FILES['img6'])) move_uploaded_file($_FILES["img6"]["tmp_name"], "static/images/photo/" . $title . '/img6.jpg');
            if(isset($_FILES['img7'])) move_uploaded_file($_FILES["img7"]["tmp_name"], "static/images/photo/" . $title . '/img7.jpg');
            if(isset($_FILES['img8'])) move_uploaded_file($_FILES["img8"]["tmp_name"], "static/images/photo/" . $title . '/img8.jpg');
            if(isset($_FILES['img9'])) move_uploaded_file($_FILES["img9"]["tmp_name"], "static/images/photo/" . $title . '/img9.jpg');
        }

        $data = [
            'title' => $title,
            'content' => $content,
            'auther_id' => $auther_id,
            'source' => $source
        ];
        Db::table('photo_list')->insert($data);
        header('Location: /admin.php/photo');
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

        $photoa = Db::table('photo_list')->where('id',$id)->find();

        $asc = "static/images/photo/" . $photoa['title']."/";
        if(file_exists($asc)){
            if(file_exists($asc.'img1.jpg')) unlink($asc.'img1.jpg');
            if(file_exists($asc.'img2.jpg')) unlink($asc.'img2.jpg');
            if(file_exists($asc.'img3.jpg')) unlink($asc.'img3.jpg');
            if(file_exists($asc.'img4.jpg')) unlink($asc.'img4.jpg');
            if(file_exists($asc.'img5.jpg')) unlink($asc.'img5.jpg');
            if(file_exists($asc.'img6.jpg')) unlink($asc.'img6.jpg');
            if(file_exists($asc.'img7.jpg')) unlink($asc.'img7.jpg');
            if(file_exists($asc.'img8.jpg')) unlink($asc.'img8.jpg');
            if(file_exists($asc.'img9.jpg')) unlink($asc.'img9.jpg');
            rmdir($asc);
        }

        Db::table('photo_list')->where('id',$id)->delete();
        header('Location: /admin.php/photo');
        exit();
    }
}
