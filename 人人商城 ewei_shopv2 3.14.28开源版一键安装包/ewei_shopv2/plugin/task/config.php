<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

$isnew = false;
require_once 'core/model.php';
$isnew = new TaskModel();
$isnew = $isnew->isnew();

if ($isnew) {
	return array(
		'version' => '2.0',
		'id'      => 'task',
		'name'    => '任务中心',
		'v3'      => true,
		'menu'    => array(
			'plugincom' => 1,
			'items'     => array(
				array('title' => '任务概述', 'route' => 'task.main'),
				array('title' => '任务管理', 'route' => 'tasklist'),
				array('title' => '任务记录', 'route' => 'record'),
				array('title' => '奖励记录', 'route' => 'reward'),
				array('title' => '消息通知', 'route' => 'notice'),
				array('title' => '入口设置', 'route' => 'setting')
			)
		)
	);
}

return array(
	'version' => '1.0',
	'id'      => 'task',
	'name'    => '任务中心',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '海报任务', 'route' => ''),
			array('title' => '单次任务', 'route' => 'extension.single'),
			array('title' => '周期任务', 'route' => 'extension.repeat'),
			array(
				'title' => '系统设置',
				'items' => array(
					array('title' => '通知设置', 'route' => 'default'),
					array('title' => '入口设置', 'route' => 'default.setstart')
				)
			),
			array('title' => '<span class="text-danger update-tasknew">升级新版</span><script>$(function() {
                        $(".update-tasknew").parent("a").attr("href","javascript:;");
                        $(".update-tasknew").parent("a").click(function() {
                            tip.confirm("一旦升级到新版任务中心，旧版任务中心将被覆盖，<br>未完成的任务将不能继续，确认要升级吗？",function(){$.ajax({url:"./index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=task.version",type:"get",success:function() {location.href=""}});})});})</script>', 'route' => 'version')
		)
	)
);

?>
