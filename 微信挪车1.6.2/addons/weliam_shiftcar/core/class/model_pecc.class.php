<?php 
class model_pecc{

	//获取违章信息
	static function query_task($member){
		global $_W;
		if(empty($member['plate1']) || empty($member['plate2']) || empty($member['engine_number']) || empty($member['frame_number']) || empty($member['plate_number'])) return false;
		if($_W['wlsetting']['pecc']['jisu_api'] == 1){
			$all_pecc = self::jusu_api($member);
			self::jusu_save($all_pecc,$member,1);
		}
		if($_W['wlsetting']['pecc']['lubang_api'] == 1){
			$all_pecc = self::lubang_api($member);
			self::lubang_save($all_pecc,$member,1);
		}
	}
	
	//极速数据获取仅支持的交管局
	static function get_carorg(){	
		global $_W;	
		$cityconfig = Util::getCache('pecc','carorg');
		if(empty($cityconfig['data']) || $cityconfig['time'] < (time() - 86400)){
			$allcity = Util::httpPost('http://api.jisuapi.com/illegal/carorg?appkey='.$_W['wlsetting']['pecc']['jisu_appkey'].'&onlysupport=1');
			$cityconfig = @json_decode($allcity, true);
		    if($cityconfig['status'] == 0){
			    $cityconfig = $cityconfig['result']['data'];
				$cityconfig = array('data' => $cityconfig,'time' => time());
				Util::setCache('pecc','carorg',$cityconfig);
			}
		}
		return $cityconfig;
	}
	
	//极速数据获取所有交管局
	static function get_allcarorg(){	
		global $_W;	
		$cityconfig = Util::getCache('pecc','allcarorg');
		if(empty($cityconfig['data']) || $cityconfig['time'] < (time() - 86400)){
			$allcity = Util::httpPost('http://api.jisuapi.com/illegal/carorg?appkey='.$_W['wlsetting']['pecc']['jisu_appkey']);
			$cityconfig = @json_decode($allcity, true);
		    if($cityconfig['status'] == 0){
			    $cityconfig = $cityconfig['result']['data'];
				$cityconfig = array('data' => $cityconfig,'time' => time());
				Util::setCache('pecc','allcarorg',$cityconfig);
			}
		}
		return $cityconfig;
	}
	
	//极速数据获取车牌类型
	static function get_lstype(){	
		global $_W;	
		$cityconfig = Util::getCache('pecc','lstype');
		if(empty($cityconfig['data']) || $cityconfig['time'] < (time() - 86400)){
			$allcity = Util::httpPost('http://api.jisuapi.com/illegal/lstype?appkey='.$_W['wlsetting']['pecc']['jisu_appkey']);
			$cityconfig = @json_decode($allcity, true);
		    if($cityconfig['status'] != 0){
			    echo $cityconfig['msg'];
			    exit();
			}
			$result = $cityconfig['result'];
			Util::setCache('pecc','lstype',array('data' => $result,'time' => time()));
		}
		return $cityconfig;
	}

	//极速数据获取违章信息
	static function jusu_api($member){
		global $_W;
		if(empty($member['plate1']) || empty($member['plate2'])) return false;
		$cityconfig = self::get_carorg();
		foreach($cityconfig['data'] as $key => $value){
			if($value['lsprefix'] == $member['plate1']){
				if($value['list']){
					foreach($value['list'] as $key1 => $value1){
						if($value1['lsnum'] == $member['plate2']){
							$config_city = $value1;
						}
					}
				}else{
					$config_city = $value;
				}
			}
		}
		//接口问题，做特殊处理
		switch ($config_city['lsprefix']) {
			case '川':
				$config_city['carorg'] = 'sichuan';
				break;
			case '琼':
				$config_city['carorg'] = 'hainan';
				break;
			case '晋':
				$config_city['carorg'] = 'shanxi';
				break;
			default:
				break;
		}
		if(empty($config_city)) return false;
		//发动机号
		switch ($config_city['engineno']) {
			case 100:
				$engineno = $member['engine_number'];
				break;
			case 0:
				$engineno = '';
				break;
			default:
				$engineno = substr($member['engine_number'],-$config_city['engineno']);
				break;
		}
		//车架号
		switch ($config_city['frameno']) {
			case 100:
				$frameno = $member['frame_number'];
				break;
			case 0:
				$frameno = '';
				break;
			default:
				$frameno = substr($member['frame_number'],-$config_city['frameno']);
				break;
		}

		$url = "http://api.jisuapi.com/illegal/query?appkey=".$_W['wlsetting']['pecc']['jisu_appkey'];
		$carorg = $config_city['carorg'];//交管局代号
		$lsprefix = $member['plate1'];//车牌前缀 utf8
		$lsnum = $member['plate2'].$member['plate_number'];//车牌
		$lstype = '02';//车辆类型
		
		$post = array(
			'carorg'=>$carorg, 
            'lsprefix'=>$lsprefix, 
            'lsnum'=>$lsnum, 
            'engineno'=>$engineno, 
            'frameno'=>$frameno, 
            'lstype'=>$lstype
        );
		$all_pecc = Util::httpPost($url,$post);
		$all_pecc = @json_decode($all_pecc, true);
		return $all_pecc;
	}
	
