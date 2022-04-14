<?php

namespace app\system\controller;

use think\Controller;
use think\facade\Cookie;
use think\Db;

class Install extends Controller
{
    public function index()
    {
        return $this->fetch('install/index');
    }
    public function ind0()
    {
        $frame_version = $_POST['frame_version'];
        $database_url = $_POST['database_url'];
        $database_port = $_POST['database_port'];
        $database_username = $_POST['database_username'];
        $database_password = $_POST['database_password'];
        $database_type = $_POST['database_type'];
        $database_b_name = $_POST['database_b_name'];
        $favicon_path = $_POST['favicon_path'];
        $site_name = $_POST['site_name'];
        $vaptcha_client_token = $_POST['vaptcha_client_token'];
        $vaptcha_server_token = $_POST['vaptcha_server_token'];
        $notice_dialog_content = $_POST['notice_dialog_content'];
        $notice_dialog_show = $_POST['notice_dialog_show'];
        $user_username = $_POST['user_username'];
        $user_password = $_POST['user_password'];
        $user_displayname = $_POST['user_displayname'];
        $user_auto = $_POST['user_auto'];

        $content = "
            <?php
                // +----------------------------------------------------------------------
                // | ThinkPHP [ WE CAN DO IT JUST THINK ]
                // +----------------------------------------------------------------------
                // | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
                // +----------------------------------------------------------------------
                // | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
                // +----------------------------------------------------------------------
                // | Author: liu21st <liu21st@gmail.com>
                // +----------------------------------------------------------------------
                
                return [
                    // 数据库类型
                    'type'            => 'mysql',
                    // 服务器地址
                    'hostname'        => '".$database_url."',
                    // 数据库名
                    'database'        => '".$database_b_name."',
                    // 用户名
                    'username'        => '".$database_username."',
                    // 密码
                    'password'        => '".$database_password."',
                    // 端口
                    'hostport'        => '".$database_port."',
                    // 连接dsn
                    'dsn'             => '',
                    // 数据库连接参数
                    'params'          => [],
                    // 数据库编码默认采用utf8
                    'charset'         => '".$database_type."',
                    // 数据库表前缀
                    'prefix'          => '',
                    // 数据库调试模式
                    'debug'           => true,
                    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
                    'deploy'          => 0,
                    // 数据库读写是否分离 主从式有效
                    'rw_separate'     => false,
                    // 读写分离后 主服务器数量
                    'master_num'      => 1,
                    // 指定从服务器序号
                    'slave_no'        => '',
                    // 自动读取主库数据
                    'read_master'     => false,
                    // 是否严格检查字段是否存在
                    'fields_strict'   => true,
                    // 数据集返回类型
                    'resultset_type'  => 'array',
                    // 自动写入时间戳字段
                    'auto_timestamp'  => false,
                    // 时间字段取出后的默认时间格式
                    'datetime_format' => 'Y-m-d H:i:s',
                    // 是否需要进行SQL性能分析
                    'sql_explain'     => false,
                    // Builder类
                    'builder'         => '',
                    // Query类
                    'query'           => '\\think\\db\\Query',
                    // 是否需要断线重连
                    'break_reconnect' => false,
                    // 断线标识字符串
                    'break_match_str' => [],
                ];";

        file_put_contents('../config/database.php',$content);

        Db::query("CREATE TABLE `furry_list` ( `id` INT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL , `describe` TEXT NOT NULL , `animal` TEXT NOT NULL , `gender` INT NOT NULL , `has_fur` INT NOT NULL , `bilibili_account` TEXT NOT NULL , `qq` TEXT NULL , `twitter` TEXT NULL , `source` TEXT NOT NULL , `auther_id` INT NOT NULL , `ruainfo` TEXT NOT NULL , `text_color` TEXT NOT NULL , `bilibili_video` TEXT NOT NULL , `weibo` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        Db::query("CREATE TABLE `user_list` ( `id` INT NOT NULL AUTO_INCREMENT , `username` TEXT NOT NULL , `displayname` TEXT NOT NULL , `passwordmd5` TEXT NOT NULL , `describe` TEXT NOT NULL , `gender` INT NOT NULL , `type` INT NOT NULL , `is_furry` INT NOT NULL , `baccount` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        Db::query("CREATE TABLE `notice_list` ( `id` INT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL , `type` INT NOT NULL , `create_time` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        Db::query("CREATE TABLE `photo_list` ( `id` INT NOT NULL AUTO_INCREMENT , `title` TEXT NOT NULL , `content` TEXT NOT NULL , `source` TEXT NOT NULL , `auther_id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        Db::query("CREATE TABLE `system_list` ( `name` TEXT NOT NULL , `value` TEXT NOT NULL ) ENGINE = InnoDB;");
        Db::query("CREATE TABLE `yijian_list` ( `id` INT NOT NULL AUTO_INCREMENT , `title` TEXT NOT NULL , `content` TEXT NOT NULL , `user_id` INT NOT NULL , `return_info` TEXT NOT NULL , `state` INT NOT NULL , `return_user` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");

        Db::table('system_list')->insert(['name'=>'frame_version','value'=>$frame_version]);
        Db::table('system_list')->insert(['name'=>'favicon_path','value'=>$favicon_path]);
        Db::table('system_list')->insert(['name'=>'site_name','value' => $site_name]);
        Db::table('system_list')->insert(['name'=>'vaptcha_client_token','value'=>$vaptcha_client_token]);
        Db::table('system_list')->insert(['name'=>'vaptcha_server_token','value'=>$vaptcha_server_token]);
        Db::table('system_list')->insert(['name'=>'notice_dialog_show','value'=>$notice_dialog_show]);
        Db::table('system_list')->insert(['name'=>'notice_dialog_content','value'=>$notice_dialog_content]);

        Db::table('user_list')->insert(['username'=>$user_username,'displayname'=>$user_displayname,'passwordmd5'=>md5($user_password),'describe'=>'','gender'=>1,'type'=>1,'is_furry'=>1,'baccount'=>'#']);

        if($user_auto){
            Cookie::set('user',1);
            Cookie::set('user_md5',md5(1));
        }
        return '100';
    }
    public function update()
    {
        return $this->fetch('install/update0');
    }
    public function update1()
    {
        $first_dialog_content = Db::table('system_list')->where('name','first_dialog_content')->find()['value'];
        $site_title = Db::table('system_list')->where('name','site_title')->find()['value'];
        $show_first_dialog = Db::table('system_list')->where('name','show_first_dialog')->find()['value'];
        $recha_html_token = Db::table('system_list')->where('name','recha_html_token')->find()['value'];
        $recha_server_token = Db::table('system_list')->where('name','recha_server_token')->find()['value'];

        Db::table('system_list')->insert(['name'=>'frame_version','value'=>'3.0.0']);
        Db::table('system_list')->insert(['name'=>'favicon_path','value'=>'/favicon.ico']);
        Db::table('system_list')->insert(['name'=>'site_name','value' => $site_title]);
        Db::table('system_list')->insert(['name'=>'vaptcha_client_token','value'=>$recha_html_token]);
        Db::table('system_list')->insert(['name'=>'vaptcha_server_token','value'=>$recha_server_token]);
        Db::table('system_list')->insert(['name'=>'notice_dialog_show','value'=>$show_first_dialog == "on"]);
        Db::table('system_list')->insert(['name'=>'notice_dialog_content','value'=>$first_dialog_content]);

        Db::table('system_list')->where('name','first_dialog_content')->delete();
        Db::table('system_list')->where('name','site_title')->delete();
        Db::table('system_list')->where('name','show_first_dialog')->delete();
        Db::table('system_list')->where('name','recha_html_token')->delete();
        Db::table('system_list')->where('name','recha_server_token')->delete();

        return '升级完成';
    }
}
