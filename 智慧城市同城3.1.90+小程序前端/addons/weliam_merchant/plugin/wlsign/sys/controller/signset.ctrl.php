<?php
defined('IN_IA') or exit('Access Denied');

class Signset_WeliamController{
	public function signrule(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('wlsign');
		if (checksubmit('submit')) {
			//处理数据值
			$base = $_GPC['set'];
			$base['detail'] = htmlspecialchars_decode($base['detail']);
			$total = $_GPC['total'];
			$reward = $_GPC['reward'];
			$totalreward = array();
			$len = count($total);
			for ($k = 0; $k < $len; $k++) {
				if(!empty($total[$k])){
					$totalreward[$k]['total'] = $total[$k];
					$totalreward[$k]['reward'] = $reward[$k];
				}
			}
			$base['totalreward'] = $totalreward;
			$signtime = $_GPC['signtime'];
			$signtitle = $_GPC['signtitle'];
			$special = $_GPC['specialreward'];
			$specialreward = array();
			$len2 = count($signtime);
			for ($k = 0; $k < $len2; $k++) {
				if(!empty($signtime[$k])){
					$specialreward[$k]['signtime'] = strtotime($signtime[$k]);
					$specialreward[$k]['signtitle'] = $signtitle[$k];
					$specialreward[$k]['special'] = $special[$k];
				}
			}
			$base['specialreward'] = $specialreward;
			$base['top_images'] = $_GPC['top_images'];
			$data_img = $_GPC['data_img'];
			$data_url = $_GPC['data_url'];
			$paramids = array();
			$len3 = count($data_img);
			for ($k = 0; $k < $len3; $k++) {
				if(!empty($data_img[$k])){
					$paramids[$k]['data_img'] = $data_img[$k];
					$paramids[$k]['data_url'] = $data_url[$k];
				}
			}
			$base['adv'] = $paramids;

			$res1 = Setting::wlsetting_save($base,'wlsign');
			wl_message('保存设置成功！', referer(),'success');
		}
		include wl_template('signsys/signrule');
	}
	public function totalreward(){
		global $_W,$_GPC;
		include wl_template('signsys/totalreward');
	}
	public function specialreward(){
		global $_W,$_GPC;
		include wl_template('signsys/specialreward');
	}
	public function imgandurl(){
		include wl_template('signsys/imgandurl');
	}
	public function signrecord() {
		global $_W, $_GPC;
		$type = $_GPC['type']?$_GPC['type']:'member';
		$where['uniacid'] = $_W['uniacid'];
		$keytype = $_GPC['keywordtype'];
		$keyword = $_GPC['keyword'];
		if($type == 'member'){
			if(!empty($keyword)){
				if(!empty($keytype)){
					switch($keytype){
						case 1: $where['@nickname@'] = $keyword;break;
						case 2: $where['times>'] = $keyword;break;
						case 3: $where['times<'] = $keyword;break;
						case 4: $where['integral>'] = $keyword;break;
						case 5: $where['integral<'] = $keyword;break;
						default:break;
					}
				}
			}
			$pindex = max(1,$_GPC['page']);
			$listData = Util::getNumData("*", PDO_NAME.'signmember',$where, 'id desc', $pindex, 10, 1);
			$list = $listData[0];
			$pager = $listData[1];
		}
		if($type == 'record'){
			if(!empty($keyword)){
				if(!empty($keytype)){
					$params[':nickname'] = "%{$keyword}%";
					$member = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_member')."WHERE uniacid = {$_W['uniacid']} AND nickname LIKE :nickname",$params);
					if($member){
						$mids = "(";
						foreach ($member as $key => $v) {
							if($key == 0){
								$mids.= $v['id'];
							}else{
								$mids.= ",".$v['id'];
							}	
						}
						$mids.= ")";
						$where['mid#'] = $mids;
					}else {
						$where['mid#'] = "(0)";
					}
				}
			}
			if($_GPC['time_limit']){
				$time_limit = $_GPC['time_limit'];
				$starttime = strtotime($_GPC['time_limit']['start']);
				$endtime = strtotime($_GPC['time_limit']['end']) ;
				$where['createtime>'] = $starttime;
				$where['createtime<'] = $endtime+24*3600;
			}
			if (empty($starttime) || empty($endtime)){
				$starttime = strtotime('-1 month');
				$endtime = time();
			}
			$pindex = max(1,$_GPC['page']);
			$listData = Util::getNumData("*", PDO_NAME.'signrecord',$where, 'id desc', $pindex, 10, 1);
			$list = $listData[0];
			$pager  = $listData[1];
			foreach ($list as $key => &$v) {
				$member = pdo_get('wlmerchant_member',array('id' => $v['mid']),array('nickname','avatar'));
				$v['nickname'] = $member['nickname'];
				$v['avatar'] = $member['avatar'];
				$v['date'] = substr($v['date'],0,4).'-'.substr($v['date'],4,2).'-'.substr($v['date'],6,2);
			}
		}
		if($type == 'receive'){
			if(!empty($keyword)){
				if($keytype == 1){
					$params[':nickname'] = "%{$keyword}%";
					$member = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_member')."WHERE uniacid = {$_W['uniacid']} AND nickname LIKE :nickname",$params);
					if($member){
						$mids = "(";
						foreach ($member as $key => $v) {
							if($key == 0){
								$mids.= $v['id'];
							}else{
								$mids.= ",".$v['id'];
							}	
						}
						$mids.= ")";
						$where['mid#'] = $mids;
					}else {
						$where['mid#'] = "(0)";
					}
				}else if($keytype == 2){
					$where['total'] = $keyword;
				}elseif ($keytype == 3) {
					$where['reward'] = $keyword;
				}
			}
			if($_GPC['time_limit']){
				$time_limit = $_GPC['time_limit'];
				$starttime = strtotime($_GPC['time_limit']['start']);
				$endtime = strtotime($_GPC['time_limit']['end']) ;
				$where['createtime>'] = $starttime;
				$where['createtime<'] = $endtime+24*3600;
			}
			if (empty($starttime) || empty($endtime)){
				$starttime = strtotime('-1 month');
				$endtime = time();
			}
			$pindex = max(1,$_GPC['page']);
			$listData = Util::getNumData("*", PDO_NAME.'signreceive',$where, 'id desc', $pindex, 10, 1);
			$list = $listData[0];
			$pager  = $listData[1];
			foreach ($list as $key => &$v) {
				$member = pdo_get('wlmerchant_member',array('id' => $v['mid']),array('nickname','avatar'));
				$v['nickname'] = $member['nickname'];
				$v['avatar'] = $member['avatar'];
				$v['date'] = substr($v['date'],0,4).'-'.substr($v['date'],4,2);
			}
		}
		include wl_template('signsys/signrecord');
	}
	public function signentry() {
		global $_W, $_GPC;
		$set['url'] = app_url('wlsign/signapp/signindex');
		include wl_template('signsys/entry');
	}
	function qrcodeimg(){
		global $_W, $_GPC;
		$url = $_GPC['url'];
		m('qrcode/QRcode')->png($url, false, QR_ECLEVEL_H, 4);
	}
	function update(){
		global $_W, $_GPC;
		$members = pdo_getall('wlmerchant_signmember',array('uniacid' => $_W['uniacid']));
		foreach ($members as $key => &$v) {
			$v['times'] = 0;
			$v['record'] = '';
			$v['totaltimes'] = 0;
			$v['total'] = '';
			$res = pdo_update('wlmerchant_signmember',$v,array('id' => $v['id']));
		}
		if($res){
			wl_message('清除成功！',web_url('wlsign/signset/signrule'),'success');
		}else {
			wl_message('清除失败！',web_url('wlsign/signset/signrule'),'error');
		}
	}
}