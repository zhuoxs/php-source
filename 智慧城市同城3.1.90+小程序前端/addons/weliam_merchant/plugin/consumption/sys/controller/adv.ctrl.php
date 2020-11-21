<?php
defined('IN_IA') or exit('Access Denied');

class Adv_WeliamController {

	public function adv_list() {
		global $_W, $_GPC;
		if ($_W["ispost"]) {
			if (!empty($_GPC["ids"])) {
				foreach ($_GPC["ids"] as $k => $v) {
					$data = array("advname" => trim($_GPC["advnames"][$k]), "displayorder" => intval($_GPC["displayorders"][$k]), "status" => !empty($_GPC["status"][$k]) ? 1 : 0);
					pdo_update("wlmerchant_consumption_adv", $data, array("uniacid" => $_W["uniacid"], "id" => intval($v)));
				}
			}
			show_json(1, array('message' => '编辑幻灯片成功', 'url' => web_url('consumption/adv/adv_list')));
		}
		$slides = pdo_fetchall("select * from " . tablename("wlmerchant_consumption_adv") . " where uniacid = :uniacid order by displayorder desc", array(":uniacid" => $_W["uniacid"]));
		include wl_template('consumption/adv');
	}

	public function adv_post() {
		global $_W, $_GPC;
		$id = intval($_GPC["id"]);
		if (0 < $id) {
			$slide = pdo_get("wlmerchant_consumption_adv", array("uniacid" => $_W["uniacid"], "id" => $id));
			if (empty($slide)) {
				wl_message("幻灯片不存在或已删除", referer(), "error");
			}
		}
		if ($_W["ispost"]) {
			$advname = (trim($_GPC["advname"]) ? trim($_GPC["advname"]) : imessage(error(-1, "标题不能为空"), "", "ajax"));
			$data = array("uniacid" => $_W["uniacid"], "advname" => $advname, "thumb" => trim($_GPC["thumb"]), "link" => trim($_GPC["link"]), "displayorder" => intval($_GPC["displayorder"]), "status" => intval($_GPC["status"]), "wxapp_link" => trim($_GPC["wxapp_link"]));
			if (!empty($slide)) {
				pdo_update("wlmerchant_consumption_adv", $data, array("uniacid" => $_W["uniacid"], "id" => $id));
			} else {
				pdo_insert("wlmerchant_consumption_adv", $data);
			}
			show_json(1, array('message' => '编辑幻灯片成功', 'url' => web_url('consumption/adv/adv_list')));
		}
		include wl_template('consumption/adv');
	}

	public function adv_displayorder() {
		global $_W, $_GPC;
		$id = intval($_GPC["id"]);
		$displayorder = intval($_GPC["displayorder"]);
		pdo_update("wlmerchant_consumption_adv", array("displayorder" => $displayorder), array("uniacid" => $_W["uniacid"], "id" => $id));
		show_json(1);
	}

	public function adv_del() {
		global $_W, $_GPC;
		$ids = $_GPC["id"];
		if (!is_array($ids)) {
			$ids = array($ids);
		}
		foreach ($ids as $value) {
			pdo_delete("wlmerchant_consumption_adv", array("uniacid" => $_W["uniacid"], "id" => $value));
		}
		show_json(1, '删除成功');
	}

}
