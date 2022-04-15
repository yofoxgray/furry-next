<?php
namespace app\system\controller;

use think\Db;
use think\facade\Cookie;
use think\Controller;

class Ddu extends Controller
{
    public function index()
    {
        $this->assign('home_furry_ls',Cookie::get('diy_home-furry'));
        $this->assign('home_photo_ls',Cookie::get('diy_home-photo'));
        $this->assign('home_mei_ls',Cookie::get('diy_home-mei'));
        return $this->fetch('index/ddu');
    }
    public function update(){
        $home_furry = $_POST['home_furry'];
        $home_photo = $_POST['home_photo'];
        $home_mei = $_POST['home_mei'];
        $afdianx = $_POST['afdianx'];
        if($home_furry<0 || $home_photo<0) return '27';
        Cookie::set('diy_home-furry',$home_furry,9999999999);
        Cookie::set('diy_home-photo',$home_photo,9999999999);
        Cookie::set('diy_home-mei',$home_mei,9999999999);
        Cookie::set('diy_afdian',$afdianx,9999999999);
        return '200';
    }
}
