<?php
namespace app\home\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class Lists extends Controller
{
    public function furry()
    {
        $furry_lists = Db::table('furry_list')->paginate(20); //传入列表数据
        $this->assign('furry_list', $furry_lists);
        $this->assign('title', '毛毛列表');//标题

        return $this->fetch('list/furry');
    }
    public function photo()
    {
        $photo_lists = Db::table('photo_list')->paginate(20); //传入列表数据
        $this->assign('photo_list', $photo_lists);
        $this->assign('title', '返图列表');//标题

        return $this->fetch('list/photo');
    }
}
