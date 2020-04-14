<?php

namespace app\adminapi\controller;

use think\Controller;

class Upload extends BaseApi
{
    //单图片上传
    public function logo()
    {
        //接收参数
        $type = input('type');
        if(empty($type)){
            $this->fail('缺少参数');
        }
        //获取文件
        $file = request()->file('logo');
        if(empty($file)){
            $this->fail('必须上传文件');
        }
        //图片移动 /public/uploads/goods/  /public/uploads/category/  /public/uploads/brand/
        $info = $file->validate(['size' => 10*1024*1024, 'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH .'public' . DS . 'uploads' . DS . $type);
        if($info){
            //返回图片路径  /uploads/category/20190715/dsfdsfas.jpg
            $logo = DS . 'uploads' . DS . $type . DS . $info->getSaveName();
            $this->ok($logo);
        }else{
            //返回报错
            $msg = $file->getError();
            $this->fail($msg);
            //$this->fail('上传失败');
        }

    }
}
