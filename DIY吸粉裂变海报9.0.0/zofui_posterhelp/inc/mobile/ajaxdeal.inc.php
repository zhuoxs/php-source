<?php 
	defined('IN_IA') or exit('Access Denied');
	set_time_limit(0);
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo();

	$ing = Util::getCache('ing',$_W['openid']);
	if(  is_array( $ing ) && $ing['status'] == 1 && $ing['time'] >= time() - 60 ) {
		$res = array('status'=>201,'res'=>'操作过于频繁，稍后再试');
		echo json_encode($res);
		exit;
	}
	Util::setCache('ing',$_W['openid'],array('status'=>1,'time'=>time()));


	// 必须放前面 获取地址
	if($_GPC['op'] == 'location'){

		$sessionstr = $userinfo['id'].'ph'.$_W['uniacid'].$_W['actid'];
		if( empty($_SESSION[$sessionstr]) ){
			
			$_SESSION[$sessionstr] = array('lat'=>$_GPC['latitude'],'lng'=>$_GPC['longitude']);

			//$ak = empty( $this->module['config']['ak'] ) ? 'F51571495f717ff1194de02366bb8da9' : $this->module['config']['ak'];
			//$url = 'http://api.map.baidu.com/geocoder/v2/?ak='.$ak.'&location='.$_GPC['latitude'].','.$_GPC['longitude'].'&output=json&pois=1';

			$url = 'http://apis.map.qq.com/ws/geocoder/v1/?location='.$_GPC['latitude'].','.$_GPC['longitude'].'&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77&get_poi=1';

			$opt=array('http'=>array('header'=>"Referer: http://lbs.qq.com/webservice_v1/guide-gcoder.html")); 
			$context=stream_context_create($opt); 
			$res = file_get_contents($url,false, $context);

			$arr = json_decode($res,true);
			/*if($arr['status'] != '0'){
				Util::echoResult(201,'获取地理位置失败，可能是后台没有设置百度地理位置接口ak，'.$arr['message']);
			}else{
				$_SESSION[$sessionstr]['province'] = $arr['result']['addressComponent']['province'];
				$_SESSION[$sessionstr]['city'] = $arr['result']['addressComponent']['city'];
				$_SESSION[$sessionstr]['country'] = $arr['result']['addressComponent']['district'];
				
			}*/

			if($arr['status'] != '0'){
				Util::echoResult(201,'获取地理位置失败，可能是后台没有设置百度地理位置接口ak，'.$arr['message']);
			}else{

				$_SESSION[$sessionstr]['province'] = $arr['result']['address_component']['province'];
				$_SESSION[$sessionstr]['city'] = $arr['result']['address_component']['city'];
				$_SESSION[$sessionstr]['country'] = str_replace(array('区','县','自治区','自治县','县'),array('','','','',''), $arr['result']['address_component']['district']);
				$_SESSION[$sessionstr]['town'] = str_replace(array('乡','镇','街道'),array('','',''), $arr['result']['address_reference']['town']['title']);
			}
		}

		checkLocation( $userinfo['id'] );
		Util::echoResult(200,'好');
	}

	// 兑换奖品
	elseif( $_GPC['op'] == 'changeprize' ){
		checkLocation( $userinfo['id'] );

		if( empty( $_SESSION['getprize'] ) ) Util::echoResult(201,'请重新进入页面重试');
		unset( $_SESSION['getprize'] );

		$prize = pdo_get('zofui_posterhelp_prize',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'id'=>$_GPC['pid']));
		if( empty( $prize ) ) Util::echoResult(201,'奖品不存在');
		if( $prize['stock'] <= 0 ) Util::echoResult(201,'奖品已经被抢完了');

		$act = model_act::getAct( $_W['actid'] );
		if( $act['status'] == 1 ) Util::echoResult(201,'活动已下架，不能参与');
		if( $act['start'] > time() ) Util::echoResult(201,'活动还没开始');		
		if( $act['end'] < time() ) Util::echoResult(201,'活动已结束了');

		if( $act['prizelim'] == 1 ){
			if( $act['prizestart'] > TIMESTAMP ){
				$prizestart = date('Y-m-d H:i',$act['prizestart']);
				Util::echoResult(201,$prizestart.'才可以领取奖品');
			}
			if( $act['prizeend'] < TIMESTAMP ){
				$prizeend = date('Y-m-d H:i',$act['prizeend']);
				Util::echoResult(201,'已超过兑奖时间,'.$prizeend.'前才可以兑奖');
			}
		}
		
		if( empty($act['jftype']) ){
			$user = pdo_get('zofui_posterhelp_user',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'openid'=>$_W['openid']));
			$credit = $user['credit'];
		}elseif($act['jftype'] == 1){
			$carr = model_user::getUserCredit($_W['openid']);
			$credit = $carr['credit1'];
		}
		

		if( $credit < $prize['need'] ) Util::echoResult(201,'您的'.$_W['act']['creditname'].'不足');
		
		$getednum = Util::countDataNumber('zofui_posterhelp_geted',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'openid'=>$_W['openid']));
		if( $getednum >= $_W['act']['maxchange'] ) Util::echoResult(201,'您不能再兑换奖品了，每人最多兑换'.$_W['act']['maxchange'].'次奖品');		

		$geted = Util::countDataNumber('zofui_posterhelp_geted',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'prizeid'=>$prize['id'],'openid'=>$_W['openid']));
		if( $geted >= $prize['maxchange'] ) Util::echoResult(201,'您不能再兑换此奖品，换一个吧');


		$fee = rand($prize['min']*100,$prize['max']*100)/100;
		if( $prize['type'] == 1 ){ // 积分

			$res = model_user::updateUserCredit($_W['openid'],$fee,1,2);
			$resstr = '积分'.$fee.'，已发放到您的积分余额内。';
			$data['status'] = 1;
		}elseif( $prize['type'] == 2 ){ // 余额

			$res = model_user::updateUserCredit($_W['openid'],$fee,2,2);
			$resstr = '余额'.$fee.'，已发放到您的余额内。';
			$data['status'] = 1;
		}elseif( $prize['type'] == 0 ){ // 红包


			if( $act['isverifyh'] == 0 ){ // 直接发红包

		        $arr['openid'] = $_W['openid'];
		        if ( $_W['account']['level'] == 3 || $_W['account']['key'] != $this->module['config']['appid'] ) {
		        	$auth = pdo_get('zofui_posterhelp_auth',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'openid'=>$_W['openid']));
		        	if( !empty( $auth['authopenid'] ) ){
		        		$arr['openid'] = $auth['authopenid'];
		        	}
					
		        }
		        $arr['fee'] = $fee;
		        $pay = new WeixinPay;
		                
		        if($this->module['config']['paytype'] == 0){ // 红包发放
		            $arr['hbname'] = '活动红包';
		            $arr['body'] = '活动红包';
		            $cres = $pay -> sendhongbaoto($arr,$this);

		            $resstr = '红包'.$arr['fee'].'元，已发放到你和公众号对话的聊天框中，请查收。';

		        }else{
		            $cres = $pay -> sendMoneyToUser($arr,$this);
		            $resstr = '红包'.$arr['fee'].'元，已发放到您的微信钱包内。';
		        }
		                
		        if($cres['result_code'] != 'SUCCESS'){
		            
		            $resstr = '，'.$cres['err_code_des'];
		        }else{
		        	$res = true;
		        	$data['status'] = 1;
		        }

			}else{ // 审核后发
				$res = true;
				$data['waitpay'] = 1;
				$data['status'] = 0;
				$resstr = '已提交领取申请，请等待管理员发放奖品';
			}


		}elseif( $prize['type'] == 3 ){ // 其他奖品
			$res = true;
			$data['status'] = 0;
			$total = Util::countDataNumber('zofui_posterhelp_geted',array('uniacid'=>$_W['uniacid'])) + 1;
			$data['code'] = $_W['actid'].$total.rand(111,999);

			$resstr = $_W['act']['sendtype'] == 0 ? '兑换奖品成功，请等待我们为您发奖' : '兑换奖品成功，请在‘我的奖品’内根据提示到相应门店去领取奖品';
		}

		if( $res ){

			// 减掉积分
			if( $prize['isminus'] == 1 && $prize['need'] > 0 ){
				
				if( empty($_W['act']['jftype']) ){
					Util::addOrMinusOrUpdateData('zofui_posterhelp_user',array('credit'=>-$prize['need']),$userinfo['id']);
					Util::deleteCache('u',$_W['openid']);
				}elseif($_W['act']['jftype'] == 1){
					model_user::updateUserCredit($userinfo['openid'],-$prize['need'],1,'助力海报');
				}
				

				$miscredit = $prize['need'];
			}

			$data['uniacid'] = $_W['uniacid'];
			$data['actid'] = $_W['actid'];
			$data['openid'] = $_W['openid'];
			$data['prizeid'] = $prize['id'];
			$data['miscredit'] = $miscredit;
			$data['getname'] = $_GPC['address']['name'];
			$data['gettel'] = $_GPC['address']['tel'];
			$data['address'] = $_GPC['address']['address'];
			$data['createtime'] = time();
			$data['fee'] = $fee;
			pdo_insert('zofui_posterhelp_geted',$data);
			Util::addOrMinusOrUpdateData('zofui_posterhelp_prize',array('stock'=>-1),$prize['id']);


			Util::deleteCache('allprize',$_W['actid'],$_W['actid']); 
			$_SESSION['getprize'] = 1;
			Util::echoResult(200,$resstr);
		}else{
			Util::echoResult(201,'兑换失败'.$resstr);
		}

	}

	elseif ( $_GPC['op'] == 'addressinfo' ){

		$geted = pdo_get('zofui_posterhelp_geted',array('uniacid'=>$_W['uniacid'],'actid'=>$_W['actid'],'openid'=>$_W['openid'],'id'=>$_GPC['gid']));
		
		if( !empty( $geted ) ){
			Util::echoResult(200,'好',$geted);
		}
		Util::echoResult(201,'没有找到兑换记录');
	}

	elseif ( $_GPC['op'] == 'getposter' ){
		checkLocation( $userinfo['id'] );

		$img = model_poster::getPoster($userinfo);
		$act = model_act::getAct( $_W['actid'] );

		if( $act['status'] == 1 ) Util::echoResult(201,'活动已下架，不能参与');
		if( $act['start'] > time() ) Util::echoResult(201,'活动还没开始');		
		if( $act['end'] < time() ) Util::echoResult(201,'活动已结束了');

		if( $img ){

			$media = Message::uploadImage($img['dir']);
			$res = Message::sendImage($_W['openid'], $media);
			if( $res['res'] ){

				$text = empty( $this->module['config']['getposterfont'] ) ? '海报已发送，您可以将海报发送给您的朋友搜集{creditname}，{a}点击此处查看和兑换奖品{/a}' : $this->module['config']['getposterfont'];


				$url = Util::createModuleUrl('getprize',array('actid'=>$act['id']));
				//$url = $this->buildSiteUrl($url);

        		$urlstr = htmlspecialchars_decode($text);
        		$urlstr = str_replace('{creditname}', $act['creditname'], $urlstr);
        		$urlstr = str_replace(array('{a}','{/a}'),array('<a href=\"'.$url.'\">','</a>'), $urlstr);

				/*$text = $_W['account']['level'] == 4 ? '将上方海报发送给您的朋友，您的朋友扫码订阅公众号即可获赠'.$_W['act']['creditname'] : '将上方海报发送给您的朋友，您的朋友扫码关注，回复您的邀请编码即可获赠'.$_W['act']['creditname'];*/

				Message::sendText($_W['openid'], $urlstr);
				if( $userinfo['status'] == 0 ){
					pdo_update('zofui_posterhelp_user',array('isstart'=>1),array('uniacid'=>$_W['uniacid'],'id'=>$userinfo['id']));
					Util::deleteCache('u',$_W['openid']);
				}
				
				Util::echoResult(200,'您获取'.$_W['act']['creditname'].'的海报已生成');
			}else{
				Util::echoResult(201,$res['msg']);
			}
			//file_put_contents(POSETERH_ROOT."/params.log", var_export(array(1,$media,$res), true).PHP_EOL, FILE_APPEND);	
		}
		//file_put_contents(POSETERH_ROOT."/params.log", var_export(array(2,$img), true).PHP_EOL, FILE_APPEND);
		Util::echoResult(201,'您长时间未与公众号互动无法发送图片给您，请从菜单栏获取海报。或者先发点文字给公众号后再到这里来操作');
	}


	elseif( $_GPC['op'] == 'setform' ){

		if( empty( $_GPC['name'] ) || empty( $_GPC['tel'] ) ) Util::echoResult(201,'请填写完整信息');
		
		$form = array(
			'uniacid' => $_W['uniacid'],
			'openid' => $_W['openid'],
			'name' => $_GPC['name'],
			'tel' => $_GPC['tel'],
			'actid' => $_W['actid'],
			'createtime' => time(),
		);
		$res = pdo_insert('zofui_posterhelp_form',$form);
		if( $res ) Util::echoResult(200,'已保存');
		Util::echoResult(201,'保存失败');
	}


	Util::echoResult(201,'没有任何数据');


	// 区域限制
	function checkLocation( $uid ){
		global $_W,$_GPC;
		if( $_W['act']['arealimit'] == 1 ){
			$sessionstr = $uid.'ph'.$_W['uniacid'].$_W['actid'];
			
			if( empty( $_SESSION[$sessionstr]['country'] ) ){
				
				if( empty( $_SESSION[$sessionstr]['town'] ) ) {
					Util::echoResult(201,'您的地区('.$_SESSION[$sessionstr]['country'].')不在活动举办区域内。(仅限'.$_W['act']['area']['country'].'区域参与活动)',array('id'=>0));
				}else{

					if( strpos($_W['act']['area']['country'],$_SESSION[$sessionstr]['town']) === false ){
						Util::echoResult(201,'您的地区('.$_SESSION[$sessionstr]['country'].')不在活动举办区域内。(仅限'.$_W['act']['area']['country'].'区域参与活动)',array('id'=>0));
					}

				}

			}else{
				if( strpos($_W['act']['area']['country'],$_SESSION[$sessionstr]['country']) === false ){
					Util::echoResult(201,'您的地区('.$_SESSION[$sessionstr]['country'].')不在活动举办区域内。(仅限'.$_W['act']['area']['country'].'区域参与活动)',array('id'=>0));
				}
			}
			
		}
	}