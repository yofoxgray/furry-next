<?php
namespace app\api\controller;

use think\Db;

class Lists
{
   public function furry(){
       return json(Db::table('furry_list')->select());
   }

   public function user(){
       return '{"count":'.count(Db::table('user_list')->select()).'}';
   }
}
