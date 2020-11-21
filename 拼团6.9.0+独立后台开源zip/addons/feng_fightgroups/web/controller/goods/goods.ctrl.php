<?php
defined('IN_IA') or exit('Access Denied');

load()->func('tpl');
$ops = array('display', 'post', 'single_op', 'batch','setgoodsproperty','copy','selectgift','taobaourl','asdasd','tag','pass','param','reply','searchcoupons','getcoupon');
$op = in_array($op, $ops) ? $op : 'display';
if($_SESSION['role_id'])$merchant = model_merchant::getSingleMerchant($_SESSION['role_id'], 'id,name');
$category = model_category::getNumCategory();
$merchantsData = model_merchant::getNumMerchant(0,0,0,$_SESSION['role_id']);
$merchants = $merchantsData[0];
if ($op == 'display') {
	//商品排序 Start
	if(checksubmit()){
		$display=$_GPC['display'];
		$ids = $_GPC['ids'];
		for($i=0;$i<count($ids);$i++){
			pdo_update("tg_goods",array('displayorder'=>$display[$i]),array('id'=>$ids[$i]));
			Util::deleteCache('goods', $ids[$i]);//删除缓存
		}
		message('商品排序保存成功', web_url('goods/goods/display',array('status'=>1)), 'success');
	}
	//商品排序 End
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$where =array();
	if(TG_MERCHANTID)$where['merchantid'] = $_SESSION['role_id'];
	if (!empty($_GPC['status']))$where['isshow'] = $_GPC['status'];
	$where['#g_type#'] = $_GPC['g_type']?"(".$_GPC['g_type'].")":'(1,4)';
	$_GPC['g_type']==3? $_GPC['lotteryStatus'] = $_GPC['lotteryStatus']?$_GPC['lotteryStatus']:1:'';
	if($_GPC['g_type']==2) $where['#isshow#'] = '(1,2,3)';
	if($_GPC['g_type']==3) $where['#isshow#'] = '(1,2,3)';
	if($_GPC['status']==4) $where['#g_type#'] = '(1,2,3,4)';
	if($_GPC['is_hexiao']==1){
		$where['&prize'] = 1;
		$_GPC['lotteryStatus']=0;
	} 
	if(!empty($_GPC['lotteryStatus'])){
		$lottery = pdo_fetchall("select fk_goodsid from".tablename('tg_lottery')."where uniacid={$_W['uniacid']} and status={$_GPC['lotteryStatus']}");
		if($lottery){
	    	$ids = "(0";
	    	foreach($lottery as $key=>$value){
	    		$ids .= $value['fk_goodsid']?",{$value['fk_goodsid']}":'';
	    	}
			$ids .=")";
	    }
		$where['#id#'] = $ids?$ids:'(0)';
	}
	if (!empty($_GPC['category']['parentid']))$where['category_parentid'] = $_GPC['category']['parentid'];
	if (!empty($_GPC['category']['childid']))$where['category_childid'] = $_GPC['category']['childid'];
	if (!empty($_GPC['keyword'])) {
		if(!empty($_GPC['keywordtype'])){
			switch($_GPC['keywordtype']){
				case 1: $where['@gname@'] = $_GPC['keyword'];break;
				case 2: $where['@id@'] = $_GPC['keyword'];break;
				case 3: $m = pdo_fetch("select id from".tablename('tg_merchant')."where name like '%{$_GPC['keyword']}%' and uniacid={$_W['uniacid']}");if($m['id'])$where['@merchantid@'] = $m['id'];break;
				default:break;
			}
		}
	}
//	wl_debug($where);
	$goodsData = model_goods::getNumGoods('*', $where, 'displayorder DESC', $pindex, $psize, TRUE);
	$goodses = $goodsData[0];
	$pager = $goodsData[1];
	include wl_template('goods/goods_display');
}

