<?php
namespace app\adminapi\controller;

use think\Db;

class Index extends BaseApi
{
    public function index()
    {
        echo encrypt_password('123456');die;
    }
}
