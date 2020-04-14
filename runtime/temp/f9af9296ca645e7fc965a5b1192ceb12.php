<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:69:"E:\phpStudy\WWW\pyg\public/../application/admin\view\order\order.html";i:1559715237;s:61:"E:\phpStudy\WWW\pyg\application\admin\view\layout\layout.html";i:1557468795;s:60:"E:\phpStudy\WWW\pyg\application\admin\view\layout\_meta.html";i:1557469360;s:62:"E:\phpStudy\WWW\pyg\application\admin\view\layout\_footer.html";i:1557469363;s:62:"E:\phpStudy\WWW\pyg\application\admin\view\layout\_header.html";i:1559719521;s:60:"E:\phpStudy\WWW\pyg\application\admin\view\layout\_menu.html";i:1559037674;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="favicon.ico" >
<LINK rel="Shortcut Icon" href="favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/static/admin/lib/html5.js"></script>
<script type="text/javascript" src="/static/admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />

<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/static/admin/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script><![endif]-->
<script type="text/javascript" src="/static/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/lib/layer/2.4/layer.js"></script>
 
<script type="text/javascript" src="/static/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/static/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/static/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/static/admin/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/static/admin/static/h-ui.admin/js/H-ui.admin.page.js"></script>

<body>
<header class="navbar-wrapper">
	<div class="navbar navbar-fixed-top">
		<div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/">品优购后台管理系统</a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/">品优购后台管理系统</a> <span class="logo navbar-slogan f-l mr-10 hidden-xs">v3.0</span> <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
			<nav id="top_nav" class="nav navbar-nav">
				<ul class="cl">
					<?php foreach($nav as $k => $nav_one): ?>
					<li style="<?php if(($nav_one['id'] == $current_auth_ids[1])): ?>background-color:gray;<?php endif; ?>"> <a href="javascript:;" data-id="<?php echo $nav_one['id']; ?>"><?php echo $nav_one['auth_name']; ?></a> </li>
					<?php endforeach; ?>
				</ul>
			</nav>
			<nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
				<ul class="cl">
					<li>超级管理员</li>
					<li class="dropDown dropDown_hover"> <a href="javascript:;" class="dropDown_A"><?php echo \think\Session::get('manager_info.username'); ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
						<ul class="dropDown-menu menu radius box-shadow">
							<li><a href="javascript:;">个人信息</a></li>
							<li><a href="<?php echo url('login/logout'); ?>">切换账户</a></li>
							<li><a href="<?php echo url('login/logout'); ?>">退出</a></li>
						</ul>
					</li>
					<li id="Hui-msg"> <a href="javascript:;" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>
					<li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
						<ul class="dropDown-menu menu radius box-shadow">
							<li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
							<li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
							<li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
							<li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
							<li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
							<li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</header>
<aside class="Hui-aside">
	<div class="menu_dropdown bk_2">
		<?php foreach($nav as $k => $nav_one): foreach($nav_one['son'] as $kk=>$nav_two): ?>
		<dl id="menu<?php echo $kk; ?>" class="sec_nav" data-pid="<?php echo $nav_one['id']; ?>" style="<?php if(($nav_one['id'] == $current_auth_ids[1])): ?>display:block;<?php else: ?>display:none;<?php endif; ?>">
			<dt class="<?php if(($nav_two['id'] == $current_auth_ids[2])): ?>selected<?php endif; ?>"><i class="Hui-iconfont">&#xe616;</i> <?php echo $nav_two['auth_name']; ?><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd style="<?php if(($nav_two['id'] == $current_auth_ids[2])): ?>display:block;<?php endif; ?>">
				<ul>
					<?php foreach($nav_two['son'] as $nav_three): ?>
					<li data-id="<?php echo $nav_three['id']; ?>" class="<?php if(($nav_three['id'] == $current_auth_ids[3])): ?>current<?php endif; ?>">
						<a href="<?php if(($nav_three['auth_c']&&$nav_three['auth_a'])): ?><?php echo url($nav_three['auth_c'] . '/' . $nav_three['auth_a']); else: ?>javascript:;<?php endif; ?>" title=""><?php echo $nav_three['auth_name']; ?></a>
					</li>
					<?php endforeach; ?>
				</ul>
			</dd>
		</dl>
		<?php endforeach; endforeach; ?>
	</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<script>
	$(function(){
		$('#top_nav').on('click', 'a', function(){
			var data_id = $(this).attr('data-id');
			$(this).parent().css('backgroundColor', 'gray');
			$(this).parent().siblings().css('backgroundColor', '');
			$('.sec_nav').filter('[data-pid=' + data_id + ']').show();
			$('.sec_nav').not('[data-pid=' + data_id + ']').hide();
		});
	});
</script>

