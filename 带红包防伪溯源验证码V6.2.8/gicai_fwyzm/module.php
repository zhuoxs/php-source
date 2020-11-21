<?php
/**
 * 计彩网络 爱驴微信平台 多活动模块DEMO
 * @1.0
 * @author gicai_fwyzm
 * @url http://www.ilvle.com/
 * @time 2017年12月9日17:03:23
 */
defined('IN_IA') or exit('Access Denied');

class gicai_fwyzmModule extends WeModule {
	 
	public function fieldsFormDisplay($rid = 0) {
        global $_W;
        if ($rid) {
            $reply = pdo_fetch("SELECT * FROM " . tablename("gicai_fwyzm_reply") . " WHERE rid = :rid", array(':rid' => $rid));
            $sql = 'SELECT * FROM ' . tablename("gicai_fwyzm") . ' WHERE `uniacid`=:uniacid and `id`=:id';
            $activity = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':id'=>$reply['fid']));
            $showpicurl = tomedia($activity['fmimg']);
        }
 
        include $this->template('sys/form');
    }
	
	public function fieldsFormValidate($rid = 0) {
        global $_W, $_GPC;
        $schoolid = intval($_GPC['activity']);
        if (!empty($schoolid)) {
            $sql = 'SELECT * FROM '.tablename("gicai_fwyzm")." WHERE `id`=:schoolid";
            $params = array();
            $params[':schoolid'] = $schoolid;
            $activity = pdo_fetch($sql, $params);
            return;
            if (!empty($activity)) {
                return '';
            }
        }
        return '没有选择活动';
    }
	
	 
	 
	public function fieldsFormSubmit($rid) {
        global $_GPC;
        $fid = intval($_GPC['activity']);
     	$rid = $rid;
		$data['rid'] = $rid;
		$data['fid'] = $fid;
        $reply = pdo_fetch("SELECT * FROM " . tablename("gicai_fwyzm_reply") . " WHERE rid=:rid",array(':rid'=>$rid));
        if ($reply) {
            pdo_update("gicai_fwyzm_reply",$data, array('id'=>$reply['id']));
        } else {
            pdo_insert("gicai_fwyzm_reply",$data);
        }
    }
	
	public function ruleDeleted($rid) {
        pdo_delete("gicai_fwyzm_reply", array('rid' => $rid));
    }

}