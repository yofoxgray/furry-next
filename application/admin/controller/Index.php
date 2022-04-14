<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class Index extends Controller
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

        $furry_count = count( Db::table('furry_list')->select() );
        $this->assign('furry_count',$furry_count);

        $user_count = count( Db::table('user_list')->select() );
        $this->assign('user_count',$user_count);

        $notice_count = count( Db::table('notice_list')->select() );
        $this->assign('notice_count',$notice_count);

        $this->assign('title','控制台');//标题
        return $this->fetch('index');

    }
}
