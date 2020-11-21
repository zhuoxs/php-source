<?php
defined('IN_IA') or exit('Access Denied');

class Plugin_WeliamController {

	public function index() {
		global $_W, $_GPC;
		if ($_W["ispost"]) {
			if (!empty($_GPC["ids"])) {
				$statuss = $_GPC["statuss"];
				foreach ($_GPC["ids"] as $k => $v) {
					$status = 0;
					if (!empty($statuss) && in_array($v, $statuss)) {
						$status = 1;
					}

					$data = array("title" => trim($_GPC["titles"][$k]), "ability" => trim($_GPC["abilitys"][$k]), "status" => $status, "displayorder" => intval($_GPC["displayorders"][$k]));
					if (!empty($_GPC["pluginimgs"][$k])) {
						$data["thumb"] = $_GPC["pluginimgs"][$k];
					}

					pdo_update("wlmerchant_plugin", $data, array("id" => intval($v)));
				}
			}
			show_json(1, '修改成功');
		}
		
		App::getPlugins(3);
		$condition = " where 1 ";
		$type = trim($_GPC["type"]);
		if (!empty($type)) {
			$condition .= " and type = :type";
			$params[":type"] = $type;
		}

		$keyword = trim($_GPC["keyword"]);
		if (!empty($keyword)) {
			$condition .= " and (name like :keyword or title like :keyword)";
			$params[":keyword"] = "%" . $keyword . "%";
		}

		$plugins = pdo_fetchall("select * from " . tablename("wlmerchant_plugin") . $condition, $params);
		$types = App::getCategory();

		include wl_template('cloud/plugin');
	}

	public function return_plugin() {
		global $_W;
		pdo_query("TRUNCATE TABLE " . tablename('wlmerchant_plugin') . ";");
		show_json(1, array('url' => web_url('cloud/plugin/index')));
	}

	public function account_list() {
		global $_W, $_GPC;
		$condition = " where 1";
		$keyword = trim($_GPC["keyword"]);
		if (!empty($keyword)) {
			$condition .= " and b.name like :keyword";
			$params[":keyword"] = "%" . $keyword . "%";
		}

		$pindex = max(1, intval($_GPC["page"]));
		$psize = 20;
		$total = pdo_fetchcolumn("select count(*) from " . tablename("wlmerchant_perm_account") . " as a left join " . tablename("account_wechats") . " as b on a.uniacid = b.uniacid " . $condition, $params);
		$accounts = pdo_fetchall("select a.*, b.name from " . tablename("wlmerchant_perm_account") . " as a left join " . tablename("account_wechats") . " as b on a.uniacid = b.uniacid " . $condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize, $params);
		if (!empty($accounts)) {
			foreach ($accounts as &$row) {
				$row["plugins"] = iunserializer($row["plugins"]);
			}
		}

		$pager = pagination($total, $pindex, $psize);
		$plugins = App::getPlugins();
		
		include wl_template('cloud/account');
	}

	public function account_post() {
		global $_W, $_GPC;
		$uniacid = intval($_GPC["uniacid"]);
		$perm = App::get_account_perm("", $uniacid);
		
		if ($_W["ispost"]) {
			if (empty($uniacid)) {
				show_json(-1, '请先选择公众号');
			}

			$data = array("uniacid" => $uniacid, "plugins" => iserializer($_GPC["plugins"]));
			if (empty($perm["id"])) {
				pdo_insert("wlmerchant_perm_account", $data);
			} else {
				pdo_update("wlmerchant_perm_account", $data, array("id" => $perm["id"]));
			}
			show_json(1, array('message'=>'编辑公众号权限成功','url'=>web_url("cloud/plugin/account_post", array("uniacid" => $uniacid))));
		}
		
		$plugins = App::getPlugins();
		$all_wechats = pdo_fetchall("select a.uniacid, b.name from " . tablename("account") . " as a left join " . tablename("account_wechats") . " as b on a.uniacid = b.uniacid WHERE a.isdeleted = 0 AND a.type = 1 ");
		
		include wl_template('cloud/account');
	}

	public function account_del() {
		global $_W, $_GPC;
		$id = intval($_GPC["id"]);
		pdo_delete("wlmerchant_perm_account", array("id" => $id));
		show_json(1, '删除公众号权限成功');
	}

}
