<?php 
class newadv{

	static function get_adv($position,$carncnumber = ''){
		global $_W;
		if(!empty($_W['wlmember']['ncnumber']) || !empty($carncnumber)){
			if($position == 2){
				$car_remark = pdo_get('weliam_shiftcar_qrcode',array('uniacid'=>$_W['uniacid'],'cardsn'=>$carncnumber),'remark');
			}else{
				$car_remark = pdo_get('weliam_shiftcar_qrcode',array('uniacid'=>$_W['uniacid'],'cardsn'=>$_W['wlmember']['ncnumber']),'remark');
			}
			if($car_remark){
				$advs = pdo_get('weliam_shiftcar_advertisement',array('status'=>1,'position'=>$position,'uniacid'=>$_W['uniacid'],'advtype'=>2,'remark'=>$car_remark));
			}
			if(empty($advs)){
				$advs = pdo_getall('weliam_shiftcar_advertisement',array('status'=>1,'position'=>$position,'uniacid'=>$_W['uniacid'],'advtype'=>1));
				foreach($advs as $key => $val){
					$cardnumber = explode(',', $val['cardnumber']);
					if($position == 2){
						$user_ncnum = intval(substr($carncnumber,-7));
					}else{
						$user_ncnum = intval(substr($_W['wlmember']['ncnumber'],-7));
					}
					if($cardnumber[0] <= $user_ncnum && $user_ncnum <= $cardnumber[1]){
						$advs = $advs[$key];
						break;
					}
				}
			}
			if($advs['issettime'] == 1){
				$signtime = unserialize($advs['signtime']);
				$starttime = strtotime($signtime['start']);
				$endtime = strtotime($signtime['end']);
				if($starttime > time() || time() > $endtime){
					unset($advs);
				}
			}
		}
		if(empty($advs)){
			$advs = pdo_get('weliam_shiftcar_advertisement',array('status'=>1,'position'=>$position,'uniacid'=>$_W['uniacid']));
		}	
		return self::handle($advs);
	}
	
	static function handle($advs){
		$advs = unserialize($advs['content']);
		if(empty($advs)) return array();
		foreach ($advs as &$adv) {
			if (substr($adv['data_url'], 0, 5) != 'http:') {
				$adv['data_url'] = "http://" . $adv['data_url'];
			}
		}
		unset($adv);
		return $advs;
	}
}