<?php

namespace app\test\controller;

use think\Controller;
use think\Request;

class Goods extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
//        $list = \app\test\model\Goods::select();
        $list = \app\test\model\Goods::order('id desc')->paginate(10);
        return view('goods_list', ['list' => $list]);
    }

    public function ajaxindex()
    {
        $list = \app\test\model\Goods::select();
//        $list = \app\test\model\Goods::order('id desc')->paginate(10);
        $res = [
            'code' => 200,
            'msg' => 'success',
            'data' => $list
        ];
        echo json_encode($res);die;
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('goods_add');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $params = input();
        //参数检测 略
        //添加数据
        \app\test\model\Goods::create($params, true);
        $this->success('操作成功', 'index');
    }

    public function ajaxsave(Request $request)
    {
        $params = input();
        //参数检测 略
        //添加数据
        \app\test\model\Goods::create($params, true);
        $res = [
            'code' => 200,
            'msg' => 'success'
        ];
        echo json_encode($res);die;
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $info = \app\test\model\Goods::find($id);
        return view('goods_detail', ['info' => $info]);
    }
    public function ajaxread($id)
    {
        $info = \app\test\model\Goods::find($id);
        $res = [
            'code' => 200,
            'msg' => 'success',
            'data' => $info
        ];
        echo json_encode($res);die;
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $info = \app\test\model\Goods::find($id);
        return view('goods_edit', ['info' => $info]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //接收数据
        $params = input();
        //修改数据
        \app\test\model\Goods::update($params, ['id' => $id], true);
        //页面跳转
        $this->success('操作成功', 'index');
    }
    public function ajaxupdate(Request $request, $id)
    {
        //接收数据
        $params = input();
        //修改数据
        \app\test\model\Goods::update($params, ['id' => $id], true);
        //页面跳转
        $res = [
            'code' => 200,
            'msg' => 'success'
        ];
        echo json_encode($res);die;
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        \app\test\model\Goods::destroy($id);
        $this->success('操作成功', 'index');
    }
    public function ajaxdelete($id)
    {
        \app\test\model\Goods::destroy($id);
        $res = [
            'code' => 200,
            'msg' => 'success'
        ];
        echo json_encode($res);die;
    }
}
