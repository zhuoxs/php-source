<?php
/**
 * 商品展示页面
 */
defined('IN_IA') or exit('Access Denied');

//1.取得商品id,
$goods_id = intval($_GPC['goods_id']);
//2.查出商品
$goods = pdo_fetch("SELECT * FROM " .tablename('wg_fenxiao_goods'). " WHERE status='1' AND weid=:weid AND id=:goods_id",array(':goods_id'=>$goods_id,':weid'=>$_W['uniacid']));
if(empty($goods)){
	message('获取商品失败,或者商品已经下架');
}
//$goods['goumaiyaoqiu'] = explode(',', $goods['goumaiyaoqiu']);
//title
$title = $goods['goodsname'];

//折扣
$zhekou = $this->getZheKou($fenxiao_member_id)+0;
//会员信息
$my_member_info = $this->getMyInfo($fenxiao_member_id);

$LevelName = $this->getLevelName($goods['goumaiyaoqiu'], $_W['uniacid']);	
if($goods['goumaiyaoqiu'] > 0 && $my_member_info['agentlevel'] != $goods['goumaiyaoqiu']){
		message('对不起,此产品只有'.$LevelName.'才可以购买!');	
}

include $this->template('goods');