	static function jusu_save($jsonarr,$member,$status = 1){
		global $_W;
		if($jsonarr['status'] == 0){
			$result = $jsonarr['result'];
			if(is_array($result)){
				foreach($result['list'] as $key => $value){
					$p_time = strtotime($value['time']);
					$re_id = pdo_getcolumn('weliam_shiftcar_peccrecord', array('mid' => $member['id'],'uniacid' => $_W['uniacid'],'acttime' => $p_time),'id');
					if(empty($re_id)){
						$data = array(
							'mid' => $member['id'],
							'uniacid' => $_W['uniacid'],
							'hphm' => $member['plate1'].$member['plate2'].$member['plate_number'],
							'acttime' => $p_time,
							'status' => 0,
							'address' => $value['address'],
							'code' => $value['legalnum'],
							'info' => $value['content'],
							'fen' => $value['score'],
							'money' => $value['price'],
							'content' => serialize($value),
							'createtime' => time()
						);
						if(pdo_insert('weliam_shiftcar_peccrecord',$data)){
							$pe_id = pdo_insertid();
							if($status == 1){
								pdo_insert('weliam_shiftcar_waitmessage',array('uniacid' => $_W['uniacid'],'type' => 1,'str' => $pe_id));
							}
						}
					}
				}
				pdo_update('weliam_shiftcar_member',array('tasktime' => time()),array('id' => $member['id']));
				return 1;
			}
			pdo_update('weliam_shiftcar_member',array('tasktime' => time()),array('id' => $member['id']));
			return 2;
		}else{
			pdo_insert('weliam_shiftcar_error',array('uniacid' => $_W['uniacid'],'type' => 2,'data' => serialize($jsonarr),'createtime' => time()));
			pdo_update('weliam_shiftcar_member',array('tasktime' => time()),array('id' => $member['id']));
			return array('status' => 3,'msg' => $jsonarr['msg']);
		}
	}

	static function lubang_cities(){
		global $_W;	
		$cityconfig = Util::getCache('pecc','lubang_cities');
		if(empty($cityconfig['data']) || $cityconfig['time'] < (time() - 86400)){
			$allcity = Util::httpPost('http://wz.loopon.cn/traffic_violation/api/v1/cities');
			$cityconfig = @json_decode($allcity, true);
			$cityconfig = $cityconfig['configs'];
			$cityconfig = array('data' => $cityconfig,'time' => time());
			Util::setCache('pecc','lubang_cities',$cityconfig);
		}
		return $cityconfig;
	}
	
	static function lubang_api($member){
		global $_W;
		if(empty($member['plate1']) || empty($member['plate2'])) return false;
		$cityconfig = self::lubang_cities();
		foreach($cityconfig['data'] as $key => $value){
			if($value['province_short_name'] == $member['plate1']){
				foreach($value['citys'] as $key1 => $value1){
					if($value1['car_head'] == $member['plate1'].$member['plate2']){
						$config_city = $value1;
					}
				}
				if(empty($config_city)){
					$config_city = $value['citys'][0];
				}
			}
		}
		if(empty($config_city)) return false;
		//发动机号
		switch ($config_city['engine_num']) {
			case -1:
				$engineno = $member['engine_number'];
				break;
			case 0:
				$engineno = '';
				break;
			default:
				$engineno = substr($member['engine_number'],-$config_city['engine_num']);
				break;
		}
		//车架号
		switch ($config_city['body_num']) {
			case -1:
				$frameno = $member['frame_number'];
				break;
			case 0:
				$frameno = '';
				break;
			default:
				$frameno = substr($member['frame_number'],-$config_city['body_num']);
				break;
		}
		$car_info = "{plate_num:".$member['plate1'].$member['plate2'].$member['plate_number'].",body_num:".$frameno.",engine_num:".$engineno.",city_id:".$config_city['city_id'].",car_type:02}";
		$sign = $_W['wlsetting']['pecc']['lubang_apiid'].$car_info.getMillisecond().$_W['wlsetting']['pecc']['lubang_appkey'];
		$sign = md5($sign);
		$url = "http://wz.loopon.cn/traffic_violation/api/v1/query?car_info=".$car_info."&api_id=".$_W['wlsetting']['pecc']['lubang_apiid']."&timestamp=".getMillisecond()."&sign=".$sign;
		$all_pecc = Util::httpPost($url);
		$all_pecc = @json_decode($all_pecc, true);
		return $all_pecc;
	}

