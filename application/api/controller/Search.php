<?php
namespace app\api\controller;

use think\Db;

class Search
{
   public function furry(){
       if($_GET && isset($_GET['key'])){
           return json(Db::table('furry_list')->where('name','like','%'.$_GET['key'])->whereOr('animal','like','%'.$_GET['key'].'%')->select());
       }else return '参数不全';
   }

   public function user(){
       if($_GET && isset($_GET['key'])){
           $data = Db::table('user_list')->where('displayname','like','%'.$_GET['key'].'%')->whereOr('username','like','%'.$_GET['key'].'%')->select();
           $dasa = "[";
           foreach ($data as $key=>$vo){
               $dasa = $dasa.'"'.$vo['displayname'].'"';
           }
           $dasa = $dasa.']';
           return $dasa;
       }else return '参数不全';
   }
}
