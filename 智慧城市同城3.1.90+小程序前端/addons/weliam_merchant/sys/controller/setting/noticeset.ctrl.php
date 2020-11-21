<?php
defined('IN_IA') or exit('Access Denied');

class Noticeset_WeliamController{
	
	/*
	 * 模板消息设置
	 */
	public function notice(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('noticeMessage');
		$notice = unserialize($settings['notice']);
		$message = unserialize($settings['message']);
		$smsData = Util::getNumData("name,id", PDO_NAME.'smstpl', array('status'=>1,'uniacid'=>$_W['uniacid']));
		$sms = $smsData[0];
		$member = pdo_get('wlmerchant_member',array('openid' => $settings['adminopenid']),array('openid','nickname'));
		if (checksubmit('submit')) {
			$base['notice'] = serialize($_GPC['notice']);
			$base['message'] = serialize($_GPC['message']);
			$base['adminopenid'] = $_GPC['adminopenid'];
			Setting::wlsetting_save($base,'noticeMessage');
			wl_message('更新设置成功！', web_url('setting/noticeset/notice'));
		}
		include wl_template('setting/notice');
	}
	
	public function smslist(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
   		$psize = 10;
		$listData = Util::getNumData('*', PDO_NAME.'smstpl', array(), 'id desc', $pindex, $psize, 1);
		$list = $listData[0];
		$pager = $listData[1];
		include wl_template('setting/sms/sms_list');
	}
	
	public function smsadd(){
		global $_W,$_GPC;
		if ($_W['isajax']) {
			//处理数据值
			$data_temp = $_GPC['data_temp'];
			$data_shop = $_GPC['data_shop'];
			$len = count($data_temp);
			$paramids = array();
			for ($k = 0; $k < $len; $k++) {
				$paramids[$k]['data_temp'] = $data_temp[$k];
				$paramids[$k]['data_shop'] = $data_shop[$k];
			}
	
			$base = array(
				'uniacid' => $_W['uniacid'],
				'name' => trim($_GPC['name']),
				'type' => trim($_GPC['type']),
				'smstplid' => trim($_GPC['smstplid']),
				'data' => serialize($paramids),
				'createtime' => time(),
				'status' => intval($_GPC['status'])
			);
			pdo_insert(PDO_NAME.'smstpl', $base);
			wl_message(array('errno'=>0,'message'=>'添加成功'));
		}
		include wl_template('setting/sms/sms_post');
	}
	
	public function smsedit(){
		global $_W,$_GPC;
		
		$id = intval($_GPC['id']);
		$item = pdo_get(PDO_NAME.'smstpl',array('id' => $id));
		$item['data'] = unserialize($item['data']);
		if ($_W['isajax']) {
			//处理数据值
			$data_temp = $_GPC['data_temp'];
			$data_shop = $_GPC['data_shop'];
			$len = count($data_temp);
			$paramids = array();
			for ($k = 0; $k < $len; $k++) {
				$paramids[$k]['data_temp'] = $data_temp[$k];
				$paramids[$k]['data_shop'] = $data_shop[$k];
			}
			$base = array(
				'uniacid' => $_W['uniacid'],
				'name' => trim($_GPC['name']),
				'type' => trim($_GPC['type']),
				'smstplid' => trim($_GPC['smstplid']),
				'data' => serialize($paramids),
				'createtime' => time(),
				'status' => intval($_GPC['status'])
			);
			pdo_update(PDO_NAME.'smstpl', $base, array('id' => $id));
			wl_message(array('errno'=>0,'message'=>'更新成功'));
		}
		include wl_template('setting/sms/sms_post');
	}
	
	public function smsset(){
		global $_W,$_GPC;
		$smses = pdo_getall(PDO_NAME.'smstpl',array('uniacid' => $_W['uniacid']),array('id','name'));
		$settings = Setting::wlsetting_read('smsset');
		if (checksubmit('submit')) {
			$base = array(
	            'dy_sf' => intval($_GPC['dy_sf']),
	            'dy_sfhw' => intval($_GPC['dy_sfhw'])
			);
			Setting::wlsetting_save($base,'smsset');
			wl_message('更新设置成功！', web_url('setting/noticeset/smsset'));
		}
		include wl_template('setting/sms/sms_setting');
	}
	
	public function smsparams(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('sms');
		if ($_W['isajax']) {
			if ($_GPC['note_haiwai'] == 'on' && empty($_GPC['note_quhao'])) {
				wl_message('请添加国际区号');
			}
			$base = array(
	            'note_appkey' => trim($_GPC['note_appkey']),
	            'note_secretKey' => trim($_GPC['note_secretKey']),
	            'note_sign' => trim($_GPC['note_sign']),
	            'note_haiwai' => $_GPC['note_haiwai'] == 'on' ? 1 : 0,
	            'note_quhao' => trim($_GPC['note_quhao']),
			);
			Setting::wlsetting_save($base,'sms');
			wl_message('更新设置成功！', web_url('setting/noticeset/smsparams'), 'success');
		}
		include wl_template('setting/sms/sms_param');
	}
	
	public function tpl(){
		global $_W,$_GPC;
		$kw = $_GPC['kw'];
    	include wl_template('setting/sms/sms_tpl');
	}
	
	public function dele(){
		global $_W,$_GPC;
		$id = intval($_GPC['id']);
	    if(pdo_delete(PDO_NAME.'smstpl', array('id' => $id))){
	    	wl_message(array('errno'=>0,'message'=>'删除成功'));
	    }
	    wl_message(array('errno'=>1,'message'=>'删除失败'));
	}
}
