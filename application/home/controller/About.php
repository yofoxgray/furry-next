<?php
namespace app\home\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class About extends Controller
{
    public function index()
    {
        $dontshowfirst = Cookie::has('dontshowfirst');
        $this->assign('dontshowfirst',$dontshowfirst);

        $search_lists = Db::table('furry_list')->select(); //传入列表数据
        $this->assign('search_list',$search_lists);
        $this->assign('title','关于');//标题
        $this->assign('login', Cookie::get('user'));
        return $this->fetch('o/about');
    }
}
