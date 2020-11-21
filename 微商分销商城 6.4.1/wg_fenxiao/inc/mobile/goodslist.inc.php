<?php
/**
 * 商城列表页面
 */
defined('IN_IA') or exit('Access Denied');

//1.取得分类id,
$cate_id = intval($_GPC['cate_id']);
//2.查出分类名称
$category = pdo_fetch("SELECT name from ".tablename('wg_fenxiao_category')." WHERE weid=:weid AND enabled='1' AND id=:cate_id",array(':cate_id'=>$cate_id,':weid'=>$_W['uniacid']));

if(empty($cate_id) || empty($category)){
	message('获取分类失败','referer','error');
}
$title = $category['name'];
//3.查出分类下商品
$goods = pdo_fetchall("SELECT * FROM ". tablename('wg_fenxiao_goods') ." WHERE (pcate=:cate_id or ccate=:cate_id) AND status='1' AND weid=:weid ORDER BY displayorder DESC",array(':cate_id'=>$cate_id,':weid'=>$_W['uniacid']));
//折扣
$zhekou = $this->getZheKou($fenxiao_member_id)+0;
include $this->template('goodslist');
