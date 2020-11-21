<?php 
/**
 * [weliam] Copyright (c) 2016/3/26
 * 商城系统设置控制器
 */
defined('IN_IA') or exit('Access Denied');

$jietiops = array('list', 'create', 'edit', 'ajax');
$jietiop_names = array('阶梯团列表','新建阶梯团', '编辑阶梯团', '选择商品');
foreach($jietiops as$key=>$value){
	permissions('do', 'ac', 'op', 'application', 'ladder', $jietiops[$key], '应用与营销', '阶梯团', $jietiop_names[$key]);
}
$shangpinops = array('display');
$shangpinop_names = array('商品统计');
foreach($shangpinops as$key=>$value){
	permissions('do', 'ac', 'op', 'data', 'goods_data', $shangpinops[$key], '数据中心', '商品统计', $shangpinop_names[$key]);
}
$gaiyaoops = array('display');
$gaiyaoop_names = array('概要统计');
foreach($gaiyaoops as$key=>$value){
	permissions('do', 'ac', 'op', 'data', 'home_data', $gaiyaoops[$key], '数据中心', '概要统计', $gaiyaoop_names[$key]);
}
$dingdanops = array('display');
$dingdanop_names = array('订单统计');
foreach($dingdanops as$key=>$value){
	permissions('do', 'ac', 'op', 'data', 'order_data', $dingdanops[$key], '数据中心', '订单统计', $dingdanop_names[$key]);
}
$tuikuanops = array('display');
$tuikuanop_names = array('退款日志');
foreach($tuikuanops as$key=>$value){
	permissions('do', 'ac', 'op', 'data', 'refund_log', $tuikuanops[$key], '数据中心', '退款日志', $tuikuanop_names[$key]);
}
$pinlunops = array('display', 'setting');
$pinlunop_names = array('评论列表','评论设置');
foreach($pinlunops as$key=>$value){
	permissions('do', 'ac', 'op', 'goods', 'comment', $pinlunops[$key], '商品', '评论管理', $pinlunop_names[$key]);
}
$goodsops = array('display', 'post', 'single_op', 'batch','setgoodsproperty','copy','taobaourl','pass','param','reply');
$goodsop_names = array('商品列表','新增/修改商品','上下架/售罄/删除/彻底删除','批量设置','设置商品属性','复制商品','导入淘宝信息','评论审核','标签属性','回复评论');
foreach($goodsops as$key=>$value){
	permissions('do', 'ac', 'op', 'goods', 'goods', $goodsops[$key], '商品', '商品管理', $goodsop_names[$key]);
}
$opops = array('option', 'spec', 'item');
$opop_names = array('规格项列表','规格项设置','增加规格项');
foreach($opops as$key=>$value){
	permissions('do', 'ac', 'op', 'goods', 'option', $opops[$key], '商品', '商品规格', $opop_names[$key]);
}
$groupops = array('all','group_detail','autogroup','output');
$groupop_names = array('团列表','团详情','手动成团','导出');
foreach($groupops as$key=>$value){
	permissions('do', 'ac', 'op', 'order', 'group', $groupops[$key], '订单', '团管理', $groupop_names[$key]);
}
$fahuoops = array('display','output','import');
$fahuoop_names = array('发货列表','导出订单','导入订单');
foreach($fahuoops as$key=>$value){
	permissions('do', 'ac', 'op', 'order', 'import', $fahuoops[$key], '订单', '批量发货', $fahuoop_names[$key]);
}
$mobanoops = array('display','post','editstatus','delete');
$mobanop_names = array('运费模板列表','编辑运费模板','更改模板状态','删除运费模板');
foreach($mobanoops as$key=>$value){
	permissions('do', 'ac', 'op', 'order', 'delivery', $mobanoops[$key], '订单', '运费模板', $mobanop_names[$key]);
}
$orderops = array('sign','delete','summary','received','detail','output','remark','address','confrimpay','confirmsend','cancelsend','refund','confirmHexiao','cancelHexiao');
$orderop_names = array('更新订单','删除订单','订单概况','订单列表','订单详情','导出','卖家备注','修改收货地址','确认付款','发货','取消发货','退款','确认核销','取消核销');
foreach($orderops as$key=>$value){
	permissions('do', 'ac', 'op', 'order', 'order', $orderops[$key], '订单', '订单管理', $orderop_names[$key]);
}
$tuikuanops = array('display','initsync');
$tuikuanop_names = array('订单列表','订单详情');
foreach($tuikuanops as$key=>$value){
	permissions('do', 'ac', 'op', 'order', 'refund', $tuikuanops[$key], '订单', '批量退款', $tuikuanop_names[$key]);
}
$xianxiaops = array('hx_entry', 'store', 'saler','selectsaler','selectstore');
$xianxiaop_names = array('关键词设置','核销门店管理','核销员管理','添加核销员','添加核销店铺');
foreach($xianxiaops as$key=>$value){
	permissions('do', 'ac', 'op', 'application', 'bdelete', $xianxiaops[$key], '应用与营销', '线下核销', $xianxiaop_names[$key]);
}

