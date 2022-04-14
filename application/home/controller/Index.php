<?php

namespace app\home\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class Index extends Controller
{
    public function index()
    {
        if(!Cookie::has('diy_home-furry')) Cookie::set('diy_home-furry',7,9999999999);
        if(!Cookie::has('diy_home-photo')) Cookie::set('diy_home-photo',3,9999999999);
        if(!Cookie::has('diy_home-mei')) Cookie::set('diy_home-mei',2,9999999999);
        if(!Cookie::has('first-dialog')) Cookie::set('first-dialog','true',9999999999);
        if(!Cookie::has('diy_afdian')) Cookie::set('diy_afdian','true',9999999999);

        $furry_lists = Db::query('select * from `furry_list` limit 0,'.Cookie::get('diy_home-furry'));
        $this->assign('furry_list', $furry_lists);
        $photo_lists = Db::query('select * from `photo_list` limit 0,'.Cookie::get('diy_home-photo'));
        $this->assign('photo_list', $photo_lists);
        $notice_list = Db::table('notice_list')->select(); //传入公告数据
        $this->assign('notice_list', $notice_list);
        if (Cookie::get('diy_home-mei')>0) $mei_lists = Db::table('furry_list')->orderRand()->limit(0,Cookie::get('diy_home-mei'))->select();
        else $mei_lists = NULL;
        $this->assign('mei_list', $mei_lists);

        $this->assign('ag_title','首页');
        return $this->fetch('list/home');
    }
    public function search()
    {
        if ($_GET) {
            if (isset($_GET['key'])) {
                $key = $_GET['key'];
            } else {
                header('Location: /');
                exit();
            }
        } else {
            header('Location: /');
            exit();
        }

        $furry_lists = Db::table('furry_list')->where('name', 'like', '%' . $key . '%')->whereOr('animal', 'like', '%' . $key . '%')->select(); //传入列表数据
        $this->assign('furry_list', $furry_lists);
        $photo_lists = Db::table('photo_list')->where('title', 'like', '%' . $key . '%')->whereOr('content', 'like', '%' . $key . '%')->select(); //传入列表数据
        $this->assign('photo_list', $photo_lists);
        $notice_list = Db::table('notice_list')->select(); //传入公告数据
        $this->assign('notice_list', $notice_list);
        return $this->fetch('list/search');
    }
}
