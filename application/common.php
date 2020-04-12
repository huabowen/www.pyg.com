<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//如果没有密码加密函数，则自定义加密函数
if(!function_exists('encrypt_password'))
{
    //加密函数
    function encrypt_password($password)
    {
        $salt='dks!afd1safds53kag12423kds';
        return md5(md5(trim($password)).$salt);
    }

}