	static function lubang_save($jsonarr,$member,$status = 1){
		global $_W;
		if($jsonarr['rspcode'] == 20000){
			foreach($jsonarr['historys'] as $key => $value){
				$p_time = strtotime($value['time']);
				$re_id = pdo_getcolumn('weliam_shiftcar_peccrecord', array('mid' => $member['id'],'uniacid' => $_W['uniacid'],'acttime' => $p_time),'id');
				if(empty($re_id)){
					$data = array(
						'mid' => $member['id'],
						'uniacid' => $_W['uniacid'],
						'hphm' => $member['plate1'].$member['plate2'].$member['plate_number'],
						'acttime' => $p_time,
						'status' => 0,
						'address' => $value['address'],
						'code' => $value['code'],
						'info' => $value['info'],
						'fen' => $value['score'],
						'money' => $value['money'],
						'content' => serialize($value),
						'createtime' => time()
					);
					if(pdo_insert('weliam_shiftcar_peccrecord',$data)){
						$pe_id = pdo_insertid();
						if($status == 1){
							pdo_insert('weliam_shiftcar_waitmessage',array('uniacid' => $_W['uniacid'],'type' => 1,'str' => $pe_id));
						}
					}
				}
			}
			pdo_update('weliam_shiftcar_member',array('tasktime' => time()),array('id' => $member['id']));
			return 1;
		}elseif($jsonarr['rspcode'] == 21000){
			pdo_update('weliam_shiftcar_member',array('tasktime' => time()),array('id' => $member['id']));
			return 2;
		}else{
			pdo_insert('weliam_shiftcar_error',array('uniacid' => $_W['uniacid'],'type' => 3,'data' => serialize($jsonarr),'createtime' => time()));
			pdo_update('weliam_shiftcar_member',array('tasktime' => time()),array('id' => $member['id']));
			return array('status' => 3,'msg' => self::lubang_statuscode($jsonarr['rspcode']));
		}
	} 
	
	static function lubang_statuscode($code){
		$data = array('10001' => '参数中apikey不存在','10002' => 'apikey没有申请，请稍后再试','10003' => 'apikey对应的不是该接口（比如申请的接口中有限性但没有违章）','10004' => 'apikey已到达使用次数上线','10100' => '省份ID输入有误，请确认后接入','10101' => '车牌号、汽车类型、违章城市不可以为空','10102' => '输入carinfo参数错误,车牌号、车架号或发动机号错误也是返回该状态码','10105'=>'Sign加密验证失败','50100'=>'请求超时，请稍后重试','50101'=>'交管局系统连线忙碌中，请稍后再试','50104'=>'服务器错误','50108'=>'查询城市未开通');
		return $data[$code];
	}
	
//	static function trafficlimit(){
//		$cityconfig = Util::getCache('pecc','trafficlimit');
//		if(empty($cityconfig['data']) || $cityconfig['time'] < (time() - 86400)){
//			$allcity = Util::httpPost('http://www.loopon.cn/api/v1/trafficlimit/number/getCityList?apikey=af3d1b80-628a-0134-fed7-00163e081329');
//			$cityconfig = @json_decode($allcity, true);
//			$cityconfig = $cityconfig['data'];
//			$cityconfig = array('data' => $cityconfig,'time' => time());
//			Util::setCache('pecc','trafficlimit',$cityconfig);
//		}
//		return $cityconfig;
//	}
//
//	static function citylimit($member){
//		if(empty($member['plate1']) || empty($member['plate2'])) return false;
//		$cityconfig = self::trafficlimit();
//		$limitms = Util::httpPost('http://www.loopon.cn/api/v1/trafficlimit/number/getCityLimit?apikey=af3d1b80-628a-0134-fed7-00163e081329&city=120000');
//		$limitms = @json_decode($limitms, true);
//		wl_debug($limitms);
//		foreach($cityconfig['data'] as $key => $value){
//			if($value['province_short_name'] == $member['plate1']){
//				foreach($value['citys'] as $key1 => $value1){
//					if($value1['car_head'] == $member['plate1'].$member['plate2']){
//						$config_city = $value1;
//					}
//				}
//				if(empty($config_city)){
//					$config_city = $value['citys'][0];
//				}
//			}
//		}
//	}
}