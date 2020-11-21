<?php
defined('IN_IA') or exit('Access Denied');

class Wlsign{
//	更新用户签到数据	
	static function updateSignmember($update,$where=array()){
		global $_W;
		$where['mid'] = $_W['mid'];
		$res = pdo_update(PDO_NAME.'signmember',$update,$where);
		if($res){
			return 1;
		}else {
			return 0;
		}
	}	
	
//	查询用户签到数据	
	static function querySignmember($select,$where=array()){
		global $_W;
		$where['mid'] = $_W['mid'];
		$member = Util::getSingelData($select,PDO_NAME.'signmember',$where);
		if($member){
			$member['integral'] = intval($_W['wlmember']['credit1']);
			$user = pdo_get('wlmerchant_member',array('id' => $_W['mid']),array('avatar','nickname'));
			$member['nickname'] = $user['nickname'];
			$member['avatar'] = $user['avatar'];
			pdo_update(PDO_NAME.'signmember',array('integral' => $member['integral'],'nickname' => $member['nickname'], 'avatar' => $member['avatar']),array('id' => $member['id']));
			return $member;
		}else {
			if($_W['mid']){
				$user = pdo_get('wlmerchant_member',array('id' => $_W['mid']),array('avatar','nickname'));
				$member['uniacid'] = $_W['uniacid'];
				$member['mid'] = $_W['mid'];
				$member['times'] = 0;
				$member['totaltimes'] = 0;
				$member['integral'] = $_W['member']['credit1'];
				$member['createtime'] = time();
				$member['avatar'] = $user['avatar'];
				$member['nickname'] = $user['nickname'];
				pdo_insert(PDO_NAME.'signmember',$member);
				return $member;
			}
			
		}
	}
	
//	查询单条用户签到记录	
	static function queryRecord($select,$date){
		global $_W;
		$where['mid'] = $_W['mid'];
		$where['date'] = $date;
		return Util::getSingelData($select,PDO_NAME.'signrecord',$where);
	}
	
//	保存用户签到记录	
	static function saveRecord($record,$param=array()){
		global $_W;
		if(!is_array($record)) return FALSE;
		$record['uniacid'] = $_W['uniacid'];
		$record['mid'] = $_W['mid'];
		$record['createtime'] = time();
		if(empty($param)){
			pdo_insert(PDO_NAME.'signrecord',$record);
			return pdo_insertid();
		}
		return FALSE;
	}
	
//	获取用户记录排名	
	static function getMemberlist(){
		global $_W;
		$goodsInfo = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_signmember')."WHERE uniacid = {$_W['uniacid']} AND totaltimes > 0 ORDER BY times DESC limit 20");
		return $goodsInfo;
	}	
	
//	查询单条用户领奖记录	
	static function queryReceive($select,$date,$total){
		global $_W;
		$where['mid'] = $_W['mid'];
		$where['date'] = $date;
		$where['total'] = $total;
		return Util::getSingelData($select,PDO_NAME.'signreceive',$where);
	}	
//	保存用户领取记录	
	static function saveReceive($receive,$param=array()){
		global $_W;
		if(!is_array($receive)) return FALSE;
		$receive['uniacid'] = $_W['uniacid'];
		$receive['mid'] = $_W['mid'];
		$receive['createtime'] = time();
		if(empty($param)){
			pdo_insert(PDO_NAME.'signreceive',$receive);
			return pdo_insertid();
		}
		return FALSE;
	}
	
	
	//计划任务
	static function doTask(){
		global $_W;
		$time = time();
		$begin=mktime(0,0,0,date('m'),1,date('Y'));
		$end=mktime(0,3,59,date('m'),1,date('Y'));
		if($time>$begin && $time<$end){
			$settings = Setting::wlsetting_read('wlsign');
			$members = pdo_getall('wlmerchant_signmember',array('uniacid' => $_W['uniacid']));
			if($members){
				if($settings['cycletype'] == 1){
					foreach ($members as $key => &$v) {
						$v['record'] = '';
						$res = pdo_update('wlmerchant_signmember',$v,array('id' => $v['id']));
					}
				}else {
					foreach ($members as $key => &$v) {
						$v['record'] = '';
						$v['totaltimes'] = '';
						$v['total'] = '';
						$res = pdo_update('wlmerchant_signmember',$v,array('id' => $v['id']));
					}
				}
			}
			
		}
	}
}
?>