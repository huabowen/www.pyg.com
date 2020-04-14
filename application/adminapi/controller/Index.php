<?php
namespace app\adminapi\controller;

class Index extends BaseApi
{
    public function index()
    {
        //测试 关联模型
/*        $info = \app\common\model\Admin::find(1);
        dump($info);
        dump($info->profile->idnum);
        $this->ok($info);
        $info = \app\common\model\Admin::with('profile')->find(1);
        $this->ok($info);
        $data = \app\common\model\Admin::with('profile')->select();
        $this->ok($data);
*/
        //以档案为主：档案到管理员
        /*$info = \app\common\model\Profile::find(1);
        dump($info->admin->username);
        $info = \app\common\model\Profile::with('admin')->find(1);
        $this->ok($info);
        $data = \app\common\model\Profile::with('admin')->select();
        $this->ok($data);*/

        //一对多关联
        //以分类表为主
        /*$info = \app\common\model\Category::find(72);
        $info = \app\common\model\Category::with('brands')->find(72);
        $this->ok($info);

        $data = \app\common\model\Category::with('brands')->select();
        $this->ok($data);*/

        //以品牌表为主
//        $info = \app\common\model\Brand::with('category')->find(1);
//        $this->ok($info);

        $data = \app\common\model\Brand::with('category')->select();
        $this->ok($data);
        die;
        echo encrypt_password('123456');die;
        //测试Token工具类
        //生成token
        $token = \tools\jwt\Token::getToken(200);
        dump($token);
        //解析token 得到用户id
        $user_id = \tools\jwt\Token::getUserId($token);
        dump($user_id);die;

        //测试响应方法
        //$this->response();
        //$this->response(200, 'success', ['id' => 100, 'name' => 'zhangsan']);
        //$this->ok(['id' => 100, 'name' => 'zhangsan']);
        //$this->response(400, '参数错误');
        //$this->fail('参数错误');
        //$this->fail('参数错误', 401);
        //测试数据库配置
//        $goods = \think\Db::table('pyg_goods')->find();
//        dump($goods);die;
        //return 'hello, 这里是adminapi的index的index方法';
    }
}
