<?php

namespace app\home\controller;

use think\Controller;

class Notify extends Controller
{
    //ping++异步通知 (webhooks)
    public function pingpp()
    {
        try{
            //接收参数
            $params = file_get_contents("php://input");
            //获取请求头信息，用于获取签名
            $headers = \Pingpp\Util\Util::getRequestHeaders();
            // 签名在头部信息的 x-pingplusplus-signature 字段
            $signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : null;
            //获取ping++公钥用于签名
            $pub_key_path = "./pingpp_rsa_public_key.pem";
            $pub_key_contents = file_get_contents($pub_key_path);
            //验证签名
            $result = openssl_verify($params, base64_decode($signature), $pub_key_contents, 'sha256');
            if ($result === 1) {
                // 验证通过
                $event = json_decode($params, true);
                // 对异步通知做处理
                if (!isset($event['type'])) {
                    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
                    exit("fail");
                }
                switch ($event['type']) {
                    case "charge.succeeded":
                        // 开发者在此处加入对支付异步通知的处理代码
                        //修改订单状态
                        $order_sn = $event['data']['object']['order_no'];
                        $order = \app\common\model\Order::where('order_sn', $order_sn)->find();
                        if(empty($order)){
                            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
                            exit("fail");
                        }
                        $order->order_status = 1;//已付款、待发货
                        $order->pay_code = $event['data']['object']['channel'];
                        $order->pay_name = $event['data']['object']['channel'] == 'wx_pub_qr' ? '微信支付' : '支付宝';
                        $order->save();
                        \app\common\model\PayLog::create(['order_sn' => $order_sn, 'json' => $params]);
                        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
                        break;
                    case "refund.succeeded":
                        // 开发者在此处加入对退款异步通知的处理代码
                        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
                        break;
                    default:
                        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
                        break;
                }
            } elseif ($result === 0) {
                http_response_code(400);
                echo 'verification failed';
                exit;
            } else {
                http_response_code(400);
                echo 'verification error';
                exit;
            }
        }catch (\Exception $e){
            $msg = $e->getMessage();
            http_response_code(500);
            echo $msg;
            exit;
        }
    }
}
