<?php 
	global $_W,$_GPC;
	$_GPC['do'] = 'custom';
	$_GPC['op'] = empty($_GPC['op'])? 'set' : $_GPC['op'];


	// 添加奖品
	if( checkSubmit('addprize') ){
		$_GPC = Util::trimWithArray($_GPC);
		
		$data = array(
			'uniacid' => $_W['uniacid'],
			'name' => $_GPC['name'],
			'type' => intval( $_GPC['type'] ),
			'min' => sprintf('%2.f',$_GPC['min']),
			'max' => sprintf('%2.f',$_GPC['max']),
			'stock' => intval( $_GPC['stock'] ),
			'need' => intval( $_GPC['need'] ),
			'maxchange' => intval( $_GPC['maxchange'] ),
			'isminus' => intval( $_GPC['isminus'] ),
			'pic' => $_GPC['pic'],
			'actid' => $_GPC['id'],
			'isdetail' => intval( $_GPC['isdetail'] ),
			'detail' => $_GPC['detail'],
			'tips' => $_GPC['tips'],
			'number' => intval( $_GPC['number'] ),

		);

		if(intval($_GPC['prizeid']) > 0){
			$id = intval( $_GPC['prizeid'] );
			$res = pdo_update('zofui_posterhelp_prize',$data,array('id'=>$id,'uniacid'=>$_W['uniacid']));
			$url = Util::webUrl('custom',array('op'=>'set','id'=>$_GPC['id']));
		}else{
			$res = pdo_insert('zofui_posterhelp_prize',$data);
			$url = 'referer';
		}

		Util::deleteCache('allprize',$_GPC['id'],$_GPC['id']); // 删除缓存
		message('操作成功',$url,'success');

	}

	
	//批量删除奖品
	elseif(checksubmit('deleteallonlinepeize')){
				
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_posterhelp_prize');

		Util::deleteCache('allprize',$_GPC['id'],$_GPC['id']);

		message('操作完成,成功删除'.$res[0].'项，失败'.$res[1].'项',referer(),'success');
	}


	
	// 删除奖品
	elseif( $_GPC['op'] == 'deleteprize' ){

		$res = WebCommon::deleteSingleData($_GPC['prizeid'],'zofui_posterhelp_prize');

		Util::deleteCache('allprize',$_GPC['id'],$_GPC['id']);

		if($res) message('删除成功',referer(),'success');
	}

	elseif( $_GPC['op'] == 'set' ){

		$info = model_act::getAct( $_GPC['id'] );
		$info['rangetime']['start'] = date('Y-m-d H:i:s',$info['start']);
		$info['rangetime']['end'] = date('Y-m-d H:i:s',$info['end']);
		$info['prizetime']['start'] = date('Y-m-d H:i:s',$info['prizestart']);
		$info['prizetime']['end'] = date('Y-m-d H:i:s',$info['prizeend']);
		
		if( empty( $info ) ) message('活动不存在');

		$allprize = model_prize::getAllPrize( $_GPC['id'] );

		$poster = pdo_get('zofui_posterhelp_poster',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['id'],'type' => 1));
		if( !empty( $poster ) ) $poster['params'] = iunserializer( $poster['params'] );

		$pimg = model_poster::getPoster( array('id'=>0,'actid'=>$_GPC['id']) );
		
		$indextemp = pdo_get('zofui_posterhelp_poster',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['id'],'type' => 2));
		if( !empty( $indextemp ) ) $indextemp['params'] = iunserializer( $indextemp['params'] );
		$prizetemp = pdo_get('zofui_posterhelp_poster',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['id'],'type' => 3));
		if( !empty( $prizetemp ) ) $prizetemp['params'] = iunserializer( $prizetemp['params'] );



	}
	elseif( $_GPC['op'] == 'editprize' ){

		$prize = pdo_get('zofui_posterhelp_prize',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['id'],'id'=>$_GPC['prizeid']));

	}	

	include $this->template('web/custom');