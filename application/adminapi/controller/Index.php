<?php
namespace app\adminapi\controller;

use think\Db;

class Index
{
    public function index()
    {
        $goods=Db::table('pyg_goods')->find();
        var_dump($goods);
    }
}
