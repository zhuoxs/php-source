<?php 
	global $_W,$_GPC;
	set_time_limit(0); // 解除时间限制

	if($_GPC['op'] == 'deletecache'){ 
		if( $_GPC['type']  == 'poster'){
			$res = Util::rmdirs( POSETERH_ROOT.'poster/'.$_W['uniacid'].'/' );
			//$qr = POSETERH_ROOT.'poster/'.$_W['uniacid'].'tempqrcode.jpg';
			if( file_exists( $qr ) ) @unlink( $qr );

			if($res) die('1'); die('2');
		}else{
			$res = cache_clean();
			if($res) die('1'); die('2');
		}

	}


	elseif($_GPC['op'] == 'editvalue'){ //修改
		$id = intval($_GPC['id']);
	
		if($_GPC['name'] == 'onprizenum'){
			pdo_update('zofui_subticket_prize',array('num'=>$_GPC['value']),array('id'=>$id,'uniacid'=>$_W['uniacid']));
			
			$prize = pdo_get('zofui_subticket_prize',array('uniacid'=>$_W['uniacid'],'id'=>$id));
			Util::deleteCache('allprize',$prize['actid']);
			
		}elseif($_GPC['name'] == 'onprizerand'){
			pdo_update('zofui_subticket_prize',array('rand'=>intval( $_GPC['value'] )),array('id'=>$id,'uniacid'=>$_W['uniacid']));
			$prize = pdo_get('zofui_subticket_prize',array('uniacid'=>$_W['uniacid'],'id'=>$id));
			Util::deleteCache('allprize',$prize['actid']);
		}

	}

	elseif( $_GPC['op'] == 'savatemp'){

		$id = intval( $_GPC['actid'] );
		if( $id <= 0 ) Util::echoResult(201,'先选择活动再设计');
		if( empty( $_GPC['data'] ) ) Util::echoResult(201,'先添加一些元素再提交');

		$params = htmlspecialchars_decode($_GPC['data']);
		$params = json_decode($params,true);

		$data = array(
			'uniacid' => $_W['uniacid'],
			'actid' => $id,
			'params' => iserializer( $params ),
			'bgimg' => $_GPC['bgimg'],
			'type' => $_GPC['type'],
		);

		$poster = pdo_get('zofui_posterhelp_poster',array('uniacid'=>$_W['uniacid'],'actid'=>$id,'type'=>$_GPC['type']));
		if( empty( $poster ) ){
			$res = pdo_insert('zofui_posterhelp_poster',$data);

		}else{
			$res = pdo_update('zofui_posterhelp_poster',$data,array('id'=>$poster['id'],'uniacid'=>$_W['uniacid']));
		}
		if( $res ){
			if( $_GPC['type'] == 1 ) model_poster::deletePoster( $id );
			Util::echoResult(200,'已保存');
		} 
		Util::echoResult(201,'保存失败');

	}

	// 装修页面
	elseif( $_GPC['op'] == 'savapagetemp'){

		$id = intval( $_GPC['actid'] );

		$data = array(
			'uniacid' => $_W['uniacid'],
			'actid' => $id,
		);
		$data['type'] = $_GPC['type'] == 1 ? 2 : 3;

		if( $data['type'] == 2 ){
			$data['params'] = iserializer( $_GPC['index'] );
		}else{
			$data['params'] = iserializer( $_GPC['prize'] );
		}

		$temp = pdo_get('zofui_posterhelp_poster',array('uniacid'=>$_W['uniacid'],'actid'=>$id,'type'=>$data['type']));
		if( empty( $temp ) ){
			$res = pdo_insert('zofui_posterhelp_poster',$data);

		}else{
			$res = pdo_update('zofui_posterhelp_poster',$data,array('id'=>$temp['id']));
		}

		if( $res ){
			Util::echoResult(200,'已保存');
		} 
		Util::echoResult(201,'保存失败,可能是数据没有变动的原因');

	}




	
	elseif ($_GPC['op'] == 'findadmin') {
		
		$uniacid = $_W['uniacid'];

		$nickname = $_GPC['nick'];
		$sql = " SELECT * FROM ".tablename('mc_mapping_fans')." WHERE uniacid = ".$uniacid." AND nickname LIKE '%".$nickname."%' ORDER BY rand() ";
		$user = pdo_fetch($sql);
		
		if(empty($user)){
			Util::echoResult(201,'没有找到，减少昵称两边的字符试下');
		}else{
			$tag = iunserializer( base64_decode( $user['tag'] ) );
			$admin['headimgurl'] = $tag['headimgurl'];
			$admin['nick'] = $user['nickname'];
			$admin['openid'] = $user['openid'];
			
			Util::echoResult(200,'好',$admin);
		}
		
		
	}

	elseif($_GPC['op'] == 'checkqueue'){ //检查计划任务
		

		$draw = Util::getCache('draw','status');

		if( empty( $draw ) ){
			$res['draw']['status'] = 201;
		}elseif( $draw == 1 ){
			$res['draw']['status'] = 200;
		}else{
			$res['draw']['status'] = 202;
			$res['draw']['res'] = $draw;
		}

		Util::echoResult(200,'好',$res);
	}


	// 修改地址
	elseif($_GPC['op'] == 'editaddress'){

		$logid = intval($_GPC['logid']);
		$loginfo = pdo_get('zofui_posterhelp_geted',array('uniacid'=>$_W['uniacid'],'id'=>$logid));

		$address = array('getname'=>$_GPC['name'],'gettel'=>$_GPC['tel'],'address'=>$_GPC['address']);

		$res = pdo_update('zofui_posterhelp_geted',$address,array('id'=>$logid));
		if($res) die('1');

	}

	elseif ($_GPC['op'] == 'editexpress') {
		
		$logid = intval($_GPC['logid']);
		$loginfo = pdo_get('zofui_posterhelp_geted',array('uniacid'=>$_W['uniacid'],'id'=>$logid));

		$res = pdo_update('zofui_posterhelp_geted',array('expressname'=>$_GPC['name'],'expressnumber'=>$_GPC['number'],'status'=>1),array('id'=>$logid));
		if($res){
			$prize = pdo_get('zofui_posterhelp_prize',array('uniacid'=>$_W['uniacid'],'id'=>$loginfo['prizeid']));
			Message::sendPrize($loginfo['openid'],$prize['name'],$_GPC['name'],$_GPC['number'],$prize['actid']);
			die('1');
		} 

	}

	// editmoney
	elseif ($_GPC['op'] == 'editmoney') {

		$userid = intval($_GPC['uid']);
		$money = intval($_GPC['money']);
		
		$userinfo = pdo_get('zofui_posterhelp_user',array('uniacid'=>$_W['uniacid'],'id'=>$userid));
		if($money == 0 || empty($userinfo)) {
			Util::echoResult(201,'积分不能等于0,会员不存在');
		}
		
		/*if( $money < 0 && $userinfo['credit'] < -$money ) {
			Util::echoResult(201,'会员积分不够，请修改数值');
		}*/
		$act = pdo_get('zofui_posterhelp_act',array('id'=>$userinfo['actid']));
		if( empty($act['jftype']) ){
			$res = Util::addOrMinusOrUpdateData('zofui_posterhelp_user',array('credit'=>$money),$userid);
		}elseif( $act['jftype'] == 1 ){
			$res = model_user::updateUserCredit($userinfo['openid'],$money,1,'助力海报');
		}
		
		//$res = Util::addOrMinusOrUpdateData('zofui_posterhelp_user',array('credit'=>$money),$userid);
		if($res) {
			Util::deleteCache('u',$userinfo['openid'],$userinfo['actid']);
			Util::echoResult(200,'修改成功');
		}
		Util::echoResult(201,'修改失败');
	}

	// 拉黑
	elseif ($_GPC['op'] == 'edituser') {

		$userid = intval($_GPC['id']);
		$type = intval($_GPC['type']);
		if( !in_array($type, array(0,1)) ) die('2');
		$userinfo = pdo_get('zofui_posterhelp_user',array('uniacid'=>$_W['uniacid'],'id'=>$userid));
		if(empty($userinfo)) die('2');

		$res = pdo_update('zofui_posterhelp_user',array('status'=>$type),array('uniacid'=>$_W['uniacid'],'id'=>$userid));
		if($res) {
			Util::deleteCache('u',$userinfo['openid'],$userinfo['actid']);
			die('1');
		}
		
	}

	//
	elseif ($_GPC['op'] == 'checkkey') {

		
		$sql = 'SELECT `rid` FROM ' . tablename('rule_keyword') . " WHERE `uniacid` = :uniacid  AND `content` = :content";
		$result = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':content' => $_GPC['key']));
		
		if( empty( $result ) ) Util::echoResult(200,'好');
		Util::echoResult(201,'此关键词已存在，请换一个');
	
	}elseif( $_GPC['op'] == 'testpost' ){

		$act = model_act::getAct( $_GPC['id'] );
		if( empty( $act ) ) Util::echoResult(201,'活动不存在');
		if( empty( $_GPC['nick'] ) ) Util::echoResult(201,'填写昵称');
		$user = pdo_get('mc_mapping_fans',array('nickname'=>$_GPC['nick'],'uniacid'=>$_W['uniacid']));	
				
		if( empty( $user ) ) Util::echoResult(201,'没找到会员');

		$poster = pdo_get('zofui_posterhelp_poster',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['id'],'type' => 1));
		if( empty( $poster ) ) Util::echoResult(201,'还没设计海报，请点击设计海报设计海报');

		$img = model_poster::getPoster( array('id'=>0,'actid'=>$act['id']) );
		if( !$img ) Util::echoResult(201,'生成海报失败');

		$token = Message::getAccessToken();

        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $token . "&type=image";
        $post = array('media' => '@'.$img['dir']);
        load()->func('communication');
        $ret = ihttp_request($url, $post);
        $content = @json_decode($ret['content'], true);

        if( !$content['media_id'] ) {
        	Util::echoResult(201,$content['errmsg']);
        }

		
        $data = array("touser" => $user['openid'], "msgtype" => "image", "image" => array("media_id" => $content['media_id']));
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token;
        load()->func('communication');
        $ret = ihttp_request($url, json_encode($data));

        $content = @json_decode($ret['content'], true);

        Util::echoResult(201,$content['errmsg']);

	}elseif( $_GPC['op'] == 'testlink' ){

		
		if( empty( $_GPC['linkmess'] ) ) Util::echoResult(201,'请填写消息内容');
		if( empty( $_GPC['linklink'] ) && $_W['account']['level'] == 4 ) Util::echoResult(201,'请填写点击消息跳转链接');	
		if( empty( $_GPC['nick'] ) ) Util::echoResult(201,'填写昵称');
		$user = pdo_get('mc_mapping_fans',array('nickname'=>$_GPC['nick'],'uniacid'=>$_W['uniacid']));	
				
		if( empty( $user ) ) Util::echoResult(201,'没找到会员');

		$res = Message::linkmess($user['openid'],$_GPC['linkmess'],$_GPC['linklink']);	
		
		if( $res['res'] ){
			Util::echoResult(200,'已发送');
		}else{
			Util::echoResult(201,'发送失败，原因:'.$res['msg']);
		}
        


	}elseif( $_GPC['op'] == 'upuser' ){

		set_time_limit(0);

		$all = pdo_getall('zofui_posterhelp_user',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['aid']),array('openid','id'));

		if( !empty( $all ) ) {
			foreach ( $all as $v ) {
				$fans = pdo_get('mc_mapping_fans',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),array('nickname','tag'));	
				if( !empty( $fans ) ){
					$tag = iunserializer( base64_decode( $fans['tag'] ) );
					$headimgurl = $tag['headimgurl'];
					pdo_update('zofui_posterhelp_user',array('nickname'=>$fans['nickname'],'headimgurl'=>$headimgurl),array('id'=>$v['id']));
					Util::deleteCache('u',$v['openid'],$_GPC['aid']);
				}
			}
		}
		Util::echoResult(200,'已更新');	

	}