<?php
defined('IN_IA') or exit('Access Denied');

class Fightset_WeliamController {
	//入口设置
	public function fightentry() {
		global $_W, $_GPC;
		$set['url'] = app_url('wlfightgroup/fightapp/fightindex', array('aid' => $_W['aid']));
		include wl_template('fightset/fightentry');
	}
	function qrcodeimg(){
		global $_W, $_GPC;
		$url = $_GPC['url'];
		m('qrcode/QRcode')->png($url, false, QR_ECLEVEL_H, 4);
	}
	function fightgroupset(){
		global $_W, $_GPC;
		$set = Setting::agentsetting_read('fightgroup');
		$distri = Setting::wlsetting_read('distribution');
		if (checksubmit('submit')) {
			$set = $_GPC['set'];
			$set['shout'] = $_GPC['shout'];
			$set['status'] = $_GPC['status'];
			$res1 = Setting::agentsetting_save($set,'fightgroup');
			if ($res1) {
				wl_message('保存设置成功！', referer(), 'success');
			} else {
				wl_message('保存设置失败！', referer(), 'error');
			}
		}
		include wl_template('fightset/fightgroupset');
	}
	function imgandurl(){
		include wl_template('fightset/imgandurl');
	}
	function falsemember(){
		include wl_template('fightset/falsemember');
	}
	function fightmember(){
		global $_W, $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$where['uniacid'] = $_W['uniacid'];
		$where['aid'] = $_W['aid'];
		$member = Wlfightgroup::getNumfalsemember('*', $where, 'ID DESC', $pindex, $psize, 1);
		$pager = $member[1];
		$member = $member[0];
		if (checksubmit('submit')) {
			$imgs = $_GPC['mem_img'];
			$names = $_GPC['mem_name'];
			$arr = Wlfightgroup::createfalsemember($imgs,$names);
			$success = $arr['success'];
			$fail = $arr['fail'];
			wl_message('创建虚拟用户完成，成功'.$success.'个,失败'.$fail.'个。', referer(), 'success');
		}
		include wl_template('fightset/fightmember');
	}
	
	function deletefalse(){
		global $_W, $_GPC;
		$id = $_GPC['id'];
		$res =  pdo_delete('wlmerchant_fightgroup_falsemember',array('id'=>$id));
		if($res){
			show_json(1);
		}else{
			show_json(0,'删除失败，请重试');
		}
	}
	
}
?>