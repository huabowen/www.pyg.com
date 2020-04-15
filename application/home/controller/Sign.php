<?php

namespace app\home\controller;

use think\Controller;
use think\Request;

class Sign extends Controller
{
    /**
     * 生成签名（支付宝和商城都需要）
     *
     * @return \think\Response
     */
    public function getSign($params)
    {
        //删除签名参数
        unset($params['sign']);
        unset($params['sign_type']);
        //排序
        ksort($params);
        //拼接字符串
        $str = '';
        foreach($params as $k=>$v){
            //如果$v是空的，参数无效
            if(!$v){
                continue;
            }
            $str .= $k . '=' . $v . '&';
            /*if($k == 0){
                $str .= $k . '=' . $v;
            }else{
                $str .= '&' . $k . '=' . $v;
            }*/
        }
        $str = trim($str, '&');
        //生成签名
        $sign = encrypt_password($str);
        return $sign;
    }

    /**
     * 验证签名(商城)
     */
    public function checkSign($params)
    {
        //取出原始签名
        $sign = $params['sign'];
        //生成签名
        $new_sign = $this->getSign($params);
        //返回对比结果
        return $sign == $new_sign;
    }

    /**
     * 模拟支付宝服务端发送请求
     */
    public function alipay()
    {
        //原始返回参数
        $res = [
            'out_trade_no' => '51346515316615',
            'total_amount' => '100.00',
            'time' => '1536478956'
        ];
        //生成签名
        $sign = $this->getSign($res);
        $res['sign'] = $sign;
        $res['sign_type'] = 'encrypt_password';
        //发送请求
        $url = "http://www.pyg.com/home/sign/notify";
        $result = curl_request($url, true, $res);
        dump($result);die;
    }

    /**
     * 模拟商城异步通知地址
     */
    public function notify()
    {
        //接收参数
        $params = input();
        //$params['total_amount'] = '300.00';
        //验证签名
        $result = $this->checkSign($params);
        if($result){
            echo 'success';die;
        }else{
            echo 'fail';die;
        }
    }

}