if ($op == 'post') {
	$id = intval($_GPC['id']);
//	wl_debug($_W['attachurl_remote']);
	$goods = model_goods::getSingleGoods($id, '*', array('id'=>$id));
	if(empty($goods['hexiaolimittime'])) $goods['hexiaolimittime'] = 1;
	$goods['params'][0]['tagcontent'] = unserialize($goods['params'][0]['tagcontent']);
	$role_id = '';
	if(TG_MERCHANTID)$role_id = " and merchantid={$_SESSION['role_id']}";
	$dispatch_list = pdo_fetchall("select id,name from".tablename('tg_delivery_template')."where uniacid={$_W['uniacid']} and status=2 {$role_id}");//运费模板	
	if (!empty($goods))$store = model_goods::getSingleGoodsStore($id);//店铺
	if (!empty($goods))$goodsOption = model_goods::getSingleGoodsOption($id);//商品规格
	$marketing = model_goods::getMarketing($id);
	
	if($goods['givecouponid']){
		$goods['givecoupon'] = pdo_get('tg_coupon_template',array('id' => $goods['givecouponid']));
	}
	if($goods['getcouponid']){
		$getcoupon = pdo_get('tg_coupon_template',array('id' => $goods['getcouponid']),array('id','name'));
	}
	if (checksubmit()) {
		$data = $_GPC['goods'];
		if($data['hexiaolimittimetype'] == 1) $data['hexiaolimittime'] = strtotime($_GPC['hexiaolimittime1']);
		if($data['hexiaolimittimetype'] == 2) $data['hexiaolimittime'] = $_GPC['hexiaolimittime2'];
		$data['hasoption']=$_GPC['hasoption'];
		$data['allsalenum'] = $data['salenum'] + $data['falsenum'];
		if($_GPC['storeids']){
			$data['hexiao_id']=serialize($_GPC['storeids']);//核销ID
		}else {
			$data['hexiao_id']='';//核销ID
		}
		$data['atlas'] = serialize($_GPC['img']);//图集
		$data['category_parentid'] = $_GPC['category']['parentid'];//父分类ID
		$data['category_childid'] = $_GPC['category']['childid'];//子分类ID
		$data['gdetaile'] = htmlspecialchars_decode($data['gdetaile']);//详情
		$data['gdesc'] = htmlspecialchars_decode($data['gdesc']);//详情
		$data['endtime'] = $_GPC['endtime'];
		if($data['hasoption'] == 1)$data['group_level_status'] = 1;
		
		if($data['g_type']==3) {
			$data['one_limit'] = 0;
			$data['op_one_limit'] = 0;
			$data['many_limit'] = 0;
//			$data['hasoption'] = 0;
			$data['group_level_status'] = 1;
		}
		if(empty($data['isshow'])){
			$data['isshow'] = 2;
		}

		//预售商品
		if(!empty($_GPC['ispresell'])){
			$data['ispresell'] = intval($_GPC['ispresell']);
			$data['preselltimestart'] = strtotime($_GPC['preselltime']['start']);
			$data['preselltimeend'] = strtotime($_GPC['preselltime']['end']);
			$data['presellsendtype'] = intval($_GPC['presellsendtype']);
			$data['presellsendstatrttime'] = strtotime($_GPC['presellsendstatrttime']);
			$data['presellsendtime'] = intval($_GPC['presellsendtime']);
		}else{
			$data['ispresell'] = 0;
		}
		if (empty($id)) {
			$data['uniacid'] = $_W['uniacid'];
			$data['createtime'] = TIMESTAMP;
			$ret = pdo_insert('tg_goods', $data);//插入数据
			if ($ret) $id = pdo_insertid();
			$oplogdata = serialize($data);
			oplog('admin', "添加商品", web_url('goods/goods/post'), $oplogdata);//操作记录
		} else {
			pdo_update('tg_goods', $data, array('id' => $goods['id']));// 更新数据
			$oplogdata = serialize($data);
			oplog('admin', "更新商品", web_url('goods/goods/post'), $oplogdata);
			
		}
		
		$data_img = $_GPC['data_img'];
		$data_tag = $_GPC['data_tag'];
		$len = count($data_img);
		$tag = array();
		for ($k = 0; $k < $len; $k++) {
			$tag[$k]['data_img'] = $data_img[$k];
			$tag[$k]['data_tag'] = $data_tag[$k];
		}
//		wl_debug($_GPC['param_value']);
		
		model_goods::UpdateParam($id, $_GPC['param_id'], $_GPC['param_title'], $_GPC['param_value'],$tag);//更新自定义属性
		model_goods::UpdateOption($id,$_GPC);//更新规格
		$enough = $_GPC['enough']; //满多少元
		$give = $_GPC['give']; //减多少元
		$free_freight = $_GPC['free_freight']; //包邮条件
		$giftids = $_GPC['giftid']; //赠品
		$deduction = $_GPC['deduction'];//抵扣
		model_goods::updateMarketing($enough, $give, $free_freight, $giftids, $deduction, $id); //更新营销
		Util::deleteCache('goods', $goods['id']);//删除缓存
		message('商品信息保存成功', web_url('goods/goods/post',array('id'=>$id)), 'success');
	}
	include wl_template('goods/goods_post');
}
if($op == 'searchcoupons'){
	$con     = "uniacid='{$_W['uniacid']}' ";
	$keyword = $_GPC['keyword'];
	if ($keyword != '') {
		$con .= " and (name LIKE '%{$keyword}%' or id LIKE '%{$keyword}%') ";
	}
	$ds = pdo_fetchall("select * from" . tablename('tg_coupon_template') . "where $con");
	include wl_template('goods/query_coupons');
	exit;
}
if ($op == 'batch') {
	Util::deleteCache('goods', 'allGoods');//删除缓存
	$funcop = $_GPC['funcop'];
	$goods_ids = $_GPC['goods_ids'];
	foreach($goods_ids as $key =>$id){
		if($funcop=='on_shelves') pdo_update('tg_goods',array('isshow'=>1), array('id'=>$id));
		if($funcop=='off_shelves')pdo_update('tg_goods',array('isshow'=>2), array('id'=>$id));
		if($funcop=='delete')     pdo_update('tg_goods',array('isshow'=>4), array('id'=>$id));
		if($funcop=='remove'){
				$delgoods = model_goods::getSingleGoods($id, '*', array('id'=>$id));
				if(pdo_delete('tg_goods',array('id'=>$id))){
					$oplogdata = serialize($delgoods);
					oplog('admin', "删除商品", web_url('goods/goods/batch'), $oplogdata);
				}
		}
		Util::deleteCache('goods', $id);
	}
	if($funcop=='on_shelves')die(json_encode(array("errno" => 0,'message'=>'上架成功')));	
	if($funcop=='off_shelves')die(json_encode(array("errno" => 0,'message'=>'下架成功')));	
	if($funcop=='delete')die(json_encode(array("errno" => 0,'message'=>'删除成功')));	
	if($funcop=='remove'){
		if($res)die(json_encode(array("errno" => 0,'message'=>'抽奖商品删除失败,其它商品删除成功')));
		die(json_encode(array("errno" => 0,'message'=>'彻底删除成功')));	
	}
	
}

