<?php 
	global $_W,$_GPC;
	$_GPC['do'] = 'act';
	$_GPC['op'] = empty($_GPC['op'])? 'list' : $_GPC['op'];
	

	/*require POSETERH_ROOT.'/receiver.php';
	$a =  new Zofui_posterhelpModuleReceiver();
	$a->modulename = MODULE;
	$a->message = array(
		'content' => '2222',
		'event' => 'subscribe',
		'from' => 'cccab23',
	);
	$res = $a->receive();
	var_dump( $res );*/

	/*$act = pdo_get('zofui_posterhelp_act');
	model_help::helpSuccess($act,$user,'cccab23');*/

	// 创建新活动
	if( checkSubmit('create') || checkSubmit('save') ){
		$_GPC = Util::trimWithArray($_GPC);
		
		$data = array(
			'uniacid' => $_W['uniacid'],
			'name' => $_GPC['name'],
			'thumb' => $_GPC['thumb'],
			'postkey' => $_GPC['postkey'],
			'free' => intval( $_GPC['free'] ),
			'maxtimes' => intval( $_GPC['maxtimes'] ),
			'min' => intval( $_GPC['min'] ),
			'max' => intval( $_GPC['max'] ),
			'helparr' => intval( $_GPC['helparr'] ),

			'creditname' => $_GPC['creditname'],
			'arealimit' => intval( $_GPC['arealimit'] ),
			'sendtype' => $_GPC['sendtype'],
			'isform' => $_GPC['isform'],
			'content' => $_GPC['content'],
			'shoptel' => $_GPC['shoptel'],
			'shopaddress' => $_GPC['shopaddress'],
			'gametime' => $_GPC['gametime'],
			'maxchange' => intval( $_GPC['maxchange'] ),
			'status' => intval( $_GPC['status'] ),
			'isshare' => intval( $_GPC['isshare'] ),
			'sharetitle' => $_GPC['sharetitle'],
			'sharedesc' => $_GPC['sharedesc'],
			'shareimg' => $_GPC['shareimg'],
			'isrank' => $_GPC['isrank'],
			'isminus' => intval( $_GPC['isminus'] ),
			'isverifyh' => intval( $_GPC['isverifyh'] ),
			'przieslider' => iserializer( $_GPC['przieslider'] ),

			'islink' => intval( $_GPC['islink'] ),
			'linkleast' => intval( $_GPC['linkleast'] ),
			'linkmess' => $_GPC['linkmess'],
			'linklink' => $_GPC['linklink'],
			'islinkmess' => $_GPC['islinkmess'],

			'prizelim' => intval( $_GPC['prizelim'] ),
			'prizestart' => strtotime( $_GPC['prizetime']['start'] ),
			'prizeend' => strtotime( $_GPC['prizetime']['end'] ),
			'indextype' => intval( $_GPC['indextype'] ),
			'prizerule' => $_GPC['prizerule'],
			'jftype' => intval( $_GPC['jftype'] ),
		);

		$data['start'] = strtotime( $_GPC['rangetime']['start'] );
		$data['end'] = strtotime( $_GPC['rangetime']['end'] );
		
		$data['area'] = iserializer( array('province'=>$_GPC['province'],'city'=>$_GPC['city'],'country'=>$_GPC['county']) );
		
		$data['status'] = 0;
		if( checkSubmit('save') ) $data['status'] = 1;

		if(intval($_GPC['id']) > 0){
			$id = intval( $_GPC['id'] );
			unset( $data['time'] );
			$res = pdo_update('zofui_posterhelp_act',$data,array('id'=>$id,'uniacid'=>$_W['uniacid']));
			$url = 'referer';
		}else{
			$res = pdo_insert('zofui_posterhelp_act',$data);
			$id = pdo_insertid();

			//  插入海报
			$poster = array(
				'uniacid' => $_W['uniacid'],
				'params' => 'a:3:{i:0;a:5:{s:2:"id";s:14:"i1492439996705";s:4:"name";s:7:"headimg";s:5:"title";s:6:"头像";s:6:"isedit";i:0;s:6:"params";a:5:{s:3:"img";s:56:"./../addons/zofui_posterhelp/public/images/default_head.jpg";s:5:"width";i:65;s:6:"height";i:63;s:4:"left";i:118;s:3:"top";i:114;}}i:1;a:5:{s:2:"id";s:14:"i1492440003928";s:4:"name";s:4:"nick";s:5:"title";s:6:"昵称";s:6:"isedit";i:1;s:6:"params";a:5:{s:3:"txt";s:12:"会员昵称";s:4:"left";i:86;s:3:"top";i:371;s:5:"color";s:7:"#ffffff";s:8:"fontsize";i:22;}}i:2;a:4:{s:2:"id";s:14:"i1492440011952";s:4:"name";s:6:"qrcode";s:5:"title";s:9:"二维码";s:6:"params";a:5:{s:3:"img";s:50:"./../addons/zofui_posterhelp/public/images/qrcode.png";s:5:"width";i:85;s:6:"height";i:86;s:4:"left";i:1;s:3:"top";i:401;}}}',
				'bgimg' => POSETERH_URL.'public/images/bg1.jpg',
				'type' => 1,
				'actid' => $id,
			);
			if( $_W['account']['level'] == 3 ){
				$poster['bgimg'] = POSETERH_URL.'public/images/bg2.jpg';
				$poster['params'] = 'a:4:{i:0;a:5:{s:2:"id";s:14:"i1492439996705";s:4:"name";s:7:"headimg";s:5:"title";s:6:"头像";s:6:"isedit";i:0;s:6:"params";a:5:{s:3:"img";s:56:"./../addons/zofui_posterhelp/public/images/default_head.jpg";s:5:"width";i:65;s:6:"height";i:63;s:4:"left";i:118;s:3:"top";i:114;}}i:1;a:5:{s:2:"id";s:14:"i1492440003928";s:4:"name";s:4:"nick";s:5:"title";s:6:"昵称";s:6:"isedit";i:1;s:6:"params";a:5:{s:3:"txt";s:12:"会员昵称";s:4:"left";i:86;s:3:"top";i:371;s:5:"color";s:7:"#ffffff";s:8:"fontsize";i:22;}}i:2;a:4:{s:2:"id";s:14:"i1492440011952";s:4:"name";s:6:"qrcode";s:5:"title";s:9:"二维码";s:6:"params";a:5:{s:3:"img";s:50:"./../addons/zofui_posterhelp/public/images/qrcode.png";s:5:"width";i:85;s:6:"height";i:86;s:4:"left";i:1;s:3:"top";i:401;}}i:3;a:5:{s:2:"id";s:14:"i1492441165345";s:4:"name";s:4:"code";s:5:"title";s:9:"邀请码";s:6:"isedit";i:1;s:6:"params";a:5:{s:3:"txt";s:9:"邀请码";s:4:"left";i:206;s:3:"top";i:427;s:5:"color";s:7:"#ffffff";s:8:"fontsize";i:23;}}}';
			}
			pdo_insert('zofui_posterhelp_poster',$poster);
			$url = Util::webUrl('act',array('op'=>'list'));
		}

		Util::deleteCache('act',$id,$id); // 删除缓存
		message('操作成功',$url,'success');

	}
 	

	//批量删除活动
	elseif(checksubmit('deleteall')){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_posterhelp_act');
		message('操作完成,成功删除'.$res[0].'项，失败'.$res[1].'项',referer(),'success');
	}

	// 编辑活动
	elseif($_GPC['op'] == 'edit'){
		$info = model_act::getAct( $_GPC['id'] );
		
		$info['rangetime']['start'] = date('Y-m-d H:i:s',$info['start']);
		$info['rangetime']['end'] = date('Y-m-d H:i:s',$info['end']);

		$info['prizetime']['start'] = date('Y-m-d H:i:s',$info['prizestart']);
		$info['prizetime']['end'] = date('Y-m-d H:i:s',$info['prizeend']);

		
	}
	
	// 活动列表
	elseif($_GPC['op'] == 'list'){
		//$topbar = topbal::goodList();

		$where = array('uniacid'=>$_W['uniacid']);
		$order='`id` DESC';
		
		$info = Util::getAllDataInSingleTable('zofui_posterhelp_act',$where,$_GPC['page'],10,$order,false,true,' id,name,start,end,joined,isform,status ');
		$list = $info[0];
		$pager = $info[1];
		if( !empty( $list ) ){
			foreach ($list as $k => &$v) {
				$v['joined'] = Util::countDataNumber('zofui_posterhelp_user',array('uniacid'=>$_W['uniacid'],'actid'=>$v['id']));
			}
		}
	}


	// 删除活动
	elseif($_GPC['op'] == 'delete'){

		$res = WebCommon::deleteSingleData($_GPC['id'],'zofui_posterhelp_act');
		if($res) message('删除成功',referer(),'success');
	}	

	include $this->template('web/act');