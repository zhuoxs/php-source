<?php
	$ops = array('display');
	$op = in_array($op, $ops) ? $op : 'display';
	if($op=='display'){
		if($_GPC['type']=='salenum' || empty($_GPC['type'])){
			$where = array();
			if(TG_MERCHANTID)$where['merchantid'] = $_SESSION['role_id'];
			$where['#isshow#'] = '(1,2,3)';
			$dataData = model_goods::getNumGoods('*', $where, 'salenum desc', 0, 10, 1);
			$data['list'] = $dataData[0];
			foreach($data['list'] as$key=>&$value){
				$labels[] = cutstr($value['gname'], 7, true);
				$salenum[] = $value['salenum'];
			}
		}
		$dataData = model_goods::getNumGoods('*', $where, 'salenum desc', 0, 10, 1);
		$data1['list'] = $dataData[0];
		$dataData = model_goods::getNumGoods('*', $where, 'pv desc', 0, 10, 1);
		$data2['list'] = $dataData[0];
		$dataData = model_goods::getNumGoods('*', $where, 'uv desc', 0, 10, 1);
		$data3['list'] = $dataData[0];
	//	$dataData = model_goods::getNumGoods('id,gname,gimg,salenum,pv,uv', $where, 'id desc',0,0,0);
		if(TG_MERCHANTID){
			$dataData = pdo_fetchall("SELECT id,gname,gimg,salenum,pv,uv FROM ".tablename('tg_goods')."WHERE uniacid = {$_W['uniacid']} AND merchantid = {$_SESSION['role_id']} AND isshow IN (1,2,3) ORDER BY id DESC");
		}else {
			$dataData = pdo_fetchall("SELECT id,gname,gimg,salenum,pv,uv FROM ".tablename('tg_goods')."WHERE uniacid = {$_W['uniacid']} AND isshow IN (1,2,3) ORDER BY id DESC");
		}
		$data4['list'] = $dataData;
		foreach($data1['list'] as$key=>&$value){
			$init = 0;
			$orderData = model_order::getNumOrder('*', array('g_id'=>$value['id'],'#status#'=>'(1,2,3,4)'), 'id desc', 0, 0, 0);
			foreach($orderData[0]?$orderData[0]:array() as $v){
				$init += $v['price'];
			}
			$value['money'] = sprintf("%.2f",$init);
		}
		
		foreach($data2['list'] as$key=>&$value){
			$init = 0;
			$orderData = model_order::getNumOrder('price', array('g_id'=>$value['id'],'#status#'=>'(1,2,3,4)'), 'id desc', 0, 0, 0);
			foreach($orderData[0]?$orderData[0]:array() as $v){
				$init += $v['price'];
			}
			$value['money'] = sprintf("%.2f",$init);
		}
		foreach($data3['list'] as$key=>&$value){
			$init = 0;
			$orderData = model_order::getNumOrder('price', array('g_id'=>$value['id'],'#status#'=>'(1,2,3,4)'), 'id desc', 0, 0, 0);
			foreach($orderData[0]?$orderData[0]:array() as $v){
				$init += $v['price'];
			}
			$value['money'] = sprintf("%.2f",$init);
		}
		foreach($data4['list'] as$key=>&$value){
			$init = 0;
			$orderData = model_order::getNumOrder('price', array('g_id'=>$value['id'],'#status#'=>'(1,2,3,4)'), 'id desc', 0, 0, 0);
			foreach($orderData[0]?$orderData[0]:array() as $v){
				$init += $v['price'];
			}
			$value['money'] = sprintf("%.2f",$init);
		}
		$money = $data4['list'];
		$flag=array();
		foreach($money as $arr2){
		    $flag[]=$arr2["money"];
		    }
		array_multisort($flag,SORT_DESC,$money);
	//	wl_debug($money);
		include wl_template('data/goods_data');
	}
	