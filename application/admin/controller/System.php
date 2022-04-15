<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class System extends Controller
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

        $notice_dialog_show = Db::table('system_list')->where('name','notice_dialog_show')->value('value');
        $this->assign('notice_dialog_show',$notice_dialog_show);
        $notice_dialog_content = Db::table('system_list')->where('name','notice_dialog_content')->value('value');
        $this->assign('notice_dialog_content',$notice_dialog_content);
        $vaptcha_client_token = Db::table('system_list')->where('name','vaptcha_client_token')->value('value');
        $this->assign('vaptcha_client_token',$vaptcha_client_token);
        $vaptcha_server_token = Db::table('system_list')->where('name','vaptcha_server_token')->value('value');
        $this->assign('vaptcha_server_token',$vaptcha_server_token);
        $site_name = Db::table('system_list')->where('name','site_name')->value('value');
        $this->assign('site_name',$site_name);
        $favicon_path = Db::table('system_list')->where('name','favicon_path')->value('value');
        $this->assign('favicon_path',$favicon_path);

        $this->assign('title','设置 - 控制台');//标题
        return $this->fetch('system/index');
    }

    public function update_c()
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

        $notice_dialog_show = $_POST['notice_dialog_show'];
        $notice_dialog_content = $_POST['notice_dialog_content'];
        $vaptcha_client_token = $_POST['vaptcha_client_token'];
        $vaptcha_server_token = $_POST['vaptcha_server_token'];
        $site_name = $_POST['site_name'];
        $favicon_path = $_POST['favicon_path'];

        Db::table('system_list')->where('name','notice_dialog_show')->data(['value'=>$notice_dialog_show])->update();
        Db::table('system_list')->where('name','notice_dialog_content')->data(['value'=>$notice_dialog_content])->update();
        Db::table('system_list')->where('name','vaptcha_client_token')->data(['value'=>$vaptcha_client_token])->update();
        Db::table('system_list')->where('name','vaptcha_server_token')->data(['value'=>$vaptcha_server_token])->update();
        Db::table('system_list')->where('name','site_name')->data(['value'=>$site_name])->update();
        Db::table('system_list')->where('name','favicon_path')->data(['value'=>$favicon_path])->update();

        return "ok";
    }
}
