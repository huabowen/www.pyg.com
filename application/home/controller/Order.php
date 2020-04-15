<?php

namespace app\home\controller;

use think\Controller;
use think\Request;

class Order extends Base
{

    /**
     * 显示结算页面
     *
     * @return \think\Response
     */
    public function create()
    {
        //登录检测
        if(!session('?user_info')){
            //没有登录 跳转到登录页面
            //设置登录成功后的跳转地址
            //session('back_url', 'home/order/create');
            session('back_url', 'home/cart/index');
            $this->redirect('home/login/login');
        }
        //获取收货地址信息
        //获取用户id
        $user_id = session('user_info.id');
        $address = \app\common\model\Address::where('user_id', $user_id)->select();
        //查询选中的购物记录以及商品信息和SKU规格商品信息
        /*$cart_data = \app\common\model\Cart::with('goods,spec_goods')->where('is_selected', 1)->where('user_id', $user_id)->select();
        $cart_data = (new \think\Collection($cart_data))->toArray();
        $total_price = 0;
        $total_number = 0;
        foreach($cart_data as &$v){
            //使用sku的价格，覆盖商品价格
            if(isset($v['price']) && $v['price']>0){
                $v['goods_price'] = $v['price'];
            }
            if(isset($v['cost_price2']) && $v['cost_price2']>0){
                $v['cost_price'] = $v['cost_price2'];
            }
            //库存处理
            if(isset($v['store_count']) && $v['store_count']>0){
                $v['goods_number'] = $v['store_count'];
            }
            if(isset($v['store_frozen']) && $v['store_frozen']>0){
                $v['frozen_number'] = $v['store_frozen'];
            }
            //累加总数量和总价格
            $total_number += $v['number'];
            $total_price += $v['number'] * $v['goods_price'];
        }
        unset($v);*/
        $res = \app\home\logic\OrderLogic::getCartDataWithGoods();
//        $res['address'] = $address;
//        return view('create', $res);
        $cart_data = $res['cart_data'];
        $total_number = $res['total_number'];
        $total_price = $res['total_price'];

        return view('create', ['address'=>$address, 'cart_data'=>$cart_data, 'total_number'=>$total_number, 'total_price' => $total_price]);
        //return view('create', compact('address', 'cart_data', 'total_number', 'total_price'));
    }