$ops = array('copyright','cache');
$op = in_array($op, $ops) ? $op : 'copyright';
wl_load()->model('setting');

if ($op == 'cache') {
	Util::deleteAllCache();
	message("删除缓存成功！",web_url('store/setting'),'success');
}

if(!TG_ID){
	if ($op == 'copyright') {
		$_W['page']['title'] = '商城信息设置 - 系统管理';
		$set = setting_get_list();
		if(empty($set)){
			$settings = $this->module['config'];
		}else{
			$settings = array();
			foreach($set as$key=>$value){
				
				$settingarray= $value['value'];
				if($settingarray){
					foreach($settingarray as $k=>$v){
					$settings[$k] = $v;
				}
				}
				
			}
		}
		
		$styles = array();
		$webstyles = array();
		$dir = TG_APP . "view/";
		$webdir = TG_WEB . "view/";
		if ($handle = opendir($dir)) {
			while (($file = readdir($handle)) !== false) {
				if ($file != ".." && $file != ".") {
					if (is_dir($dir . "/" . $file)) {
						$styles[] = $file;
					} 
				} 
			} 
			closedir($handle);
		}
		if ($handle = opendir($webdir)) {
			while (($file = readdir($handle)) !== false) {
				if ($file != ".." && $file != ".") {
					if (is_dir($webdir . "/" . $file)) {
						$webstyles[] = $file;
					} 
				} 
			} 
			closedir($handle);
		}
		
		if (checksubmit('submit')) {
			load()->func('file');
	        $r = mkdirs(IA_ROOT . '/attachment/feng_fightgroups/cert/'. $_W['uniacid']);
			$r2 = mkdirs(TG_CERT.$_W['uniacid']);
			if(!empty($_GPC['cert'])) {
	            $ret = file_put_contents(IA_ROOT . '/attachment/feng_fightgroups/cert/'.$_W['uniacid'].'/apiclient_cert.pem', trim($_GPC['cert']));
	            $ret2 = file_put_contents(TG_CERT.$_W['uniacid'].'/apiclient_cert.pem', trim($_GPC['cert']));
	            $r = $r && $ret;
	        }
	        if(!empty($_GPC['key'])) {
	            $ret = file_put_contents(IA_ROOT . '/attachment/feng_fightgroups/cert/'.$_W['uniacid'].'/apiclient_key.pem', trim($_GPC['key']));
	            $ret2 = file_put_contents(TG_CERT.$_W['uniacid'].'/apiclient_key.pem', trim($_GPC['key']));
	            $r = $r && $ret;
	        }
			if(!empty($_GPC['rootca'])) {
	            $ret = file_put_contents(IA_ROOT . '/attachment/feng_fightgroups/cert/'.$_W['uniacid'].'/rootca.pem', trim($_GPC['rootca']));
	            $ret2 = file_put_contents(TG_CERT.$_W['uniacid'].'/rootca.pem', trim($_GPC['rootca']));
	            $r = $r && $ret;
	        }
			if(!$r) {
	            message('证书保存失败, 请保证该目录可写');
	        }
			$base = array(
				'guanzhu'=>$_GPC['guanzhu'],
				'guanzhu_buy'=>$_GPC['guanzhu_buy'],
				'order_alert'=>$_GPC['order_alert'],
				'goodstip'=>$_GPC['goodstip'],
				'sharestatus' => $_GPC['sharestatus'],
				'share_type'=>$_GPC['share_type'],
				'received_time'=>$_GPC['received_time'],
				'cancle_time'=>$_GPC['cancle_time'],
				'distance'=>$_GPC['distance'],
				'orderstatus'=>$_GPC['orderstatus']
			);
			$share = array(
				'share_title' => $_GPC['share_title'],
	            'share_image' => $_GPC['share_image'],
	            'share_desc' => $_GPC['share_desc']
			);
			$refund = array(
				'mchid' => $_GPC['mchid'],
				'apikey' => $_GPC['apikey'],
				'auto_refund'=>$_GPC['auto_refund']
			);
			$message = array(
				'm_daipay'=>$_GPC['m_daipay'],
				'm_pay'=>$_GPC['m_pay'],
	            'm_tuan'=>$_GPC['m_tuan'],
	            'm_cancle'=>$_GPC['m_cancle'],
	            'm_ref'=>$_GPC['m_ref'],
	            'm_send'=>$_GPC['m_send'],
	            'm_activity'=>$_GPC['m_activity'],
	            'm_activity_result'=>$_GPC['m_activity_result'],
	            'm_activity_lottery' =>$_GPC['m_activity_lottery'],
	            'm_lack_num' =>$_GPC['m_lack_num'],
	            'order_comment_notice' =>$_GPC['order_comment_notice']
			);
			$tginfo = array(
				'biaoyu'=>$_GPC['biaoyu'],
				'sname'=>$_GPC['sname'],
	            'slogo'=>$_GPC['slogo'],
	            'guanzhu'=>$_GPC['guanzhu'],
	            'payguanzhu'=>$_GPC['payguanzhu'],
	            'qrcode'=>$_GPC['qrcode'],
	            'followed_image'=>$_GPC['followed_image'],
	            'content' => htmlspecialchars_decode($_GPC['content'])
			);
			$style = array(
				'appview'=>$_GPC['appview'],
				'webview'=>$_GPC['webview']
			);
			$paytype = array(
				'wechatstatus'=>intval($_GPC['wechatstatus']),
				'deliverystatus'=>intval($_GPC['deliverystatus']),
				'balancestatus'=>intval($_GPC['balancestatus'])
			);
			
			tgsetting_save($base, 'base');
			tgsetting_save($share, 'share');
			tgsetting_save($refund, 'refund');
			tgsetting_save($message, 'message');
			tgsetting_save($tginfo, 'tginfo');
			tgsetting_save($style, 'style');
			tgsetting_save($paytype, 'paytype');
			tgsetting_save($_GPC['customer'], 'customer');
			
			message('更新设置成功！', web_url('store/setting/copyright'));
		}
	}
	include wl_template('store/setting');
}else{
	$id = MERCHANTID;
	$_W['uniacid'] = UNIACID;
	if (!empty($id)) {
		$sql = 'SELECT * FROM '.tablename('tg_merchant').' WHERE id=:id AND uniacid=:uniacid LIMIT 1';
		$params = array(':id'=>$id, ':uniacid'=>$_W['uniacid']);
		$merchant = pdo_fetch($sql, $params);
		$saler = pdo_fetch("select * from" . tablename('tg_member') . "where uniacid={$_W['uniacid']} and openid='{$merchant['openid']}'");
		$messagesaler = pdo_fetch("select * from" . tablename('tg_member') . "where uniacid={$_W['uniacid']} and openid='{$merchant['messageopenid']}'");
	}
	if (checksubmit()) {
		$merchant = $_GPC['merchant'];
		$merchant['lng'] = $_GPC['map']['lng'];
		$merchant['lat'] = $_GPC['map']['lat'];
		pdo_update('tg_merchant',$merchant,array('id'=>$_GPC['id']));
		message("修改成功!",'','success');
	}
	include wl_template('store/merchant_home');
}

