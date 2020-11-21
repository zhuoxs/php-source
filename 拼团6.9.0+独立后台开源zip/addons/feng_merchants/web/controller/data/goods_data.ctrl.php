<?php
	$ops = array('display');
	$op_names = array('商品统计');
	foreach($ops as$key=>$value){
		permissions('do', 'ac', 'op', 'data', 'goods_data', $ops[$key], '数据中心', '商品统计', $op_names[$key]);
	}
	$op = in_array($op, $ops) ? $op : 'display';
	if($op=='display'){
		wl_load()->model('goods');
		wl_load()->model('order');
		$data1 = goods_get_list(array('ishows'=>'1,2,3','orderby'=>' order by salenum desc limit 0,9 ','merchantid'=>MERCHANTID));
		$data2 = goods_get_list(array('ishows'=>' 1,2,3 ','orderby'=>' order by pv desc limit 0,9 ','merchantid'=>MERCHANTID));
		$data3 = goods_get_list(array('ishows'=>' 1,2,3 ','orderby'=>' order by uv desc limit 0,9 ','merchantid'=>MERCHANTID));
		$labels = array();
		$labels2 = array();
		$labels3 = array();
		$salenum =array();
		$pv = array();
		$uv = array();
		foreach($data1['list'] as$key=>&$value){
			$labels[] = cutstr($value['gname'], 7, true);
			$salenum[] = $value['salenum'];
		}
		
		foreach($data2['list'] as$key=>&$value){
			$labels2[] = cutstr($value['gname'], 7, true);
			$pv[] = $value['pv'];
		}
		foreach($data3['list'] as$key=>&$value){
			$labels3[] = cutstr($value['gname'], 7, true);
			$uv[] = $value['uv'];
		}
		include wl_template('data/goods_data');
	}
	