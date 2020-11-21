<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2020.
// +----------------------------------------------------------------------
// | Describe: 商品操作模型类
// +----------------------------------------------------------------------
// | Author: weliam<937991452@qq.com>
// +----------------------------------------------------------------------
 class model_goods
 {
 	/** 
 	* 获取单条商品数据 
 	* 
 	* @access static
 	* @name getSingleGoods 
 	* @param $where   查询条件 
 	* @param $select  查询参数 
 	* @return array 
 	*/  
	static function getSingleGoods($id,$select,$where=array()){
		$where['id'] = $id;
//		$goodsInfo = Util::getDataByCacheFirst('goods',$id,array('Util','getSingelData'),array($select,'tg_goods',$where));
		$goodsInfo = Util::getSingelData($select,'tg_goods',$where);
		if(empty($goodsInfo)) return array();
		return self::initSingleGoods($goodsInfo);
		//需删除缓存
	}
 	/** 
 	* 获取多条商品数据 
 	* 
 	* @access static
 	* @name getNumGoods 
 	* @param $where   查询条件 
 	* @param $select  查询参数 
 	* @return array 
 	*/
	static function getNumGoods($select,$where,$order,$pindex,$psize,$ifpage){
		$goodsInfo = Util::getNumData($select,"tg_goods", $where,$order,$pindex, $psize,$ifpage);
		foreach($goodsInfo[0] as $k=>$v){
			$newGoodInfo[$k] = self::initSingleGoods($v);
		}
		$newGoodInfo=$newGoodInfo?$newGoodInfo:array();
		return array($newGoodInfo,$goodsInfo[1],$goodsInfo[2])?array($newGoodInfo,$goodsInfo[1],$goodsInfo[2]):array();
	}	
	/** 
 	* 获取全部商品数据By缓存 
 	* 
 	* @access static
 	* @name getNumGoods 
 	* @param $where   查询条件 
 	* @param $select  查询参数 
 	* @return array 
 	*/
	static function getAllGoods($select,$where,$order,$pindex,$psize,$ifpage){
		$goodsInfo = Util::getDataByCacheFirst('goods','allGoods',array('Util','getNumData'),array($select,'tg_goods',$where,$order,$pindex, $psize,$ifpage));
//		$goodsInfo = Util::getNumData($select,"tg_goods", $where,$order,$pindex, $psize,$ifpage);
		foreach($goodsInfo[0] as $k=>$v){
			$newGoodInfo[$k] = self::initSingleGoods($v);
		}
		return array($newGoodInfo,$goodsInfo[1],$goodsInfo[2]);
	}
 	/** 
 	* 初始化商品数据 
 	* 
 	* @access static
 	* @name  initSingleGoods 
 	* @param $goodsInfo  商品数据 
 	* @return $goodsInfo 
 	*/
	static function initSingleGoods($goodsInfo){
		global $_W;
		$goodsInfo = self::goodsCompatible($goodsInfo);
		$goodsInfo['gimg'] = tomedia($goodsInfo['gimg']);
		$goodsInfo['a'] = app_url('goods/detail/display',array('id'=>$goodsInfo['id']));//微信端连接
		if($goodsInfo['merchantid']){
			$merchant = pdo_fetch("SELECT name FROM " . tablename('tg_merchant') . " WHERE uniacid = {$_W['uniacid']} and id={$goodsInfo['merchantid']}");
			$goodsInfo['merchantname'] = $merchant['name'];
		}
		if($goodsInfo['id'])
		$params = pdo_fetchall("SELECT * FROM" . tablename('tg_goods_param') .  "WHERE goodsid = {$goodsInfo['id']}");
		$goodsInfo['params'] = $params;
		$goodsInfo['atlas'] = unserialize($goodsInfo['atlas']);
		if(is_array($goodsInfo['atlas'])){
			foreach($goodsInfo['atlas'] as &$value){
				$value = tomedia($value);
			}
		}
		$goodsInfo['hexiao_id'] = unserialize($goodsInfo['hexiao_id']);
		if($goodsInfo['is_hexiao']==3 && $goodsInfo['g_type']==1){
			pdo_update('tg_goods',array('g_type'=>3),array('id'=>$goodsInfo['id']));
			Util::deleteCache('goods', $goodsInfo['id']);
		}
		return $goodsInfo;
	}
	/** 
 	* 获取单条商品数据 
 	* 
 	* @access static
 	* @name getSingleGoods 
 	* @param $where   查询条件 
 	* @param $select  查询参数 
 	* @return array 
 	*/  
	static function getSingleGoodsComment($id){
		global $_W;	
		$comment = Util::getSingelData("*",'tg_comment',array('goodsid'=>$id));
		if($comment) return $comment;
		pdo_insert('tg_comment',array('uniacid'=>$_W['uniacid'],'goodsid'=>$id));
		$comment = Util::getSingelData("*",'tg_comment',array('goodsid'=>$id));
		return $comment;
		//需删除缓存
	}
 	/** 
 	* 判断商品是否可以购买 
 	* 
 	* @access static
 	* @name  initSingleGoods 
 	* @param $goodsInfo  商品数据 
 	* @return $goodsInfo 
 	*/	
 	static function ifCanBuy($id,$openid,$buyNum,$ifGroup){
 		global $_W;	
		$goodsInfo = model_goods::getSingleGoods($id, '*', array('id'=>$id));
		if(empty($goodsInfo)) return array(1,'当前商品不存在'); 
		if($goodsInfo['isshow'] == 2) array(2,'商品已经下架了');
		if($goodsInfo['isshow'] == 3) return array(3,'商品已经售罄了');
		if($goodsInfo['gnum'] < $buyNum) return array(4,'商品库存不足');
		$goodsInfo['one_limit'] = empty($goodsInfo['one_limit'])?1:$goodsInfo['one_limit'];
		if($goodsInfo['one_limit'] < $buyNum && $ifGroup)return array(5,'商品限购，目前您能购买'. $goodsInfo['one_limit'].'件');
		$goodsInfo['op_one_limit'] = empty($goodsInfo['op_one_limit'])?1:$goodsInfo['op_one_limit'];
		if($goodsInfo['op_one_limit'] < $buyNum && !$ifGroup)return  array(6,'商品限购，目前您能购买'. $goodsInfo['op_one_limit'].'件');
		$data = model_order::getMemberOrderNumWithGoods($openid, $id);
		if($goodsInfo['many_limit'])
		if($goodsInfo['many_limit'] && $data[2] >= $goodsInfo['many_limit'])return array(7,'超过限购数量');
		return array(0,'可以购买');
	}		
	/** 
	* 获取店铺 
	* 
	* @access static
	* @name getSingleGoodsStore 
	* @param mixed  参数一的说明 
	* @return array 
	*/  
	static function getSingleGoodsStore($id){
		$goodsInfo = model_goods::getSingleGoods($id, '*', array('id'=>$id));
		if(empty($goodsInfo['hexiao_id']))return FALSE;
		foreach($goodsInfo['hexiao_id'] as$key=>$value){
			if($value)$stores[$key] =  pdo_fetch("select * from".tablename('tg_store')."where id ='{$value}' and uniacid='{$goodsInfo['uniacid']}'");
		}
		return array($stores);
	}
	/** 
	* 获取规格 
	* 
	* @access static
	* @name getSingleGoodsOption 
	* @param $id  商品ID 
	* @return array 
	*/  
	static function getSingleGoodsOption($id){
		//获取规格条目 Start
		$allspecs = pdo_fetchall("select * from " . tablename('tg_spec')." where goodsid=:id order by displayorder asc",array(":id"=>$id));
		foreach ($allspecs as &$s) {
			$s['items'] = pdo_fetchall("select * from " . tablename('tg_spec_item') . " where specid=:specid order by displayorder asc", array(":specid" => $s['id']));
		}
		$options = pdo_fetchall("select * from " . tablename('tg_goods_option') . " where goodsid=:id order by id asc", array(':id' => $id));
		$specs = array();
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
		//获取规格条目 End
			
			//获取价格列表 Start
			$html = '';
			$html .= '<table class="table table-bordered table-condensed">';
			$html .= '<thead>';
			$html .= '<tr class="active">';
			$len = count($specs);
			$newlen = 1; //多少种组合
			$h = array(); //显示表格二维数组
			$rowspans = array(); //每个列的rowspan
			//计算每个列的行数 得到$rowspans和$newlen
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
			//价格列表头部
			$html .= '<th class="info" style="width:130px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">库存</div><div class="input-group"><input type="text" class="form-control option_stock_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_stock\');"></a></span></div></div></th>';
			$html .= '<th class="success" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">拼团价格</div><div class="input-group"><input type="text" class="form-control option_marketprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_marketprice\');"></a></span></div></div></th>';
			$html .= '<th class="warning" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">单买价格</div><div class="input-group"><input type="text" class="form-control option_productprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_productprice\');"></a></span></div></div></th>';
			$html .= '<th class="danger" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">规格货号</div><div class="input-group"><input type="text" class="form-control option_costprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_costprice\');"></a></span></div></div></th>';
			$html .= '</tr></thead>';
			//获得表格二维数组$h
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
			//获得整个价格列表
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
				$hh .= '</tr>';
			}
			$html .= $hh;
			$html .= "</table>";
		}
		//获取价格列表 End
		return array($allspecs,$html,$options,$specs);
	}
	/** 
	* 版本兼容 
	* 
	* @access static
	* @name goodsCompatible 
	* @param $id  商品ID
	* @return array 
	*/  
	static function goodsCompatible($goodsInfo) {
		if($goodsInfo['hexiao_id']){
			if(!is_array(unserialize($goodsInfo['hexiao_id']))){
				$storesids = explode(",", $goodsInfo['hexiao_id']);
				foreach($storesids as$key=>$value){
					if(!$value)unset($storesids[$key]);
				}
				$goodsInfo['hexiao_id'] = serialize($storesids);
				pdo_update('tg_goods',array('hexiao_id'=>$goodsInfo['hexiao_id']),array('id'=>$goodsInfo['id']));
				Util::deleteCache('goods', $goodsInfo['id']);
			}
		}
		if(empty($goodsInfo['atlas'])){
			if(!is_array(unserialize($goodsInfo['atlas']))){
				$listt = pdo_fetchall("SELECT thumb FROM" . tablename('tg_goods_atlas') . "WHERE g_id = '{$goodsInfo['id']}' order by id desc");
				$piclist = array();	
				if (is_array($listt)) {
					foreach ($listt as $p) {
						$piclist[] = $p['thumb'];
					}
				}
				$goodsInfo['atlas'] = serialize($piclist);
				pdo_update('tg_goods',array('atlas'=>$goodsInfo['atlas']),array('id'=>$goodsInfo['id']));
				Util::deleteCache('goods', $goodsInfo['id']);
			}
		}
		return $goodsInfo;
	}
	/** 
	* 更新自定义属性 
	* 
	* @access static
	* @name UpdateParam 
	* @param $id  商品ID
	* @param $param_ids     属性ID数组
	* @param $param_titles  属性名称数组
	* @param $param_values  属性值数组
	* @return array 
	*/  
	static function UpdateParam($id,$param_ids,$param_titles,$param_values,$tag){
		$len = count($param_titles);
		$paramids = array();
		for ($k = 0; $k < $len; $k++) {
			$param_id = "";
			$get_param_id = $param_ids[$k];
			$a = array("title" => $param_titles[$k], "value" => $param_values[$k], "displayorder" => $k, "goodsid" => $id,"tagcontent" => serialize($tag));
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
	}
	/** 
	* 更新规格 
	* 
	* @access static
	* @name UpdateOption 
	* @param $GPC     表单提交值
	* @return array 
	*/  
	static function UpdateOption($id,$_GPC){
		global $_W;
		$spec_ids = $_GPC['spec_id'];
		$spec_titles = $_GPC['spec_title'];
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
			$spec_item_ids = $_GPC["spec_item_id_".$get_spec_id];
			$spec_item_titles = $_GPC["spec_item_title_".$get_spec_id];
			$spec_item_shows = $_GPC["spec_item_show_".$get_spec_id];
			$spec_item_thumbs = $_GPC["spec_item_thumb_".$get_spec_id];
			$spec_item_oldthumbs = $_GPC["spec_item_oldthumb_".$get_spec_id];
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
		$option_idss = $_GPC['option_ids'];
		$option_productprices = $_GPC['option_productprice'];
		$option_marketprices = $_GPC['option_marketprice'];
		$option_costprices = $_GPC['option_costprice'];
		$option_stocks = $_GPC['option_stock'];
		$option_weights = $_GPC['option_weight'];
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
				"stock" => $_GPC['option_stock_' . $ids][0],
				"marketprice" => $_GPC['option_marketprice_' . $ids][0],
				"goodsid" => $id,
				"specs" => $newids
			);
			$totalstocks+=$a['stock'];
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
	}
	/** 
	* 判断邮费 
	* 
	* @access static
	* @name getFreight 
	* @param mixed  参数一的说明 
	* @return array 
	*/  
	static function getFreight($id,$addrid,$openid,$goods,$tuanid){
		$freight=0;
		if($addrid)
			$adress_fee = pdo_fetch("select * from ".tablename('tg_address')."where id = '{$addrid}'");
		else
			$adress_fee = pdo_fetch("select * from ".tablename('tg_address')."where openid = '{$openid}' and status = 1");
		if(($adress_fee['province'] == '' || $adress_fee['city'] == '') && $goods['is_hexiao']!=2  ){
			$adress_fee = '';
		}
		if($goods['is_hexiao']==2) return array(0,$adress_fee);
		if(empty($adress_fee)){
			header("location:".app_url('address/createadd',array('tuanid'=>$tuanid)));
		}
		$p = mb_substr($adress_fee['province'], 0, 2,'utf-8');
		$c = mb_substr($adress_fee['city'], 0, 2,'utf-8');
		$d = mb_substr($adress_fee['county'], 0, 2,'utf-8');
		
		if($p == '上海' && $c != '上海'){
			$d = $c;
			$c = $p;
		}
		$yes = 0;
		if($goods['yunfei_id']){	
			$tem_status = pdo_fetchcolumn("select displayorder from".tablename('tg_delivery_template')."where id = {$goods['yunfei_id']}");
			$district_fee = pdo_fetch("select first_fee from " . tablename("tg_delivery_price") . " WHERE  province like '%{$p}%' and  city like '%{$c}%' and district like '%{$d}%' and template_id = {$goods['yunfei_id']} ");
			$freight = $district_fee['first_fee'];
			if(empty($freight)){
				$allCitys = pdo_fetchall("select * from".tablename('tg_delivery_price')."where template_id = {$goods['yunfei_id']} and  city='' and district='' "); //整个省都有邮费
				$allDistricts = pdo_fetchall("select * from".tablename('tg_delivery_price')."where template_id = {$goods['yunfei_id']} and city!='' and district='' "); //整个市都有邮费
				if(!empty($allCitys)){
					foreach($allCitys as $v1){
						$v1['province']=mb_substr($v1['province'], 0, 2,'utf-8');
						if($v1['province']==$p){
							$yes = 1; 
							$freight = $v1['first_fee'];
						}
					}
				}
				if(!empty($allDistricts)){
					foreach($allDistricts as $v2){
						$v2['province']=mb_substr($v2['province'], 0, 2,'utf-8');
						$v2['city']=mb_substr($v2['city'], 0, 2,'utf-8');
						if($v2['province']==$p && $v2['city']==$c){
							$yes = 1; 
							$freight = $v2['first_fee'];
						}
					}
				}
			}else{
				$yes = 1; 
			}
			if(empty($yes) && $tem_status == 1){
				wl_message('您不在配送区域内，请重新选择地址',app_url('address/createadd'),'success');
			}
		}
		return array($freight,$adress_fee);
	}
	/** 
	* 更新商品营销 
	* 
	* @access static
	* @name updateMarketing 
	* @param  $enough //满多少元
			  $give //减多少元
			  $free_freight  //包邮条件
			  $giftids  //赠品
			  $deduction //抵扣
	* @return array 
	*/  
	static function updateMarketing($enough,$give,$free_freight,$giftids,$deduction,$id){
		global $_W;
		$marketing1 = pdo_fetch("select type from".tablename("tg_marketing")."where fk_goodsid={$id} and type=1");
		$marketing2 = pdo_fetch("select type from".tablename("tg_marketing")."where fk_goodsid={$id} and type=2");
		$marketing3 = pdo_fetch("select type from".tablename("tg_marketing")."where fk_goodsid={$id} and type=3");
		$marketing4 = pdo_fetch("select type from".tablename("tg_marketing")."where fk_goodsid={$id} and type=4");
		$c1 = count($enough);$c2 = count($give); 	//满减
		if($c1==$c2){
			for($i=0;$i<$c1;$i++){
				if(!empty($enough[$i]) && !empty($give[$i])){
					$enoughv11[$i]['enough'] = $enough[$i];
					$enoughv11[$i]['give'] = $give[$i];
				}
			}
		}
		$v11 = !empty($enoughv11)?serialize($enoughv11):''; // 满额立减
		if($marketing1){
			pdo_update("tg_marketing",array('value'=>$v11),array('fk_goodsid'=>$id,'type'=>1));
		}else{
			pdo_insert("tg_marketing",array('fk_goodsid'=>$id,'uniacid'=>$_W['uniacid'],'type'=>1,'value'=>$v11));
		}
		$v22 = serialize($free_freight); //包邮
		if(!empty($free_freight)){
			if($marketing2){
				pdo_update("tg_marketing",array('value'=>$v22),array('fk_goodsid'=>$id,'type'=>2));
			}else{
				pdo_insert("tg_marketing",array('fk_goodsid'=>$id,'uniacid'=>$_W['uniacid'],'type'=>2,'value'=>$v22));
			}
		}
		$v33 = serialize($deduction); //抵扣
		if(!empty($deduction)){
			if($marketing3){
				pdo_update("tg_marketing",array('value'=>$v33),array('fk_goodsid'=>$id,'type'=>3));
			}else{
				pdo_insert("tg_marketing",array('fk_goodsid'=>$id,'uniacid'=>$_W['uniacid'],'type'=>3,'value'=>$v33));
			}
		}
		$v44 = serialize($giftids); //赠品
		if(!empty($giftids)){
			if($marketing4){
				pdo_update("tg_marketing",array('value'=>$v44),array('fk_goodsid'=>$id,'type'=>4));
			}else{
				pdo_insert("tg_marketing",array('fk_goodsid'=>$id,'uniacid'=>$_W['uniacid'],'type'=>4,'value'=>$v44));
			}
		}
	}
	/** 
	* 获取商品营销 
	* 
	* @access static
	* @name getMarketing 
	* @param  $id
	* @return array 
	*/  
	static function getMarketing($id){
		global $_W;
		$marketing1 = pdo_fetch("select value from".tablename("tg_marketing")."where fk_goodsid={$id} and type=1");
		$marketing2 = pdo_fetch("select value from".tablename("tg_marketing")."where fk_goodsid={$id} and type=2");
		$marketing3 = pdo_fetch("select value from".tablename("tg_marketing")."where fk_goodsid={$id} and type=3");
		$marketing4 = pdo_fetch("select value from".tablename("tg_marketing")."where fk_goodsid={$id} and type=4");
		$v1 = !empty($marketing1['value'])?unserialize($marketing1['value']):array(); //满减
		$v2 = !empty($marketing2['value'])?unserialize($marketing2['value']):array(); //包邮
		$v3 = !empty($marketing3['value'])?unserialize($marketing3['value']):array(); //抵扣
		$v4 = !empty($marketing4['value'])?unserialize($marketing4['value']):array();//赠品
		if($v4){
			foreach($v4 as $key=>$value){
				$gifts[] = pdo_get("tg_gift",array('id'=>$value),array('id','name'));
			}
		}
		return array($v1,$v2,$v3,$gifts);
	}
	/** 
	* 获取商品营销 
	* 
	* @access static
	* @name getMarketing 
	* @param  $id
	* @return array 
	*/  
	static function get_item_taobao($url = '')
	{
		global $_W;
		preg_match('/id\\=(\\d+)/i', $url, $matches);
		if (isset($matches[1])) {
			$itemid = $matches[1];
		}
		if(empty($itemid)){
			$itemid = $url;
		}
		$url = self::get_info_url($itemid);
		load()->func('communication');
		$response = ihttp_get($url);
		if (!isset($response['content'])) {
			return array('result' => '0', 'error' => '未从淘宝获取到商品信息!');
		}

		$content = $response['content'];

		if (strexists($response['content'], 'ERRCODE_QUERY_DETAIL_FAIL')) {
			return array('result' => '0', 'error' => '宝贝不存在!');
		}

		$arr = json_decode($content, true);
		$data = $arr['data'];
		$itemInfoModel = $data['itemInfoModel'];
		$item = array();
		$item['itemId'] = $itemInfoModel['itemId'];
		$item['title'] = $itemInfoModel['title'];
		$item['pics'] = $itemInfoModel['picsPath'];
		$params = array();

		if (isset($data['props'])) {
			$props = $data['props'];

			foreach ($props as $pp) {
				$params[] = array('title' => $pp['name'], 'value' => $pp['value']);
			}
		}

		$item['params'] = $params;
		$specs = array();
		$options = array();

		if (isset($data['skuModel'])) {
			$skuModel = $data['skuModel'];

			if (isset($skuModel['skuProps'])) {}

			if (isset($skuModel['ppathIdmap'])) {
				$ppathIdmap = $skuModel['ppathIdmap'];

				foreach ($ppathIdmap as $key => $skuId) {
					$option_specs = array();
					$m = explode(';', $key);

					foreach ($m as $v) {
						$mm = explode(':', $v);
						$option_specs[] = array('propId' => $mm[0], 'valueId' => $mm[1]);
					}

					$options[] = array('option_specs' => $option_specs, 'skuId' => $skuId, 'stock' => 0, 'marketprice' => 0, 'specs' => '');
				}
			}
		}

		$item['specs'] = $specs;
		$stack = $data['apiStack'][0]['value'];
		$value = json_decode($stack, true);
		$item1 = array();
		$data1 = $value['data'];
		$itemInfoModel1 = $data1['itemInfoModel'];
		$item['total'] = $itemInfoModel1['quantity'];
		$item['sales'] = $itemInfoModel1['totalSoldQuantity'];
		
		if (isset($data1['skuModel'])) {
			$skuModel1 = $data1['skuModel'];

			if (isset($skuModel1['skus'])) {
				$skus = $skuModel1['skus'];

				foreach ($skus as $key => $val) {
					$sku_id = $key;

					foreach ($options as &$o) {
						if ($o['skuId'] == $sku_id) {
							$o['stock'] = $val['quantity'];

							foreach ($val['priceUnits'] as $p) {
								$o['marketprice'] = $p['price'];
							}

							$titles = array();

							foreach ($o['option_specs'] as $osp) {
								foreach ($specs as $sp) {
									if ($sp['propId'] == $osp['propId']) {
										foreach ($sp['items'] as $spitem) {
											if ($spitem['valueId'] == $osp['valueId']) {
												$titles[] = $spitem['title'];
											}
										}
									}
								}
							}

							$o['title'] = $titles;
						}
					}

					unset($o);
				}
			}
			else {
				$mprice = 0;

				foreach ($itemInfoModel1['priceUnits'] as $p) {
					$mprice = $p['price'];
				}

				$item['marketprice'] = $mprice;
			}
		}
		else {
			$mprice = 0;

			foreach ($itemInfoModel1['priceUnits'] as $p) {
				$mprice = $p['price'];
			}

			$item['marketprice'] = $mprice;
		}

		$item['options'] = $options;
//		$item['content'] = array();
//		$url = self::get_detail_url($itemid);
//		load()->func('communication');
//		$response = ihttp_get($url);
//		$item['content'] = $response;
		return $item;
	}
	static function get_info_url($itemid)
	{
		return 'http://hws.m.taobao.com/cache/wdetail/5.0/?id=' . $itemid;
	}

	static function get_detail_url($itemid)
	{
		return 'http://hws.m.taobao.com/cache/wdesc/5.0/?id=' . $itemid;
	}
}