if ($op == 'single_op') {
	$funcop = $_GPC['funcop'];
	$id = intval($_GPC['id']);
	Util::deleteCache('goods', $id);
	if($funcop=='on_shelves'){
		if(pdo_update('tg_goods',array('isshow'=>1), array('id'=>$id)))
			die(json_encode(array("errno" => 0,'message'=>'上架成功')));	
		else
			die(json_encode(array("errno" => 1,'message'=>'上架失败')));	
	}
	if($funcop=='off_shelves'){
		if(pdo_update('tg_goods',array('isshow'=>2), array('id'=>$id)))
			die(json_encode(array("errno" => 0,'message'=>'下架成功')));	
		else
			die(json_encode(array("errno" => 1,'message'=>'下架成功')));	
	}
	if($funcop=='sellout'){
		if(pdo_update('tg_goods',array('isshow'=>3), array('id'=>$id)))
			die(json_encode(array("errno" => 0,'message'=>'设置售罄成功')));	
		else
			die(json_encode(array("errno" => 1,'message'=>'设置售罄失败')));	
	}
	if($funcop=='delete'){
		if(pdo_update('tg_goods',array('isshow'=>4), array('id'=>$id)))
			die(json_encode(array("errno" => 0,'message'=>'删除成功')));	
		else
			die(json_encode(array("errno" => 1,'message'=>'删除失败')));	
	}
	if($funcop=='remove'){
		$lottery=pdo_fetch("select id from".tablename("tg_lottery")."where uniacid={$_W['uniacid']} and fk_goodsid={$id}");
		if(!empty($lottery))die(json_encode(array("errno" => 0,'message'=>'该商品属于抽奖商品,请先删除抽奖活动！')));	
		$delgoods = model_goods::getSingleGoods($id, '*', array('id'=>$id));
		if(pdo_delete('tg_goods',array('id'=>$id))){
			$oplogdata = serialize($delgoods);
			oplog('admin', "删除商品", web_url('goods/goods/single_op'), $oplogdata);
			die(json_encode(array("errno" => 0,'message'=>'彻底删除成功')));	
		}else{
			die(json_encode(array("errno" => 1,'message'=>'彻底删除失败')));	
		}
	}
}
if ($op == 'pass') {
	$funcop = $_GPC['funcop'];
	$id = intval($_GPC['id']);
	if($funcop=='pass'){
		if(pdo_update('tg_discuss',array('status'=>2), array('id'=>$id)))
			die(json_encode(array("errno" => 0,'message'=>'通过成功')));	
		else
			die(json_encode(array("errno" => 1,'message'=>'通过')));	
	}
	if($funcop=='nopass'){
		if(pdo_update('tg_discuss',array('status'=>3), array('id'=>$id)))
			die(json_encode(array("errno" => 0,'message'=>'不通过成功')));	
		else
			die(json_encode(array("errno" => 1,'message'=>'不通过')));	
	}
}
if ($op == 'reply'){
	$id = intval($_GPC['id']);
	$reply = $_GPC['reply'];
	if(pdo_update('tg_discuss',array('storereply'=>$reply), array('id'=>$id))){
		die(json_encode(array("errno" => 0)));	
	}else {
		die(json_encode(array("errno" => 1)));	
	}
	
}

