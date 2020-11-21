<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

class gengkuai_dgModuleSystemWelcome extends WeModuleSystemWelcome {

	public function __construct() {
		global $_GPC,$_W;
		$_GPC['__input'] = empty($_GPC['__input']) ? array() : $_GPC['__input'];
		$_GPC = array_merge($_GPC, $_GPC['__input']);
		unset($_GPC['__input']);
	}

	public function systemWelcomeDisplay() {
		$nav_list = pdo_getall('gengkuai_tp', array('type' => 1), array(), 'id');
		
		include $this->template('WQBackStage/tp');
	}

	public function doPageSetting() {
		global $_W, $_GPC;
		$operates = array('display', 'save', 'delete');
		$operate = in_array($_GPC['operate'], $operates) ? $_GPC['operate'] : 'display';
		if ($operate == 'display') {
			$nav_list = pdo_getall('gengkuai_tp', array('type' => 1), array(), 'id');
		}

		if ($operate == 'delete') {
			$id = intval($_GPC['id']);
			if (!$_W['isfounder']) {
				itoast('非法操作。只有创始人可进行此操作');
			}
			pdo_delete('gengkuai_tp', array('id' => $id));
			itoast('删除成功', '', 'success');
		}

		if ($operate == 'save') {
			$type = trim($_GPC['type']);
			if ($type == 'nav') {
				$id = intval($_GPC['buffer']['nav']['id']);
				$data = array(
					'a' => trim($_GPC['buffer']['nav']['a']),
					'b' => trim($_GPC['buffer']['nav']['b']),
                	'c' => trim($_GPC['buffer']['nav']['c']),
					'type' => 1
				);
			}
			
			if (!empty($id)) {
				pdo_update('gengkuai_tp', $data, array('id' => $id));
			} else {
				pdo_insert('gengkuai_tp', $data);
			}
			iajax(0);
		}
		include $this->template('WQBackStage/setting');
	}

	public function doPageUrlSetting() {
		global $_W, $_GPC;
		$operates = array('display', 'save', 'delete');
		$operate = in_array($_GPC['operate'], $operates) ? $_GPC['operate'] : 'display';
		if ($operate == 'display') {
			$nav_list = pdo_getall('gengkuai_dg_url_setting', array('type' => 1), array(), 'id');
		}

		if ($operate == 'delete') {
			$id = intval($_GPC['id']);
			if (!$_W['isfounder']) {
				itoast('非法操作。只有创始人可进行此操作');
			}
			pdo_delete('gengkuai_dg_url_setting', array('id' => $id));
			itoast('删除成功', '', 'success');
		}

		if ($operate == 'save') {
			$type = trim($_GPC['type']);
			if ($type == 'nav') {
				$id = intval($_GPC['buffer']['nav']['id']);
				$data = array(
					'a' => trim($_GPC['buffer']['nav']['a']),
					'b' => trim($_GPC['buffer']['nav']['b']),
                	'c' => trim($_GPC['buffer']['nav']['c']),
					'type' => 1
				);
			}
			
			if (!empty($id)) {
				pdo_update('gengkuai_dg_url_setting', $data, array('id' => $id));
			} else {
				pdo_insert('gengkuai_dg_url_setting', $data);
			}
			iajax(0);
		}
		include $this->template('WQBackStage/urlsetting');
	}
}