    /**
     * 提交订单
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接收参数
        $params = input();
        //参数检测
        $validate = $this->validate($params, [
            'address_id' => 'require|integer|gt:0'
        ]);
        if($validate !== true){
            $this->error($validate);
        }
        //组装订单表数据 添加一条
        //查询收货地址
        $address = \app\common\model\Address::find($params['address_id']);
        if(!$address){
            $this->error('请重新选择收货地址');
        }
        //订单编号
        $order_sn = time() . mt_rand(100000, 999999);
        $user_id = session('user_info.id');
        //查询结算的商品（选中的购物记录以及商品和SKU信息）
        $res = \app\home\logic\OrderLogic::getCartDataWithGoods();
        //$res['cart_data']  $res['total_number'] $res['total_price']
        $order_data = [
            'user_id' => $user_id,
            'order_sn' => $order_sn,
            'consignee' => $address['consignee'],
            'address' => $address['area'] . $address['address'],
            'phone' => $address['phone'],
            'goods_price' => $res['total_price'], //商品总价
            'shipping_price' => 0,//邮费
            'coupon_price' => 0,//优惠金额
            'order_amount' => $res['total_price'],//应付金额=商品总价+邮费-优惠金额
            'total_amount' => $res['total_price'],//订单总金额=商品总价+邮费
        ];
        //开启事务
        \think\Db::startTrans();
        try{
            //创建订单前 进行库存检测
            foreach($res['cart_data'] as $v){
                // $v['number']  $v['goods_number']
                if($v['number'] > $v['goods_number']){
                    //抛出异常 直接进入catch语法结构
                    throw new \Exception('订单中包含库存不足的商品');
                }
            }
            $order = \app\common\model\Order::create($order_data);
            //向订单商品表添加多条数据
            $order_goods_data = [];
            foreach($res['cart_data'] as $v){
                $row = [
                    'order_id' => $order['id'],
                    'goods_id' => $v['goods_id'],
                    'spec_goods_id' => $v['spec_goods_id'],
                    'number' => $v['number'],
                    'goods_name' => $v['goods_name'],
                    'goods_logo' => $v['goods_logo'],
                    'goods_price' => $v['goods_price'],
                    'spec_value_names' => $v['value_names'],
                ];
                $order_goods_data[] = $row;
            }
            //批量添加
            $model = new \app\common\model\OrderGoods();
            $model->saveAll($order_goods_data);
            //从购物车表删除对应数据
            //\app\common\model\Cart::where(['user_id' => $user_id, 'is_selected'=>1])->delete();
            //\app\common\model\Cart::where('user_id',$user_id)->where('is_selected',1)->delete();
            //库存预扣减（冻结库存）
            $spec_goods = [];
            $goods = [];
            foreach($res['cart_data'] as $v){
                //判断是否有SKU 有则修改SKU表，无则修改商品表
                if($v['spec_goods_id']){
                    //修改SKU表  购买数量$v['number']  库存$v['goods_number']  冻结$v['frozen_number']
                    $row = [
                        'id'=>$v['spec_goods_id'],
                        'store_count' => $v['goods_number'] - $v['number'],
                        'store_frozen' => $v['frozen_number'] + $v['number']
                    ];
                    $spec_goods[] = $row;
                }else{
                    //修改商品表  购买数量$v['number']  库存$v['goods_number']  冻结$v['frozen_number']
                    $row = [
                        'id'=>$v['goods_id'],
                        'goods_number' => $v['goods_number'] - $v['number'],
                        'frozen_number' => $v['frozen_number'] + $v['number']
                    ];
                    $goods[] = $row;
                }
            }
            //批量修改库存
            $sku_model = new \app\common\model\SpecGoods();
            $sku_model->saveAll($spec_goods);
            $goods_model = new \app\common\model\Goods();
            $goods_model->saveAll($goods);
            //提交事务
            \think\Db::commit();
            /*聚合支付 开始*/
            //二维码图片中的支付链接（本地项目自定义链接，传递订单id参数）
            //$url = url('/home/order/qrpay', ['id'=>$order->order_sn], true, true);
            //用于测试的线上项目域名 http://pyg.tbyue.com
            $url = url('/home/order/qrpay', ['id'=>$order->order_sn, 'debug'=>'true'], true, "http://pyg.tbyue.com");
            //生成支付二维码
            $qrCode = new \Endroid\QrCode\QrCode($url);
            //二维码图片保存路径（请先将对应目录结构创建出来，需要具有写权限）
            $qr_path = '/uploads/qrcode/'.uniqid(mt_rand(100000,999999), true).'.png';
            //将二维码图片信息保存到文件中
            $qrCode->writeFile('.' . $qr_path);
            $this->assign('qr_path', $qr_path);
            /*聚合支付 结束*/
            //展示选择支付方式页面 。。。
            $pay_type = config('pay_type');
            return view('pay', ['order_sn' => $order_sn, 'pay_type'=>$pay_type, 'total_price'=>$res['total_price']]);
        }catch (\Exception $e){
            //回滚事务
            \think\Db::rollback();
            //$msg = $e->getMessage();
            //$this->error($msg);
            $this->error('创建订单失败，请重试');
        }

    }

    /**
     * 去支付
     */
    public function pay()
    {
        //接收参数
        $params = input();
        //检测参数
        $validate = $this->validate($params, [
            'order_sn' => 'require',
            'pay_code|支付方式' => 'require'
        ]);
        if($validate !== true){
            $this->error($validate);
        }
        //查询订单
        $user_id = session('user_info.id');
        $order = \app\common\model\Order::where('order_sn', $params['order_sn'])->where('user_id', $user_id)->find();
        if(!$order){
            $this->error('订单不存在');
        }
        //将选择的支付方式，修改到订单表
        $pay_type = config('pay_type');
        $order->pay_code = $params['pay_code'];
        //$order->pay_name = config('pay_type.' . $params['pay_code'])['pay_name'];
        $order->pay_name = $pay_type[$params['pay_code']]['pay_name'];
        $order->save();
        //支付（根据支付方式进行处理）
        switch ($params['pay_code']){
            case 'wechat':
                //微信支付
                break;
            case 'union':
                //银联支付
                break;
            case 'alipay':
                //支付宝
            default:
                //默认 支付宝
                break;
        }
    }

    /**
     * 页面跳转 同步通知地址  get请求
     */
    public function callback()
    {
        //参考/plugins/alipay/return_url.php
        //接收参数
        $params = input();
        //参数检测（签名验证）  接收到的参数 和 支付宝传递的参数 是否发生改变
        require_once("./plugins/alipay/config.php");
        require_once './plugins/alipay/pagepay/service/AlipayTradeService.php';
        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($params);
        if($result){
            //验签成功
            $order_sn = $params['out_trade_no'];
            $order = \app\common\model\Order::where('order_sn', $order_sn)->find();
            //展示结果
            return view('paysuccess', ['pay_name' => '支付宝', 'order_amount'=>$params['total_amount'], 'order' => $order]);
        }else{
            //验签失败
            //展示结果
            return view('payfail', ['msg' => '支付失败']);
        }

    }

    /**
     * 支付宝异步通知地址，订单状态修改等逻辑 post请求
     * 这个方法本地测试 不会执行。
     */
    public function notify()
    {
        //接收参数
        $params = input();
        //记录日志
        trace('支付宝异步通知-home/order/notify:'.json_encode($params), 'debug');
        //参考 /plugins/alipay/notify_url.php
        //参数检测（签名验证）  接收到的参数 和 支付宝传递的参数 是否发生改变
        require_once("./plugins/alipay/config.php");
        require_once './plugins/alipay/pagepay/service/AlipayTradeService.php';
        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($params);
        if(!$result){
            //验证签名失败
            //记录日志
            trace('支付宝异步通知-home/order/notify:验签失败', 'error');
            echo 'fail';die;
        }
        //验签成功
        $order_sn = $params['out_trade_no'];
        $trade_status = $params['trade_status'];
        if($trade_status == 'TRADE_FINISHED'){
            //交易已经处理过
            echo 'success';die;
        }
        //交易尚未处理
        $order = \app\common\model\Order::where('order_sn', $order_sn)->find();
        if(!$order){
            //订单不存在
            //记录日志
            trace('支付宝异步通知-home/order/notify:订单不存在', 'error');
            echo 'fail';die;
        }
        if($order['order_amount'] != $params['total_amount']){
            //支付金额不对
            //记录日志
            trace('支付宝异步通知-home/order/notify:支付金额不对', 'error');
            echo 'fail';die;
        }
        //修改订单状态
        if($order['order_status'] == 0){
            $order->order_status = 1;
            $order->pay_time = time();
            $order->save();
            //记录支付信息 核心字段 支付宝订单号
            $json = json_encode($params);
            //添加数据到 pyg_pay_log表  用于后续向支付宝发起交易查询
            \app\common\model\PayLog::create(['order_sn' => $order_sn, 'json'=>$json ]);
            echo 'success';die;
        }
        echo 'success';die;
    }

    //后面的是聚合支付相关方法
    public function qrpay()
    {
        //判断支付方式
        $agent = request()->server('HTTP_USER_AGENT');
        //判断扫码支付方式
        if ( strpos($agent, 'MicroMessenger') !== false ) {
            //微信扫码
            $pay_code = 'wx_pub_qr';
        }else if (strpos($agent, 'AlipayClient') !== false) {
            //支付宝扫码
            $pay_code = 'alipay_qr';
        }else{
            //默认为支付宝扫码支付
            $pay_code = 'alipay_qr';
        }
        //基本步骤：
        //接收参数 订单编号
        //查询订单信息
        //创建支付请求 向ping++发请求
        //跳转支付页面
        //接收订单id参数
        $order_sn = input('id');
        //创建支付请求
        $this->pingpp($order_sn,$pay_code);
    }

    public function pingpp($order_sn,$pay_code)
    {
        //查询订单信息
        $order = \app\common\model\Order::where('order_sn', $order_sn)->find();
        //ping++聚合支付
        \Pingpp\Pingpp::setApiKey(config('pingpp.api_key'));// 设置 API Key
        \Pingpp\Pingpp::setPrivateKeyPath(config('pingpp.private_key_path'));// 设置私钥
        \Pingpp\Pingpp::setAppId(config('pingpp.app_id'));
        $params = [
            'order_no'  => $order['order_sn'],
            'app'       => ['id' => config('pingpp.app_id')],
            'channel'   => $pay_code,
            'amount'    => $order['order_amount'],
            'client_ip' => '127.0.0.1',
            'currency'  => 'cny',
            'subject'   => 'Your Subject',//自定义标题
            'body'      => 'Your Body',//自定义内容
            'extra'     => [],
        ];
        if($pay_code == 'wx_pub_qr'){
            $params['extra']['product_id'] = $order['id'];
        }
        //创建Charge对象
        $ch = \Pingpp\Charge::create($params);
        //跳转到对应第三方支付链接
        $this->redirect($ch->credential->$pay_code);die;
    }
    //查询订单状态
    public function status()
    {
        //接收订单编号
        $order_sn = input('order_sn');
        //查询订单状态
        /*$order_status = \app\common\model\Order::where('order_sn', $order_sn)->value('order_status');
        return json(['code' => 200, 'msg' => 'success', 'data'=>$order_status]);*/
        //通过线上测试
        $res = curl_request("http://pyg.tbyue.com/home/order/status/order_sn/{$order_sn}");
        echo $res;die;
    }

    /**
     * 支付结果页面
     */
    public function payresult()
    {
        $order_sn = input('order_sn');
        $order = \app\common\model\Order::where('order_sn', $order_sn)->find();
        if(empty($order)){
            return view('payfail', ['msg' => '订单编号错误']);
        }else{
            return view('paysuccess', ['pay_name' => $order->pay_name, 'order_amount'=>$order['order_amount'], 'order' => $order]);
        }
    }
}