if ($op == 'setgoodsproperty') {
	$id = intval($_GPC['id']);
	Util::deleteCache('goods', $id);
	$type = $_GPC['type'];
	$data = intval($_GPC['data']);
	if (in_array($type, array('new', 'hot', 'recommand', 'discount'))) {
		$data = ($data==1?'0':'1');
		pdo_update("tg_goods", array("is" . $type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
		die(json_encode(array("result" => 1, "data" => $data)));
	}
	if (in_array($type, array('isshow'))) {
		$data = ($data==1?'0':'1');
		pdo_update("tg_goods", array($type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
		die(json_encode(array("result" => 1, "data" => $data)));
	}
	if($type=='isshow2'){
		$data = ($data==1?'3':'1');
		pdo_update("tg_goods", array("isshow" => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
		die(json_encode(array("result" => 1, "data" => $data)));
	}
	die(json_encode(array("result" => 0)));	
}
if($op == 'copy'){
	$id = $_GPC['id'];
	$goods = pdo_fetch("select * from".tablename('tg_goods')."where id={$id}");	
	if($goods['is_hexiao']==3)$goods['is_hexiao']=0;
	unset($goods['id']);
	unset($goods['g_type']);
	unset($goods['prize']);
	$goods['isshow']=2;
	$goods['hasoption']=0;
	$goods['salenum'] = 0;
	if(pdo_insert("tg_goods",$goods)){
		$goodsid = pdo_insertid();
		$allspecs = pdo_fetchall("select * from " . tablename('tg_spec')." where goodsid=:id order by displayorder asc",array(":id"=>$id));
		if($allspecs){
			foreach ($allspecs as $key => $specs) {
				$specitems = pdo_fetchall("select * from " . tablename('tg_spec_item') . " where specid=:specid order by displayorder asc", array(":specid" => $specs['id']));
				unset($specs['id']);
				$specs['goodsid'] = $goodsid;
				pdo_insert("tg_spec",$specs);
				$newspecid = pdo_insertid();
				foreach ($specitems as $key => $itmes) {
					unset($itmes['id']);
					$itmes['specid'] = $newspecid;
					pdo_insert("tg_spec_item",$itmes);
				}
			}
			pdo_update('tg_goods',array('hasoption' => 1),array('id' => $goodsid));
		}
		$marketings = pdo_fetchall("select * from".tablename("tg_marketing")."where fk_goodsid={$id}");
		if($marketings){
			foreach ($marketings as $key => $mark){
				unset($mark['id']);
				$mark['fk_goodsid'] = $goodsid;
				pdo_insert("tg_marketing",$mark);
			}
		}
		die(json_encode(array('errno'=>0)));
	}else {
		die(json_encode(array('errno'=>1)));
	}
}
if ($op == 'selectgift') {
	$con     = "uniacid={$_W['uniacid']}";
	$keyword = $_GPC['keyword'];
	if ($keyword != '') {
		$con .= " and name LIKE '%{$keyword}%' ";
	}
	$ds = pdo_fetchall("select * from" . tablename('tg_gift') . "where $con ");
	foreach($ds as &$item){
		$item['goods'] = model_goods::getSingleGoods($item['goodsid'], 'gimg,gname');
	}
	include wl_template('goods/marketing/select_gift');
	exit;
}
if($op == 'taobaourl'){
	load()->func('communication');
	load()->func('file');
	$url = $_GPC['url'];
	$item=model_goods::get_item_taobao($url);
	$title = $item['title'];
	$thumbs = $item['pics'];
	$price = $item['marketprice']?$item['marketprice']:$item['options'][0]['marketprice'];
	$detail=$item['content']['content'];
	$thumbs_return = array();
	$media_return = array();
	if (!empty($thumbs)) {
		$option = array();
		$option = array_elements(array('uploadtype', 'global', 'dest_dir'), $_POST);
		$option['width'] = intval($option['width']);
		$option['global'] = !empty($_COOKIE['__fileupload_global']);
		if (!empty($option['global']) && empty($_W['isfounder'])) {
			$result['message'] = '没有向 global 文件夹上传文件的权限.';
			die(json_encode($result));
		}
		$dest_dir = $_COOKIE['__fileupload_dest_dir'];
		if (preg_match('/^[a-zA-Z0-9_\/]{0,50}$/', $dest_dir, $out)) {
			$dest_dir = trim($dest_dir, '/');
			$pieces = explode('/', $dest_dir);
			if(count($pieces) > 3) $dest_dir = '';
		} else {
			$dest_dir = '';
		}
		
		$setting = $_W['setting']['upload'][image];
		$uniacid = intval($_W['uniacid']);
		$dest_dir = $_COOKIE['__fileupload_dest_dir'];
		if (preg_match('/^[a-zA-Z0-9_\/]{0,50}$/', $dest_dir, $out)) {
			$dest_dir = trim($dest_dir, '/');
			$pieces = explode('/', $dest_dir);
			if(count($pieces) > 3) $dest_dir = '';
		} else {
			$dest_dir = '';
		}
		if (!empty($option['global'])) {
			$setting['folder'] = "images/global/";
			if (!empty($dest_dir))  $setting['folder'] .= '/'.$dest_dir.'/';
		} else {
			$setting['folder'] = "images/{$uniacid}";
			if(empty($dest_dir))
				$setting['folder'] .= '/'.date('Y/m/');
			 else 
				$setting['folder'] .= '/'.$dest_dir.'/';
		}
		$attPath = ATTACHMENT_ROOT. $setting['folder'];
		if(!is_dir($attPath)) mkdirs($attPath,0777);
		foreach ($thumbs as $i => $url) {
			$pathinfo = pathinfo($url);
			$extension = !empty($pathinfo['extension']) ? $pathinfo['extension'] : 'jpg';
			$originname = $pathinfo['basename'];
			$resp = @ihttp_request($url);
			if (!is_error($resp) && $resp['code'] != '404') {
				$filename = file_random_name($attPath, $extension);
				$pathname = $setting['folder'] . $filename;
				$fullname = ATTACHMENT_ROOT  . $pathname;
				$thumbs_return[] = $pathname;
				$media_return[] = tomedia($pathname);
				if (file_put_contents($fullname, $resp['content']) == true) {
					if (!empty($_W['setting']['upload']['image']['resize']['enable']) && intval($_W['setting']['upload']['image']['resize']['width']) > 0) {
						file_image_thumb($fullname, $fullname, intval($_W['setting']['upload']['image']['resize']['width']));
					}else{
						file_image_thumb($fullname, $fullname.'.thumb.jpg', 350);
						$remotestatus = file_remote_upload($pathname);
					}
				}
			}
		}
	}else{
		die(json_encode(array('data'=>0)));
	}
	$data = array(
		'thumbs' => $thumbs_return,
		'media_thumbs'=>$media_return,
		'title' => $title,
		'price'=>$price,
		'detail'=>$item
	);

	die(json_encode($data));
}

if($op == 'asdasd'){
	$goods = pdo_fetchall("select * from".tablename('tg_goods'));	
	foreach ($goods as $key => $good) {
		$id = $good['id'];	
		$all = $good['salenum'] + $good['falsenum'];
		$data = array(
			'allsalenum' => $all,
		);
		$res = pdo_update('tg_goods',$data,array('id' => $id));
	}
}
if ($op == 'tag') {
	include wl_template('goods/imgandtag');
}

if($op == 'param'){
	$tag = random(32);
	global $_GPC;
	load()->func('tpl');
	include wl_template('goods/param');
}

if ($op == 'getcoupon') {
	$con = "uniacid='{$_W['uniacid']}'";
	$keyword = $_GPC['keyword'];
	if ($keyword != '') {
		$con .= " and name LIKE '%{$keyword}%' ";
	}
	$ds = pdo_fetchall("select id,name from" . tablename('tg_coupon_template') . "where $con ");
	include wl_template('goods/select_coupon');
	exit;
}

