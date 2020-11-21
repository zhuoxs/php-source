<?php
defined('IN_IA') or exit('Access Denied');

class Category_WeliamController {

	public function cate_list() {
		global $_W, $_GPC;
		if ($_W["ispost"]) {
			if (!empty($_GPC["ids"])) {
				foreach ($_GPC["ids"] as $k => $v) {
					$data = array("name" => trim($_GPC["name"][$k]), "displayorder" => intval($_GPC["displayorders"][$k]),'status'=>0);
					if($_GPC['status_'.$v] == 'on'){
						$data['status'] = 1;
					}
					pdo_update("wlmerchant_consumption_category", $data, array("uniacid" => $_W["uniacid"], "id" => intval($v)));
				}
			}
			show_json(1, array('message' => '编辑商品分类成功', 'url' => web_url('consumption/category/cate_list')));
		}
		$categorys = pdo_fetchall("select * from" . tablename("wlmerchant_consumption_category") . " where uniacid = :uniacid order by displayorder desc", array(":uniacid" => $_W["uniacid"]));
		include wl_template('consumption/category');
	}

	public function cate_post() {
		global $_W, $_GPC;
		$id = intval($_GPC["id"]);
		if (0 < $id) {
			$category = pdo_get("wlmerchant_consumption_category", array("uniacid" => $_W["uniacid"], "id" => $id));
			if (empty($category)) {
				wl_message("幻灯片不存在或已删除", referer(), "error");
			}
		}
		if ($_W["ispost"]) {
			$name = (trim($_GPC["name"]) ? trim($_GPC["name"]) : imessage(error(-1, "分类名称不能为空"), "", "ajax"));
			$data = array("uniacid" => $_W["uniacid"], "name" => $name, "thumb" => trim($_GPC["thumb"]), "displayorder" => intval($_GPC["displayorder"]), "status" => intval($_GPC["status"]), "isrecommand" => intval($_GPC["isrecommand"]));
			if (!empty($category)) {
				pdo_update("wlmerchant_consumption_category", $data, array("uniacid" => $_W["uniacid"], "id" => $id));
			} else {
				pdo_insert("wlmerchant_consumption_category", $data);
			}
			show_json(1, array('message' => '编辑商品分类成功', 'url' => web_url('consumption/category/cate_list')));
		}
		include wl_template('consumption/category');
	}

	public function cate_del() {
		global $_W, $_GPC;
		$id = intval($_GPC["id"]);
		pdo_delete("wlmerchant_consumption_category", array("uniacid" => $_W["uniacid"], "id" => $id));
		show_json(1, "删除成功");
	}

}
