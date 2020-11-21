<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('display', 'post', 'single_op', 'batch','setgoodsproperty');
$op_names = array('商品列表','新增/修改商品','上下架/售罄/删除/彻底删除','批量设置','设置商品属性');
foreach($ops as$key=>$value){
	permissions('do', 'ac', 'op', 'goods', 'goods', $ops[$key], '商品', '商品管理', $op_names[$key]);
}
$op = in_array($op, $ops) ? $op : 'display';
$flag=allow($controller, $action, $op, MERCHANTID);
if(!$flag){
	message("没有权限!",referer(), 'error');exit;
}
wl_load()->model('goods');
$merchants = pdo_fetchall("SELECT * FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}' and id=".MERCHANTID);
$submit_merchant = pdo_fetch("SELECT * FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}' and id=".MERCHANTID);
$category =  pdo_fetchall("SELECT * FROM " . tablename('tg_category') . " WHERE uniacid = '{$_W['uniacid']}' and parentid=0  ORDER BY id DESC");
$childs = array();
foreach($category as $key=>$value){
	$category_childs = pdo_fetchall("SELECT * FROM " . tablename('tg_category') . " WHERE uniacid = '{$_W['uniacid']}' and parentid={$value['id']} and enabled=1 ORDER BY displayorder DESC");
	$childs[$value['id']] = $category_childs;
}
if ($op == 'display') {
	$args = array();
	$args['usepage'] = 1;
	$args['page'] = max(1, intval($_GPC['page']));
	$args['pagesize'] = 10;
	$condition = " and merchantid=".MERCHANTID;
	if (!isset($_GPC['status'])) {
		$_GPC['status'] = 1;
	}
	if (isset($_GPC['status'])) {
		$condition .= " and isshow in(".$_GPC['status'].") ";
	}
	if (!empty($_GPC['category']['parentid'])) {
		$condition .= " and  category_parentid = {$_GPC['category']['parentid']} ";
	}
	if (!empty($_GPC['category']['childid'])) {
		$condition .= " and  category_childid = {$_GPC['category']['childid']} ";
	}
	if (!empty($_GPC['merchantid'])) {
		if($_GPC['merchantid']=='self')
			$condition .= " and  merchantid = 0 ";
		else
			$condition .= " and  merchantid = {$_GPC['merchantid']} ";
	}
	if (!empty($_GPC['keyword'])) {
		$condition .= " and  gname like '%{$_GPC['keyword']}%'";
	}
//	wl_debug($condition);
	$goodslist = goods_get_list($condition);
//	wl_debug($goodslist);
	$goodses = $goodslist['list'];
	foreach($goodses as$key=>&$value){
		$merchant = pdo_fetch("SELECT name FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}' and id={$value['merchantid']}");
		$value['merchantname'] = $merchant['name'];
	}
	$total = $goodslist['total'];
	$pager = pagination($total, $args['page'], $args['pagesize']);
	
	include wl_template('goods/goods_display');
	exit;
} elseif ($op == 'post') {
	$id = intval($_GPC['id']);
	$muban_array = array();
	$dispatch_list = pdo_fetchall("select * from".tablename('tg_delivery_template')." WHERE uniacid = '{$_W['uniacid']}' and merchantid = ".MERCHANTID);
	$store_list = pdo_fetchall("select storename,id from " . tablename("tg_store") . " WHERE status=1 and uniacid = {$_W['uniacid']}  order by id desc");
	$thisgoods = pdo_fetch("select hexiao_id from " . tablename("tg_goods") . " WHERE id='{$id}'");
	$storesids = explode(",", $thisgoods['hexiao_id']);
	foreach($storesids as$key=>$value){
		if($value){
			$stores[$key] =  pdo_fetch("select * from".tablename('tg_store')."where id ='{$value}' and uniacid='{$_W['uniacid']}'");
		}
	}
	if (!empty($id)) {
		$sql = 'SELECT * FROM ' . tablename('tg_goods') . ' WHERE id=:id ';
		$paramse = array(':id' => $id);
		$goods = pdo_fetch($sql, $paramse);
		//阶梯团
		$param_level = unserialize($goods['group_level']);
		//获取当前图集
		$listt = pdo_fetchall("SELECT * FROM" . tablename('tg_goods_atlas') . "WHERE g_id = '{$id}' ");
		$piclist = array();
		if (is_array($listt)) {
			foreach ($listt as $p) {
				$piclist[] = $p['thumb'];
			}
		}
		$allspecs = pdo_fetchall("select * from " . tablename('tg_spec')." where goodsid=:id order by displayorder asc",array(":id"=>$id));
		foreach ($allspecs as &$s) {
			$s['items'] = pdo_fetchall("select * from " . tablename('tg_spec_item') . " where specid=:specid order by displayorder asc", array(":specid" => $s['id']));
		}
		unset($s);
		//处理规格项
		$html = "";
		$options = pdo_fetchall("select * from " . tablename('tg_goods_option') . " where goodsid=:id order by id asc", array(':id' => $id));
		//排序好的specs
		$specs = array();
		//找出数据库存储的排列顺序
		if (count($options) > 0) {
			$specitemids = explode("_", $options[0]['specs'] );
			foreach($specitemids as $itemid){
				foreach($allspecs as $ss){
					$items = $ss['items'];
					foreach($items as $it){
						if($it['id']==$itemid){
							$specs[] = $ss;
							break;
						}
					}
				}
			}
			$html = '';
			$html .= '<table class="table table-bordered table-condensed">';
			$html .= '<thead>';
			$html .= '<tr class="active">';
			$len = count($specs);
			$newlen = 1; //多少种组合
			$h = array(); //显示表格二维数组
			$rowspans = array(); //每个列的rowspan
			for ($i = 0; $i < $len; $i++) {
				//表头
				$html .= "<th style='width:80px;'>" . $specs[$i]['title'] . "</th>";
				//计算多种组合
				$itemlen = count($specs[$i]['items']);
				if ($itemlen <= 0) {
					$itemlen = 1;
				}
				$newlen *= $itemlen;
				//初始化 二维数组
				$h = array();
				for ($j = 0; $j < $newlen; $j++) {
					$h[$i][$j] = array();
				}
				//计算rowspan
				$l = count($specs[$i]['items']);
				$rowspans[$i] = 1;
				for ($j = $i + 1; $j < $len; $j++) {
					$rowspans[$i]*= count($specs[$j]['items']);
				}
			}
			$html .= '<th class="info" style="width:130px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">库存</div><div class="input-group"><input type="text" class="form-control option_stock_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_stock\');"></a></span></div></div></th>';
			$html .= '<th class="success" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">拼团价格</div><div class="input-group"><input type="text" class="form-control option_marketprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_marketprice\');"></a></span></div></div></th>';
			$html .= '<th class="warning" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">单买价格</div><div class="input-group"><input type="text" class="form-control option_productprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_productprice\');"></a></span></div></div></th>';
			$html .= '<th class="danger" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">市场价格</div><div class="input-group"><input type="text" class="form-control option_costprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_costprice\');"></a></span></div></div></th>';
			$html .= '<th class="info" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">重量（克）</div><div class="input-group"><input type="text" class="form-control option_weight_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_weight\');"></a></span></div></div></th>';
			$html .= '</tr></thead>';
			for ($m = 0; $m < $len; $m++) {
				$k = 0;
				$kid = 0;
				$n = 0;
				for ($j = 0; $j < $newlen; $j++) {
					$rowspan = $rowspans[$m];
					if ($j % $rowspan == 0) {
						$h[$m][$j] = array("html" => "<td rowspan='" . $rowspan . "'>" . $specs[$m]['items'][$kid]['title'] . "</td>", "id" => $specs[$m]['items'][$kid]['id']);
					} else {
						$h[$m][$j] = array("html" => "", "id" => $specs[$m]['items'][$kid]['id']);
					}
					$n++;
					if ($n == $rowspan) {
						$kid++;
						if ($kid > count($specs[$m]['items']) - 1) {
							$kid = 0;
						}
						$n = 0;
					}
				}
			}
			$hh = "";
			for ($i = 0; $i < $newlen; $i++) {
				$hh.="<tr>";
				$ids = array();
				for ($j = 0; $j < $len; $j++) {
					$hh.=$h[$j][$i]['html'];
					$ids[] = $h[$j][$i]['id'];
				}
				$ids = implode("_", $ids);
				$val = array("id" => "","title"=>"", "stock" => "", "costprice" => "", "productprice" => "", "marketprice" => "", "weight" => "");
				foreach ($options as $o) {
					if ($ids === $o['specs']) {
						$val = array(
							"id" => $o['id'],
							"title" =>$o['title'],
							"stock" => $o['stock'],
							"costprice" => $o['costprice'],
							"productprice" => $o['productprice'],
							"marketprice" => $o['marketprice'],
							"weight" => $o['weight']
						);
						break;
					}
				}
				$hh .= '<td class="info">';
				$hh .= '<input name="option_stock_' . $ids . '[]"  type="text" class="form-control option_stock option_stock_' . $ids . '" value="' . $val['stock'] . '"/></td>';
				$hh .= '<input name="option_id_' . $ids . '[]"  type="hidden" class="form-control option_id option_id_' . $ids . '" value="' . $val['id'] . '"/>';
				$hh .= '<input name="option_ids[]"  type="hidden" class="form-control option_ids option_ids_' . $ids . '" value="' . $ids . '"/>';
				$hh .= '<input name="option_title_' . $ids . '[]"  type="hidden" class="form-control option_title option_title_' . $ids . '" value="' . $val['title'] . '"/>';
				$hh .= '</td>';
				$hh .= '<td class="success"><input name="option_marketprice_' . $ids . '[]" type="text" class="form-control option_marketprice option_marketprice_' . $ids . '" value="' . $val['marketprice'] . '"/></td>';
				$hh .= '<td class="warning"><input name="option_productprice_' . $ids . '[]" type="text" class="form-control option_productprice option_productprice_' . $ids . '" " value="' . $val['productprice'] . '"/></td>';
				$hh .= '<td class="danger"><input name="option_costprice_' . $ids . '[]" type="text" class="form-control option_costprice option_costprice_' . $ids . '" " value="' . $val['costprice'] . '"/></td>';
				$hh .= '<td class="info"><input name="option_weight_' . $ids . '[]" type="text" class="form-control option_weight option_weight_' . $ids . '" " value="' . $val['weight'] . '"/></td>';
				$hh .= '</tr>';
			}
			$html .= $hh;
			$html .= "</table>";
		}
		$params = pdo_fetchall("SELECT * FROM" . tablename('tg_goods_param') . "WHERE goodsid = '{$id}' ");
		if (empty($goods)) {
			message('未找到指定的商品.', $this -> createWebUrl('goods'));
		}
		
		$orders = pdo_fetchall("SELECT * FROM" . tablename('tg_order') . "WHERE g_id = '{$id}'");
		$arr = array();
		foreach ($orders as $key => $value) {
			$arr['endtime'] = $value['endtime'];
		}
		$endtime = $arr['endtime'];
	}
	if (checksubmit()) {
		//核销ID
		$store = $_GPC['storeids'];
		$str='';
		if($store){
			foreach($store as $key => $value){
			$str.=$value.",";
		}
		}
		
		$images = $_GPC['img'];
		//获取图集
		$data = $_GPC['goods'];
		if(empty($data['fk_typeid'])){
			$data['fk_typeid']=$data['category_parentid'] = $_GPC['category']['parentid'];
		}else{
			$data['category_parentid'] = $data['fk_typeid'];
		}
		
		$data['category_childid'] = $_GPC['category']['childid'];
		//阶梯团
		
		$data['hexiao_id']=$str;
		$data['gdetaile'] = htmlspecialchars_decode($data['gdetaile']);
		$data['endtime'] = $_GPC['endtime'];
		if($data['group_level_status'] == 2){
			$data['hasoption'] = 0;
		}else{
			$data['hasoption'] = intval($_GPC['hasoption']);
		}

		if (empty($goods)) {
			$data['uniacid'] = $_W['uniacid'];
			$data['createtime'] = TIMESTAMP;
			$ret = pdo_insert('tg_goods', $data);
			$oplogdata = serialize($data);
			oplog('商家：'.$submit_merchant['name'], "添加商品", web_url('goods/goods/post'), $oplogdata);
			if (!empty($ret)) {
				$id = pdo_insertid();
			}
			if ($images) {
				foreach ($images as $key => $value) {
					$data1 = array('thumb' => $images[$key], 'g_id' => $id);
					pdo_insert('tg_goods_atlas', $data1);
				}
			}
		} else {
			if ($images) {
				pdo_delete('tg_goods_atlas', array('g_id' => $id));
				foreach ($images as $key => $value) {
					$data2 = array('thumb' => $images[$key], 'g_id' => $id);
					pdo_insert('tg_goods_atlas', $data2);
				}
			}
			$ret = pdo_update('tg_goods', $data, array('id' => $id));
			$oplogdata = serialize($data);
			oplog('商家：'.$submit_merchant['name'], "更新商品", web_url('goods/goods/post'), $oplogdata);
		}
		//处理自定义参数
		$param_ids = $_POST['param_id'];
		$param_titles = $_POST['param_title'];
		$param_values = $_POST['param_value'];
		$param_displayorders = $_POST['param_displayorder'];
		$len = count($param_ids);
		$paramids = array();
		for ($k = 0; $k < $len; $k++) {
			$param_id = "";
			$get_param_id = $param_ids[$k];
			$a = array("title" => $param_titles[$k], "value" => $param_values[$k], "displayorder" => $k, "goodsid" => $id, );
			if (!is_numeric($get_param_id)) {
				pdo_insert("tg_goods_param", $a);
				$param_id = pdo_insertid();
			} else {
				pdo_update("tg_goods_param", $a, array('id' => $get_param_id));
				$param_id = $get_param_id;
			}
			$paramids[] = $param_id;
		}
		if (count($paramids) > 0) {
			pdo_query("delete from " . tablename('tg_goods_param') . " where goodsid=$id and id not in ( " . implode(',', $paramids) . ")");
		} else {
			pdo_query("delete from " . tablename('tg_goods_param') . " where goodsid=$id");
		}
		//处理商品规格
		$files = $_FILES;
		$spec_ids = $_POST['spec_id'];
		$spec_titles = $_POST['spec_title'];
		$specids = array();
		$len = count($spec_ids);
		$specids = array();
		$spec_items = array();
		for ($k = 0; $k < $len; $k++) {
			$spec_id = "";
			$get_spec_id = $spec_ids[$k];
			$a = array(
				"uniacid" => $_W['uniacid'],
				"goodsid" => $id,
				"displayorder" => $k,
				"title" => $spec_titles[$get_spec_id]
			);
			if (is_numeric($get_spec_id)) {
				pdo_update("tg_spec", $a, array("id" => $get_spec_id));
				$spec_id = $get_spec_id;
			} else {
				pdo_insert("tg_spec", $a);
				$spec_id = pdo_insertid();
			}
			//子项
			$spec_item_ids = $_POST["spec_item_id_".$get_spec_id];
			$spec_item_titles = $_POST["spec_item_title_".$get_spec_id];
			$spec_item_shows = $_POST["spec_item_show_".$get_spec_id];
			$spec_item_thumbs = $_POST["spec_item_thumb_".$get_spec_id];
			$spec_item_oldthumbs = $_POST["spec_item_oldthumb_".$get_spec_id];
			$itemlen = count($spec_item_ids);
			$itemids = array();
			for ($n = 0; $n < $itemlen; $n++) {
				$item_id = "";
				$get_item_id = $spec_item_ids[$n];
				$d = array(
					"uniacid" => $_W['uniacid'],
					"specid" => $spec_id,
					"displayorder" => $n,
					"title" => $spec_item_titles[$n],
					"show" => $spec_item_shows[$n],
					"thumb"=>$spec_item_thumbs[$n]
				);
				$f = "spec_item_thumb_" . $get_item_id;
				if (is_numeric($get_item_id)) {
					pdo_update("tg_spec_item", $d, array("id" => $get_item_id));
					$item_id = $get_item_id;
				} else {
					pdo_insert("tg_spec_item", $d);
					$item_id = pdo_insertid();
				}
				$itemids[] = $item_id;
				//临时记录，用于保存规格项
				$d['get_id'] = $get_item_id;
				$d['id']= $item_id;
				$spec_items[] = $d;
			}
			//删除其他的
			if(count($itemids)>0){
				pdo_query("delete from " . tablename('tg_spec_item') . " where uniacid={$_W['uniacid']} and specid=$spec_id and id not in (" . implode(",", $itemids) . ")");	
			}
			else{
				pdo_query("delete from " . tablename('tg_spec_item') . " where uniacid={$_W['uniacid']} and specid=$spec_id");	
			}
			//更新规格项id
			pdo_update("tg_spec", array("content" => serialize($itemids)), array("id" => $spec_id));
			$specids[] = $spec_id;
		}
		//删除其他的
		if( count($specids)>0){
			pdo_query("delete from " . tablename('tg_spec') . " where uniacid={$_W['uniacid']} and goodsid=$id and id not in (" . implode(",", $specids) . ")");
		}
		else{
			pdo_query("delete from " . tablename('tg_spec') . " where uniacid={$_W['uniacid']} and goodsid=$id");
		}
		//保存规格
		$option_idss = $_POST['option_ids'];
		$option_productprices = $_POST['option_productprice'];
		$option_marketprices = $_POST['option_marketprice'];
		$option_costprices = $_POST['option_costprice'];
		$option_stocks = $_POST['option_stock'];
		$option_weights = $_POST['option_weight'];
		$len = count($option_idss);
		$optionids = array();
		for ($k = 0; $k < $len; $k++) {
			$option_id = "";
			$get_option_id = $_GPC['option_id_' . $ids][0];
			$ids = $option_idss[$k]; $idsarr = explode("_",$ids);
			$newids = array();
			foreach($idsarr as $key=>$ida){
				foreach($spec_items as $it){
					if($it['get_id']==$ida){
						$newids[] = $it['id'];
						break;
					}
				}
			}
			$newids = implode("_",$newids);
			$a = array(
				"title" => $_GPC['option_title_' . $ids][0],
				"productprice" => $_GPC['option_productprice_' . $ids][0],
				"costprice" => $_GPC['option_costprice_' . $ids][0],
				"marketprice" => $_GPC['option_marketprice_' . $ids][0],
				"goodsid" => $id,
				"specs" => $newids
			);
			if (empty($get_option_id)) {
				pdo_insert("tg_goods_option", $a);
				$option_id = pdo_insertid();
			} else {
				pdo_update("tg_goods_option", $a, array('id' => $get_option_id));
				$option_id = $get_option_id;
			}
			$optionids[] = $option_id;
		}
		if (count($optionids) > 0) {
			pdo_query("delete from " . tablename('tg_goods_option') . " where goodsid=$id and id not in ( " . implode(',', $optionids) . ")");
		}else{
			pdo_query("delete from " . tablename('tg_goods_option') . " where goodsid=$id");
		}
		message('商品信息保存成功', web_url('goods/goods'), 'success');
	}
	include wl_template('goods/goods_post');
	exit;
}elseif ($op == 'batch') {
	$funcop = $_GPC['funcop'];
	$goods_ids = $_GPC['goods_ids'];
	foreach($goods_ids as $key =>$id){
		if($funcop=='on_shelves'){
			if(goods_update_by_params(array('isshow'=>1), array('id'=>$id))){
			}else{
			}
		}
		if($funcop=='off_shelves'){
			if(goods_update_by_params(array('isshow'=>2), array('id'=>$id))){
			}else{
			}
			
		}
		if($funcop=='delete'){
			if(goods_update_by_params(array('isshow'=>4), array('id'=>$id))){
			}else{
			}
		}
		if($funcop=='remove'){
			$delgoods = goods_get_by_params(" id={$id} ");
			if(goods_delete($id)){
				$oplogdata = serialize($delgoods);
				oplog('商家：'.$submit_merchant['name'], "删除商品", web_url('goods/goods/batch'), $oplogdata);
			}else{
			}
		}
	}
		if($funcop=='on_shelves'){
				die(json_encode(array("errno" => 0,'message'=>'上架成功')));	
		}
		if($funcop=='off_shelves'){
				die(json_encode(array("errno" => 0,'message'=>'下架成功')));	
			
		}
		if($funcop=='delete'){
				die(json_encode(array("errno" => 0,'message'=>'删除成功')));	
		}
		if($funcop=='remove'){
				die(json_encode(array("errno" => 0,'message'=>'彻底删除成功')));	
		}
	
} elseif ($op == 'single_op') {
	$funcop = $_GPC['funcop'];
	$id = $_GPC['id'];
	if($funcop=='on_shelves'){
		if(goods_update_by_params(array('isshow'=>1), array('id'=>$id))){
			die(json_encode(array("errno" => 0,'message'=>'上架成功')));	
		}else{
			die(json_encode(array("errno" => 1,'message'=>'上架失败')));	
		}
	}
	if($funcop=='off_shelves'){
		if(goods_update_by_params(array('isshow'=>2), array('id'=>$id))){
			die(json_encode(array("errno" => 0,'message'=>'下架成功')));	
		}else{
			die(json_encode(array("errno" => 1,'message'=>'下架成功')));	
		}
		
	}
	if($funcop=='sellout'){
		if(goods_update_by_params(array('isshow'=>3), array('id'=>$id))){
			die(json_encode(array("errno" => 0,'message'=>'设置售罄成功')));	
		}else{
			die(json_encode(array("errno" => 1,'message'=>'设置售罄失败')));	
		}
	}
	if($funcop=='delete'){
		if(goods_update_by_params(array('isshow'=>4), array('id'=>$id))){
			die(json_encode(array("errno" => 0,'message'=>'删除成功')));	
		}else{
			die(json_encode(array("errno" => 1,'message'=>'删除失败')));	
		}
	}
	if($funcop=='remove'){
		$flag = goods_delete($id);
		if($flag){
			$delgoods = goods_get_by_params(" id={$id} ");
			$oplogdata = serialize($delgoods);
			oplog('商家：'.$submit_merchant['name'], "删除商品", web_url('goods/goods/single_op'), $oplogdata);
			die(json_encode(array("errno" => 0,'message'=>'彻底删除成功')));	
		}else{
			die(json_encode(array("errno" => 1,'message'=>'彻底删除失败')));	
		}
	}
	
} elseif ($op == 'setgoodsproperty') {
		$id = intval($_GPC['id']);
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