﻿
	<title>订单列表 - 订单列表</title>
	<style type="text/css">
		.pagination li{list-style:none;float:left;margin-left:10px;
			padding:0 10px;
			background-color:#5a98de;
			border:1px solid #ccc;
			height:26px;
			line-height:26px;
			cursor:pointer;
			color:#fff;
		}
		.pagination li a{color:white;padding: 0;line-height: inherit;border: none;}
		.pagination li a:hover{background-color: #5a98de;}
		.pagination li.active{background-color:white;color:gray;}
		.pagination li.disabled{background-color:white;color:gray;}
	</style>
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
		<span class="c-gray en">&gt;</span>
		订单管理
		<span class="c-gray en">&gt;</span>
		订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a> </nav>
	<div class="Hui-article">
		<article class="cl pd-20">
			<div class="text-c">
				<form class="Huiform" method="get" action="<?php echo url('index'); ?>" target="_self">
					日期范围：
					<input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" class="input-text Wdate" style="width:120px;" name="datemin" value="<?php echo \think\Request::instance()->param('datemin'); ?>">
					-
					<input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" id="datemax" class="input-text Wdate" style="width:120px;" name="datemax" value="<?php echo \think\Request::instance()->param('datemax'); ?>">
					<input type="text" class="input-text" style="width:250px" placeholder="输入订单名称" id="" name="keyword" value="<?php echo \think\Request::instance()->param('keyword'); ?>">
					<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜</button>
				</form>
			</div>
			<div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l"> <a href="javascript:;" class="btn btn-danger radius" id="patch_delete" data-url="<?php echo url('delete'); ?>"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> </span>
				<span class="r">共有数据：<strong><?php echo $list->total(); ?></strong> 条</span>
			</div>
			<table class="table table-border table-bordered table-bg table-sort">
				<thead>
					<tr>
						<th scope="col" colspan="11">订单列表</th>
					</tr>
					<tr class="text-c">
						<th width="25"><input type="checkbox" name="" value=""></th>
						<th width="40">ID</th>
						<th width="50">用户id</th>
						<th width="50">用户昵称</th>
						<th width="150">订单编号</th>
						<th width="90">应付款金额</th>
						<th>订单状态</th>
						<th width="130">物流信息</th>
						<th width="100">支付信息</th>
						<th width="100">下单时间</th>
						<th width="100">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($list as $v): ?>
					<tr class="text-c">
						<td><input type="checkbox" value="<?php echo $v['id']; ?>" name=""></td>
						<td><?php echo $v['id']; ?></td>
						<td><?php echo $v['user_id']; ?></td>
						<td><?php echo $v['user']['nickname']; ?></td>
						<td><a href="<?php echo url('read', ['id'=>$v['id']]); ?>"><?php echo $v['order_sn']; ?></a></td>
						<td><?php echo $v['order_amount']; ?></td>
						<td><?php echo $v['order_status']; ?></td>
						<td><?php echo $v['shipping_code']; ?>/<?php echo $v['shipping_name']; ?>/<?php echo $v['shipping_sn']; ?></td>
						<td><?php echo $v['pay_code']; ?>/<?php echo $v['pay_name']; ?></td>
						<td><?php echo $v['create_time']; ?></td>
						<td class="td-manage">
							<a title="编辑" data-url="<?php echo url('edit', ['id'=>$v['id']]); ?>" href="javascript:;" class="ml-5 edit" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
							<a title="删除" data-url="<?php echo url('delete',['id'=>$v['id']]); ?>" href="javascript:;" class="ml-5 delete" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="pd-20"><?php echo $list->render(); ?></div>
		</article>
	</div>
</section>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/static/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/static/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/static/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript" src="/static/admin/logic/curd.js"></script>
<script type="text/javascript">
	$(function(){
		/*$('.table-sort').dataTable({
			"aaSorting": [[ 1, "desc" ]],//默认第几个排序
			"bStateSave": true,//状态保存
			"aoColumnDefs": [
				{"orderable":false,"aTargets":[0,7]}// 制定列不参与排序
			]
		});*/
	});
	/*
	 参数解释：
	 title	标题
	 url		请求的url
	 id		需要操作的数据id
	 w		弹出层宽度（缺省调默认值）
	 h		弹出层高度（缺省调默认值）
	 */
	/*订单-停用*/
	function admin_stop(obj,id){
		layer.confirm('确认要停用吗？',function(index){
			//此处请求后台程序，下方是成功后的前台处理……

			$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
			$(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
			$(obj).remove();
			layer.msg('已停用!',{icon: 5,time:1000});
		});
	}

	/*订单-启用*/
	function admin_start(obj,id){
		layer.confirm('确认要启用吗？',function(index){
			//此处请求后台程序，下方是成功后的前台处理……

			$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
			$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
			$(obj).remove();
			layer.msg('已启用!', {icon: 6,time:1000});
		});
	}
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>

</body>
</html>