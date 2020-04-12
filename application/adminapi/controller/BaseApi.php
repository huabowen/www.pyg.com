<?php

namespace app\adminapi\controller;

use think\Controller;

class BaseApi extends Controller
{
    //无需登录
    protected $no_login = ['login/login', 'login/captcha'];
    //初始化方法
    public function _initialize()
    {
        parent::_initialize();
        //允许的源域名
        header("Access-Control-Allow-Origin: *");
        //允许的请求头信息
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        //允许的请求类型
        header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');
        //登录检测，判断是否登录，未登录则部分功能受限
        try{
            $path = strtolower($this->request->controller()) . '/' . $this->request->action();
            if(!in_array($path, $this->no_login)){
                $user_id = \tools\jwt\Token::getUserId();
                //登录验证
                if(empty($user_id)){
                    $this->fail('未登录或Token无效', 403);
                }
                //将获取的用户id 设置到请求信息中
                $this->request->get(['user_id' => $user_id]);
                $this->request->post(['user_id' => $user_id]);
            }
        }catch(\Exception $e){
            $this->fail('服务异常，请检查token令牌', 403);
        }
    }
    /**
     * 通用响应
     * @param int $code 错误码
     * @param string $msg 错误描述
     * @param array $data 返回数据
     */
    public function response($code=200, $msg='success', $data=[])
    {
        $res = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        //以下两行二选一
        //echo json_encode($res, JSON_UNESCAPED_UNICODE);die;
        json($res)->send();die;
    }
    /**
     * 失败时响应
     * @param string $msg 错误描述
     * @param int $code 错误码
     */
    public function fail($msg='fail',$code=500)
    {
        return $this->response($code, $msg);
    }

    /**
     * 成功时响应
     * @param array $data 返回数据
     * @param int $code 错误码
     * @param string $msg 错误描述
     */
    public function ok($data=[], $code=200, $msg='success')
    {
        return $this->response($code, $msg, $data);
    }

}
