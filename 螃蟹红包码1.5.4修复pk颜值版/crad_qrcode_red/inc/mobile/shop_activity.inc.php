<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
error_reporting(0);
$uniacid = $_W["uniacid"];
$shopid = intval($_GPC["shopid"]);
$token = trim($_GPC["token"]);
$shop = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP) . " WHERE id = :shopid", array(":shopid" => $shopid));
$check_shop = $this->check_shop($shopid, $token, $shop);
if (empty($check_shop)) {
	$jump_url = $_W["siteroot"] . "app/" . substr($this->createMobileUrl("login", array("token" => $token, "shopid" => $shopid), true), 2);
	header("Location:{$jump_url}");
	exit;
}
$op = trim($_GPC["op"]);
if ($op == "create_qrcode") {
	header("Content-type:application/json");
	$aid = intval($_GPC["aid"]);
	$shop_activity = pdo_fetch("SELECT id,qrcode_num,endtime,status,qrcode_power,subscribe,qrcode_type,qrcode_one FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $aid));
	if ($shop_activity["qrcode_power"] == 3) {
		echo json_encode(array("sta" => 0, "error" => "您没有权限"));
		exit;
	}
	if ($check_shop["power"] < 3) {
		$data["sta"] = 0;
		$data["error"] = "您没有权限操作";
		echo json_encode($data);
		exit;
	}
	if (empty($shop_activity) || $shop_activity["qrcode_num"] < 1) {
		echo json_encode(array("sta" => 0, "error" => "数据错误"));
		exit;
	}
	if ($shop_activity["endtime"] && $_W["timestamp"] >= $shop_activity["endtime"]) {
		echo json_encode(array("sta" => 0, "error" => "活动已结束,无法生成二维码"));
		exit;
	}
	if ($shop_activity["status"] == 4) {
		echo json_encode(array("sta" => 0, "error" => "活动还在审核中"));
		exit;
	}
	if ($shop_activity["status"] == 5) {
		echo json_encode(array("sta" => 0, "error" => "活动未通过审核"));
		exit;
	}
	$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE aid = :id", array(":id" => $aid));
	if ($count_qrcode >= $shop_activity["qrcode_num"]) {
		echo json_encode(array("sta" => 2, "count" => $shop_activity["qrcode_num"]));
		exit;
	}
	$create_type = intval($_GPC["create_type"]);
	if ($create_type == 1) {
		$start_code = intval($_GPC["start_code"]);
		$bid = intval($_GPC["bid"]);
		$end_code = intval($_GPC["end_code"]);
		$band_num = intval($_GPC["band_num"]);
		if (empty($bid)) {
			echo json_encode(array("sta" => 0, "error" => "参数错误:请选择预印码"));
			exit;
		}
		$temp_count = $band_num ? min($band_num, $shop_activity["qrcode_num"] - $count_qrcode) : $shop_activity["qrcode_num"] - $count_qrcode;
		$bid_max_min = pdo_fetch("SELECT MAX(code) as max_id,MIN(code) as min_id FROM " . tablename(TABLE_QRCODE) . " where bid = :id AND aid<1 AND sid='{$shopid}'", array(":id" => $bid));
		if (empty($bid_max_min["max_id"]) || empty($bid_max_min["min_id"])) {
			echo json_encode(array("sta" => 0, "error" => "参数错误"));
			exit;
		}
		$min_code = $start_code ? max($start_code, $bid_max_min["min_id"]) : $bid_max_min["min_id"];
		$max_code = $end_code ? min($end_code, $bid_max_min["max_id"]) : $bid_max_min["max_id"];
		$count_qrcode_code = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE bid = :id AND aid<1 AND sid='{$shopid}' AND code<={$max_code} AND code>={$min_code}", array(":id" => $bid));
		if ($count_qrcode_code < $temp_count) {
			echo json_encode(array("sta" => 0, "error" => "预印码数量不足"));
			exit;
		}
		pdo_query("UPDATE " . tablename(TABLE_QRCODE) . " SET aid={$aid} WHERE bid = :id AND aid<1 AND sid='{$shopid}' AND code<={$max_code} AND code>={$min_code} ORDER BY code ASC LIMIT {$temp_count}", array(":id" => $bid));
	} else {
		if ($shop["qrcode_create_open"] == 1) {
			echo json_encode(array("sta" => 0, "error" => "您没有权限生成新二维码，请联系管理员"));
			exit;
		}
		if ($shop_activity["subscribe"] == 2) {
			$temp_min = 5;
		} else {
			$temp_min = 50;
		}
		$temp_count = min($temp_min, $shop_activity["qrcode_num"] - $count_qrcode);
		$x = 1;
		while ($x <= $temp_count) {
			$uuid = $this->get_uuid($aid, $uniacid);
			if ($shop_activity["subscribe"] == 2) {
				$shop_activity["qrcode_type"] = $shop_activity["qrcode_one"] ? 0 : $shop_activity["qrcode_type"];
				$res_get = $this->get_qrcode_url($uuid . "red" . $aid, $shop_activity["qrcode_type"]);
				$qrcode = $res_get["url"];
			} else {
				$qrcode = $this->domain_site() . "addons/crad_qrcode_red/s.php?" . $uuid;
			}
			$data = array("uniacid" => $uniacid, "uuid" => $uuid, "aid" => $aid, "qrcode" => $qrcode ? $qrcode : '', "status" => 0, "createtime" => time());
			pdo_insert(TABLE_QRCODE, $data);
			$x++;
		}
	}
	echo json_encode(array("sta" => 1, "count" => $count_qrcode + $temp_count));
	exit;
} else {
	if ($op == "get_not_band") {
		$bid = intval($_GPC["bid"]);
		$where = "bid ='{$bid}' AND aid<1 AND sid='{$shopid}'";
		$qrcode_not_band = pdo_fetchall("select code from " . tablename(TABLE_QRCODE) . " WHERE {$where} ORDER BY code ASC");
		if (empty($qrcode_not_band)) {
			$beforehand_row["not_band"] = "无未绑号段";
		} else {
			$beforehand_row["not_band"] = "未绑号段:" . $this->section_code($qrcode_not_band);
		}
		echo json_encode($beforehand_row);
		exit;
	} else {
		if ($op == "get_band_beforehand") {
			$aid = intval($_GPC["aid"]);
			$where = "status=0 AND bid>0";
			if ($aid) {
				$where .= " AND aid='{$aid}'";
			} else {
				echo json_encode(array("sta" => 0, "error" => "参数错误"));
				exit;
			}
			$qrcode_bids = pdo_fetchall("select bid from " . tablename(TABLE_QRCODE) . " WHERE {$where} GROUP BY bid");
			if (empty($qrcode_bids)) {
				echo json_encode(array("sta" => 0, "error" => "参数错误"));
				exit;
			} else {
				foreach ($qrcode_bids as &$value) {
					$beforehand_name = pdo_fetch("SELECT name FROM " . tablename(TABLE_BEFOREHAND) . " WHERE id = :bid", array(":bid" => $value["bid"]));
					$value["name"] = $beforehand_name["name"];
				}
				$beforehand_row["sta"] = 1;
				$beforehand_row["data"] = $qrcode_bids;
			}
			echo json_encode($beforehand_row);
			exit;
		} else {
			if ($op == "get_band") {
				$aid = intval($_GPC["aid"]);
				$bid = intval($_GPC["bid"]);
				$where = "bid ='{$bid}' AND status=0 AND code>0 ";
				if ($aid) {
					$where .= "AND aid='{$aid}'";
				}
				$qrcode_band = pdo_fetchall("select code from " . tablename(TABLE_QRCODE) . " WHERE {$where} ORDER BY code ASC");
				if (empty($qrcode_band)) {
					$beforehand_row["band"] = "无可解绑号段";
				} else {
					$beforehand_row["band"] = "可解绑号段:" . $this->section_code($qrcode_band);
				}
				echo json_encode($beforehand_row);
				exit;
			} else {
				if ($op == "unband_qrcode") {
					$aid = intval($_GPC["aid"]);
					$where = "WHERE aid ='{$aid}' AND status=0";
					$start_code = intval($_GPC["start_code"]);
					$bid = intval($_GPC["bid"]);
					$end_code = intval($_GPC["end_code"]);
					$band_num = intval($_GPC["band_num"]);
					if ($bid) {
						$where .= " AND bid='{$bid}'";
					} else {
						$where .= " AND bid>0";
					}
					$bid_max_min = pdo_fetch("SELECT MAX(code) as max_id,MIN(code) as min_id FROM " . tablename(TABLE_QRCODE) . " {$where}");
					if (empty($bid_max_min["max_id"]) || empty($bid_max_min["min_id"])) {
						echo json_encode(array("sta" => 0, "error" => "参数错误"));
						exit;
					}
					$min_code = $start_code ? max($start_code, $bid_max_min["min_id"]) : $bid_max_min["min_id"];
					$max_code = $end_code ? min($end_code, $bid_max_min["max_id"]) : $bid_max_min["max_id"];
					$count_qrcode_code = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " {$where} AND code<={$max_code} AND code>={$min_code}");
					$temp_count = $band_num ? $band_num : $count_qrcode_code;
					if ($count_qrcode_code < $temp_count) {
						echo json_encode(array("sta" => 0, "error" => "可解绑的预印码数量不足"));
						exit;
					}
					pdo_query("UPDATE " . tablename(TABLE_QRCODE) . " SET aid=0 {$where} AND code<={$max_code} AND code>={$min_code} ORDER BY code ASC LIMIT {$temp_count}");
					echo json_encode(array("sta" => 1, "count" => $temp_count));
					exit;
				} else {
					if ($op == "download_qrcode") {
						header("Content-type:application/json");
						$aid = intval($_GPC["aid"]);
						$shop_activity = pdo_fetch("SELECT id,qrcode_power FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $aid));
						if ($shop_activity["qrcode_power"] > 1) {
							echo json_encode(array("sta" => 0, "error" => "您没有权限"));
							exit;
						}
						$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where aid = :id", array(":id" => $aid));
						if (empty($shop_activity) || $count_qrcode < 1) {
							echo json_encode(array("sta" => 0, "error" => "请先生成二维码"));
							exit;
						}
						$pindex = max(1, intval($_GPC["page"]));
						if ($pindex == 1) {
							load()->func("file");
							$qrcode_path = ATTACHMENT_ROOT . "crad_qrcode_red/" . $aid . "/qrcode/";
							if (is_dir($qrcode_path)) {
								$p = scandir($qrcode_path);
								foreach ($p as $val) {
									if ($val != "." && $val != "..") {
										if (file_exists($qrcode_path . $val)) {
											file_delete($qrcode_path . $val);
										}
									}
								}
							}
						}
						$psize = 20;
						$list_qrcode = pdo_fetchall("SELECT id,aid,uuid,qrcode FROM " . tablename(TABLE_QRCODE) . " where aid = :id ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":id" => $aid));
						if (empty($list_qrcode)) {
							echo json_encode(array("sta" => 2));
							exit;
						}
						foreach ($list_qrcode as $value) {
							$this->get_qrcode($value["id"], $value["uuid"], $aid, 0, 0, $value["qrcode"]);
						}
						echo json_encode(array("sta" => 1, "count" => ($pindex - 1) * $psize + count($list_qrcode)));
						exit;
					}
				}
			}
		}
	}
}
if ($op == "download_qrcode_zip") {
	$aid = intval($_GPC["aid"]);
	$shop_activity = pdo_fetch("SELECT id,qrcode_power FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $aid));
	if ($shop_activity["qrcode_power"] > 1) {
		echo json_encode(array("sta" => 0, "error" => "您没有权限"));
		exit;
	}
	$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where aid = :id", array(":id" => $aid));
	if (empty($shop_activity) || $count_qrcode < 1) {
		$this->show_error("请先生成二维码", "error");
	}
	load()->func("file");
	$qrcode_path = ATTACHMENT_ROOT . "crad_qrcode_red/" . $aid . "/qrcode/";
	$qrcode_zip = $qrcode_path . $aid . ".zip";
	if (file_exists($qrcode_zip)) {
		file_delete($qrcode_zip);
	}
	$zip = new ZipArchive();
	if ($zip->open($qrcode_zip, ZipArchive::CREATE) === TRUE) {
		$this->addFileToZip($qrcode_path, $zip);
		$zip->close();
	} else {
		$this->show_error("生成压缩文件失败，请稍后重试！", "error");
	}
	if (file_exists($qrcode_zip)) {
		ob_clean();
		header("Pragma: public");
		header("Last-Modified:" . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control:no-store, no-cache, must-revalidate");
		header("Cache-Control:pre-check=0, post-check=0, max-age=0");
		header("Content-Transfer-Encoding:binary");
		header("Content-Encoding:none");
		header("Content-type:multipart/form-data");
		header("Content-Disposition:attachment; filename=\"" . $aid . ".zip\"");
		header("Content-length:" . filesize($qrcode_zip));
		$fp = fopen($qrcode_zip, "r");
		while (connection_status() == 0 && ($buf = @fread($fp, 8192))) {
			echo $buf;
		}
		fclose($fp);
		file_delete($qrcode_zip);
		@flush();
		@ob_flush();
		if (is_dir($qrcode_path)) {
			$p = scandir($qrcode_path);
			foreach ($p as $val) {
				if ($val != "." && $val != "..") {
					if (file_exists($qrcode_path . $val)) {
						file_delete($qrcode_path . $val);
					}
				}
			}
		}
		exit;
	} else {
		$this->show_error("下载失败，请稍后重试！", "error");
	}
}
if ($op == "download_qrcode_excel") {
	$aid = intval($_GPC["aid"]);
	$shop_activity = pdo_fetch("SELECT id,qrcode_power,subscribe,name FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $aid));
	if ($shop_activity["qrcode_power"] > 1) {
		$this->show_error("您没有权限", "error");
	}
	$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where aid = :id", array(":id" => $aid));
	if (empty($shop_activity) || $count_qrcode < 1) {
		$this->show_error("请先生成二维码", "error");
	}
	$list_excel = pdo_fetchall("SELECT id,uuid,bid,sbid,code,qrcode FROM " . tablename(TABLE_QRCODE) . " where aid = :id AND status=0", array(":id" => $aid));
	foreach ($list_excel as $key => $value) {
		$arr[$i]["id"] = $value["id"];
		if ($value["code"]) {
			$arr[$i]["code"] = ($value["sbid"] ? $value["sbid"] : $value["bid"]) . "_" . $value["code"];
		} else {
			$arr[$i]["code"] = $value["id"];
		}
		if ($shop_activity["subscribe"] == 2) {
			$arr[$i]["url"] = $value["qrcode"];
		} else {
			$arr[$i]["url"] = $value["qrcode"] ? $value["qrcode"] : $this->domain_site() . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&aid=" . $aid . "&uuid=" . $value["uuid"];
		}
		$i++;
	}
	$this->exportexcel($arr, array("ID", "编号", "二维码参数"), "二维码列表-" . $shop_activity["name"]);
	exit;
}
if ($op == "download_qrcode_txt") {
	$aid = intval($_GPC["aid"]);
	$shop_activity = pdo_fetch("SELECT id,qrcode_power,subscribe,name FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $aid));
	if ($shop_activity["qrcode_power"] > 1) {
		$this->show_error("您没有权限", "error");
	}
	$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where aid = :id", array(":id" => $aid));
	if (empty($shop_activity) || $count_qrcode < 1) {
		$this->show_error("请先生成二维码", "error");
	}
	ob_clean();
	header("Content-type:application/octet-stream");
	header("Accept-Ranges:bytes ");
	header("Content-Disposition:attachment;filename=二维码列表-" . $set["name"] . ".txt");
	header("Expires:0");
	header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
	header("Pragma:public");
	$list_excel = pdo_fetchall("SELECT id,uuid,bid,sbid,code,qrcode FROM " . tablename(TABLE_QRCODE) . " where aid = :id AND status=0", array(":id" => $aid));
	echo "ID 编号 二维码参数\r\n";
	foreach ($list_excel as $key => $value) {
		$id_q = $value["id"];
		if ($value["code"]) {
			$code_q = ($value["sbid"] ? $value["sbid"] : $value["bid"]) . "_" . $value["code"];
		} else {
			$code_q = $value["id"];
		}
		if ($shop_activity["subscribe"] == 2) {
			$url_q = $value["qrcode"];
		} else {
			$url_q = $value["qrcode"] ? $value["qrcode"] : $this->domain_site() . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&aid=" . $aid . "&uuid=" . $value["uuid"];
		}
		echo $id_q . " " . $code_q . " " . $url_q . "\r\n";
	}
	@flush();
	@ob_flush();
	exit;
} else {
	if ($op == "settlement_activity") {
		$this->settlement_activity($shopid);
		exit;
	} else {
		if ($op == "add") {
			$cfg = $this->module["config"]["api"];
			if (!empty($shop["pattern"])) {
				$shop["pattern"] = explode(",", $shop["pattern"]);
			} else {
				$shop["pattern"] = array();
			}
			$id = intval($_GPC["id"]);
			$pid = intval($_GPC["pid"]);
			$copy = intval($_GPC["copy"]);
			if ($id) {
				$shop_activity = pdo_fetch("SELECT * FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $id));
				if (empty($shop_activity) || $shop_activity["sid"] != $shopid) {
					$data["sta"] = 0;
					$data["error"] = "参数错误";
					echo json_encode($data);
					exit;
				}
				if (empty($copy) && empty($shop_activity["edit_open"])) {
					$data["sta"] = 0;
					$data["error"] = "活动不允许编辑";
					echo json_encode($data);
					exit;
				}
				$pid = $shop_activity["pattern"];
			}
			if ($pid && !in_array($pid, $shop["pattern"])) {
				$data["sta"] = 0;
				$data["error"] = "该发红包模式未对您开发";
				echo json_encode($data);
				exit;
			}
			if ($shop_activity["begintime"]) {
				$shop_activity["begintime"] = date("Y-m-d H:i:s", $shop_activity["begintime"]);
			}
			if ($shop_activity["endtime"]) {
				$shop_activity["endtime"] = date("Y-m-d H:i:s", $shop_activity["endtime"]);
			}
			$shop_coupon = pdo_fetchall("select id,name from " . tablename(TABLE_SHOP_COUPON) . " where shopid='" . $shopid . "' AND coupon_probability<1 AND status=1");
			$shop_coupon_p = pdo_fetchall("select id,name from " . tablename(TABLE_SHOP_COUPON) . " where shopid='" . $shopid . "' AND coupon_probability>0 AND status=1");
			if ($_GPC["submit"] == 1) {
				header("Content-type:application/json");
				if ($check_shop["power"] < 3) {
					$data["sta"] = 0;
					$data["error"] = "您没有权限操作";
					echo json_encode($data);
					exit;
				}
				if (empty($pid)) {
					$data["sta"] = 0;
					$data["error"] = "模式参数错误";
					echo json_encode($data);
					exit;
				}
				if ($shop["activity_open"] != 1) {
					$data["sta"] = 0;
					$data["error"] = "设置活动功能未开放";
					echo json_encode($data);
					exit;
				}
				load()->func("tpl");
				if (empty($_GPC["name"])) {
					$data["sta"] = 0;
					$data["error"] = "活动名称不能为空";
					echo json_encode($data);
					exit;
				}
				if ($copy == 1) {
					$shop_activity = array();
					$id = 0;
				}
				if (!empty($shop_activity)) {
					$has_name = pdo_fetch("SELECT id FROM " . tablename(TABLE_ACTIVITY) . " WHERE name = :name AND sid = :shopid  AND id != :id", array(":name" => trim($_GPC["name"]), ":shopid" => $shopid, ":id" => $id));
				} else {
					$has_name = pdo_fetch("SELECT id FROM " . tablename(TABLE_ACTIVITY) . " WHERE name = :name AND sid = :shopid", array(":name" => trim($_GPC["name"]), ":shopid" => $shopid));
				}
				if ($has_name) {
					$data["sta"] = 0;
					$data["error"] = "活动名称已存在";
					echo json_encode($data);
					exit;
				}
				if ($_GPC["begintime"] && $_GPC["endtime"] && strtotime($_GPC["begintime"]) > strtotime($_GPC["endtime"])) {
					$data["sta"] = 0;
					$data["error"] = "活动开始时间不能大于结束时间";
					echo json_encode($data);
					exit;
				}
				if ($_GPC["endtime"] && time() > strtotime($_GPC["endtime"])) {
					$data["sta"] = 0;
					$data["error"] = "结束时间不能小于当前时间";
					echo json_encode($data);
					exit;
				}
				
				$data_insert = array(
	"uniacid" => $uniacid,
	"pattern"=>$pid,
    "sid" => $shopid,
    "createtime" => time(),
    "openid" => $_W["openid"],
    "name"=>trim($_GPC["name"]),
    "status"=>trim($_GPC["status"]),
    "statusd"=>trim($_GPC["statusd"]),
    "site"=>trim($_GPC["site"]),
    "limit_distance"=>trim($_GPC["limit_distance"]),
    "check_tel"=>trim($_GPC["check_tel"]),
    "upload_type"=>trim($_GPC["upload_type"]),
    "get_num"=>trim($_GPC["get_num"]),
    "get_num_day"=>trim($_GPC["get_num_day"]),
    "over_limit_url"=>trim($_GPC["over_limit_url"]),
    "coupon_open"=>trim($_GPC["coupon_open"]),
    "red_jump_link"=>trim($_GPC["red_jump_link"]),
    "cid"=>trim($_GPC["cid"]),
    "pcid"=>trim($_GPC["pcid"]),
    "coupon_deputy_num"=>trim($_GPC["coupon_deputy_num"]),
    "top_tips"=>trim($_GPC["top_tips"]),
    "top_tips_red"=>trim($_GPC["top_tips_red"]),
    "closed_wish"=>trim($_GPC["closed_wish"]),
    "open_wish"=>trim($_GPC["open_wish"]),
    "open_tips"=>trim($_GPC["open_tips"]),
    "open_coupon_wish"=>trim($_GPC["open_coupon_wish"]),
    "per"=>trim($_GPC["per"]),
    "audio_volume"=>trim($_GPC["audio_volume"]),
    "entry_audio_text"=>trim($_GPC["entry_audio_text"]),
    "red_audio_text"=>trim($_GPC["red_audio_text"]),
    "image_logo"=>trim($_GPC["image_logo"]),
    "image_body"=>trim($_GPC["image_body"]),
    "description"=>trim($_GPC["description"]),
    "begintime"=>strtotime($_GPC["begintime"]),
    "endtime"=>strtotime($_GPC["endtime"]),
    "validate_open"=>trim($_GPC["validate_open"]),
    "qrcode_num"=>trim($_GPC["qrcode_num"]),
    "start_money"=>trim($_GPC["start_money"]),
    "end_money"=>trim($_GPC["end_money"]),
    "money_sum"=>trim($_GPC["money_sum"]),
    "pay_desc"=>trim($_GPC["pay_desc"])
    );
				$image_logo = $_FILES["image_logo"];
				if ($image_logo) {
					$image_path = $this->upload_image($image_logo);
					if (empty($image_path)) {
						$data["sta"] = 0;
						$data["error"] = "LOGO图片上传错误";
						echo json_encode($data);
						exit;
					}
					$data_insert["image_logo"] = $image_path;
				}
				$image_body = $_FILES["image_body"];
				if ($image_body) {
					$image_path = $this->upload_image($image_body);
					if (empty($image_path)) {
						$data["sta"] = 0;
						$data["error"] = "背景图片上传错误";
						echo json_encode($data);
						exit;
					}
					$data_insert["image_body"] = $image_path;
				}
				$share_img = $_FILES["share_img"];
				if ($share_img) {
					$image_path = $this->upload_image($share_img);
					if (empty($image_path)) {
						$data["sta"] = 0;
						$data["error"] = "分享图片上传错误";
						echo json_encode($data);
						exit;
					}
					$data_insert["share_img"] = $image_path;
				}
				$cuteface_image = $_FILES["cuteface_image"];
				if ($pid == 6 && $cuteface_image) {
					$image_path = $this->upload_image($cuteface_image);
					if (empty($image_path)) {
						$data["sta"] = 0;
						$data["error"] = "擂主颜值图片上传错误";
						echo json_encode($data);
						exit;
					}
					$data_insert["cuteface_image"] = $image_path;
				}
				$image_command = $_FILES["image_command"];
				if ($pid == 2 && $image_command) {
					$image_path = $this->upload_image($image_command);
					if (empty($image_path)) {
						$data["sta"] = 0;
						$data["error"] = "口令获取提示图上传错误";
						echo json_encode($data);
						exit;
					}
					$data_insert["image_command"] = $image_path;
				}
				$image_task = $_FILES["image_task"];
				if ($pid == 1 && $image_task) {
					$image_path = $this->upload_image($image_task);
					if (empty($image_path)) {
						$data["sta"] = 0;
						$data["error"] = "任务样例图上传错误";
						echo json_encode($data);
						exit;
					}
					$data_insert["image_task"] = $image_path;
				}
				$sum_money_all = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid AND type<2 AND status=1", array(":shopid" => $shopid));
				$sum_money = $sum_money_all["sum_money"];
				$sum_money_use = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid AND type>1 AND status=1", array(":shopid" => $shopid));
				$use_money = $sum_money_use["sum_money"];
				if (empty($id)) {
					if (round($data_insert["start_money"] * $data_insert["qrcode_num"] * 100) > round($data_insert["money_sum"] * 100) || round($data_insert["end_money"] * $data_insert["qrcode_num"] * 100) < round($data_insert["money_sum"] * 100)) {
						$data["sta"] = 0;
						$data["error"] = "红包金额不在正常范围内";
						echo json_encode($data);
						exit;
					}
					if ($data_insert["money_sum"] && $sum_money - $use_money - $data_insert["money_sum"] < 0) {
						$data["sta"] = 0;
						$data["error"] = "账户余额不足，请先充值";
						echo json_encode($data);
						exit;
					}
					if (empty($pid)) {
						$data["sta"] = 0;
						$data["error"] = "请先选择一个模式";
						echo json_encode($data);
						exit;
					}
					if ($shop["check_open"] < 2) {
						$send_temp_ms = 1;
						$data_insert["status"] = 4;
					} else {
						$data_insert["status"] = intval($_GPC["status"]);
					}
					$data_insert["edit_open"] = 1;
					if ($cfg["sl_pay"] == 1 && $cfg["sub_mch_id"]) {
						$data_insert["payway"] = 1;
					} else {
						$data_insert["payway"] = 0;
					}
					$data_insert["use_balance"] = 1;
					$data_insert["pay_desc"] = trim($_GPC["pay_desc"]);
					$data_insert["refund_open"] = 0;
					pdo_insert(TABLE_ACTIVITY, $data_insert);
					$insertid = pdo_insertid();
					if (!$insertid) {
						$data["sta"] = 0;
						$data["error"] = "数据添加失败";
						echo json_encode($data);
						exit;
					}
				}
				if ($shop_activity) {
					$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where aid = :id", array(":id" => $shop_activity["id"]));
					if ($count_qrcode > $data_insert["qrcode_num"]) {
						$data["sta"] = 0;
						$data["error"] = "红包个数不能小于已生成二维码个数";
						echo json_encode($data);
						exit;
					}
					if ($shop_activity["use_balance"]) {
						$payment = pdo_fetch("SELECT * FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid  AND aid = :aid", array(":shopid" => $shopid, ":aid" => $shop_activity["id"]));
						if ($payment["type"] == 3 && $payment["status"] == 1) {
							$data["sta"] = 0;
							$data["error"] = "活动已结算，不能编辑";
							echo json_encode($data);
							exit;
						}
						if ($data_insert["money_sum"] && $sum_money - $use_money - $data_insert["money_sum"] + $payment["money"] < 0) {
							$data["sta"] = 0;
							$data["error"] = "账户余额不足，请先充值";
							echo json_encode($data);
							exit;
						}
					}
					$sum_money_send = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_RED) . " WHERE aid='{$shop_activity["id"]}'");
					if ($sum_money_send["sum_money"] > 0) {
						$qrcode_use_count = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_RED) . " where aid='{$shop_activity["id"]}'");
						$surplus_red = $data_insert["qrcode_num"] - $qrcode_use_count;
						$surplus_money = $data_insert["money_sum"] - $sum_money_send["sum_money"];
						$start_all = $data_insert["start_money"] * $surplus_red;
						$end_all = $data_insert["end_money"] * $surplus_red;
						if ($surplus_red > 0 && (round($start_all * 100) > round($surplus_money * 100) || round($end_all * 100) < round($surplus_money * 100))) {
							$data["sta"] = 0;
							$data["error"] = "红包总金额错误";
							echo json_encode($data);
							exit;
						} else {
							if ($surplus_red < 1 && round($sum_money_send["sum_money"] * 100) != round($data_insert["money_sum"] * 100)) {
								$data["sta"] = 0;
								$data["error"] = "红包金额不在正常范围内";
								echo json_encode($data);
								exit;
							}
						}
					} else {
						if (round($data_insert["start_money"] * $data_insert["qrcode_num"] * 100) > round($data_insert["money_sum"] * 100) || round($data_insert["end_money"] * $data_insert["qrcode_num"] * 100) < round($data_insert["money_sum"] * 100)) {
							$data["sta"] = 0;
							$data["error"] = "红包金额不在正常范围内";
							echo json_encode($data);
							exit;
						}
					}
					if ($shop_activity["payway"]) {
						$data_insert["send_name"] = trim($_GPC["send_name"]);
						$data_insert["wish"] = trim($_GPC["wish"]);
						$data_insert["red_name"] = trim($_GPC["red_name"]);
					} else {
						$data_insert["pay_desc"] = trim($_GPC["pay_desc"]);
					}
					if (empty($shop["check_open"])) {
						$send_temp_ms = 1;
						$data_insert["status"] = 4;
					} else {
						$data_insert["status"] = intval($_GPC["status"]);
					}
					pdo_update(TABLE_ACTIVITY, $data_insert, array("id" => $shop_activity["id"]));
					$insertid = $shop_activity["id"];
				}
				if (($shop_activity["use_balance"] || $data_insert["use_balance"]) && $insertid && $data_insert["money_sum"]) {
					$data_pinance = array("uniacid" => $uniacid, "openid" => $_W["openid"], "shopid" => $shopid, "aid" => $insertid, "type" => 2, "status" => 1, "money" => $data_insert["money_sum"], "order_no" => '', "createtime" => time());
					if (empty($payment)) {
						pdo_insert(TABLE_FINANCE, $data_pinance);
					} else {
						pdo_update(TABLE_FINANCE, $data_pinance, array("id" => $payment["id"]));
					}
				}
				$cfg = $this->module["config"]["api"];
				if ($cfg["mid_check"] && $cfg["openid"] && $send_temp_ms == 1) {
					$template = array("touser" => $cfg["openid"], "template_id" => $cfg["mid_check"], "url" => '', "topcolor" => "#743a3a", "data" => array("first" => array("value" => urlencode("有商家修改了活动信息，赶紧去审核吧"), "color" => "#2F1B58"), "keyword1" => array("value" => urlencode($data_insert["name"]), "color" => "#2F1B58"), "keyword2" => array("value" => urlencode($shop["name"]), "color" => "#2F1B58"), "keyword3" => array("value" => urlencode(date("Y-m-d H:i:s", time())), "color" => "#2F1B58"), "remark" => array("value" => urlencode("请进入系统后台活动列表审核"), "color" => "#2F1B58")));
					$this->send_temp_ms(urldecode(json_encode($template)));
				}
				$excel = $_FILES["excel"];
				if ($pid == 4 && $excel["name"] && $excel["tmp_name"]) {
					$type = explode(".", $excel["name"]);
					$type = end($type);
					$inputFileType = '';
					if ($type == "xls") {
						$inputFileType = "Excel5";
					} else {
						if ($type == "xlsx") {
							$inputFileType = "Excel2007";
						}
					}
					if (!$inputFileType) {
						$data["sta"] = 0;
						$data["error"] = "上传数据不是excel文件";
						echo json_encode($data);
						exit;
					}
					set_time_limit(0);
					include_once IA_ROOT . "/framework/library/phpexcel/PHPExcel.php";
					include_once IA_ROOT . "/framework/library/phpexcel/PHPExcel/IOFactory.php";
					include_once IA_ROOT . "/framework/library/phpexcel/PHPExcel/Reader/Excel5.php";
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($excel["tmp_name"]);
					$objWorksheet = $objPHPExcel->getActiveSheet();
					$highestRow = $objWorksheet->getHighestRow();
					$all_column = $objWorksheet->getHighestColumn();
					$wrong = 0;
					$row = 2;
					while ($row <= $highestRow) {
						$code = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
						$code1 = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
						$code2 = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
						$data1 = array("aid" => intval($insertid), "uniacid" => intval($uniacid), "name" => trim($code), "phone" => trim($code1), "comment" => trim($code2));
						$import_user = pdo_fetch("SELECT * FROM " . tablename(TABLE_IMPORT_MODE) . " WHERE aid = :aid AND name = :name AND phone=:phone", array(":aid" => $insertid, ":name" => $data1["name"], ":phone" => $data1["phone"]));
						if (!$import_user) {
							$mess = pdo_insert(TABLE_IMPORT_MODE, $data1);
							if (!$mess) {
								$wrong++;
							}
						} else {
							$wrong++;
						}
						$row++;
					}
					if ($wrong > 0) {
						$data["sta"] = 0;
						$data["error"] = "共有" . $wrong . "条记录未导入，其他数据保存成功";
						echo json_encode($data);
						exit;
					}
				}
				if ($pid == 4 && empty($excel["name"]) && empty($excel["tmp_name"]) && $copy == 1) {
					$import_users = pdo_fetchall("select * from " . tablename(TABLE_IMPORT_MODE) . " WHERE aid = :aid", array(":aid" => intval($_GPC["id"])));
					if ($import_users) {
						foreach ($import_users as $copy_import_user) {
							$data_import_user = array("aid" => intval($insertid), "uniacid" => intval($uniacid), "name" => trim($copy_import_user["name"]), "phone" => trim($copy_import_user["phone"]), "comment" => trim($copy_import_user["comment"]));
							$import_user = pdo_fetch("SELECT * FROM " . tablename(TABLE_IMPORT_MODE) . " WHERE aid = :aid AND name = :name AND phone=:phone", array(":aid" => $insertid, ":name" => $data_import_user["name"], ":phone" => $data_import_user["phone"]));
							if ($import_user) {
								continue;
							}
							pdo_insert(TABLE_IMPORT_MODE, $data_import_user);
						}
					}
				}
				echo json_encode(array("sta" => 1, "error" => "success"));
				exit;
			}
			if (empty($id) || $copy && $shop_activity["endtime"] && time() >= $shop_activity["endtime"]) {
				$shop_activity["begintime"] = date("Y-m-d H:i", $_W["timestamp"]);
				$shop_activity["endtime"] = date("Y-m-d H:i", strtotime(" +1 year"));
			}
			if (empty($id) || $copy && $shop_activity["endtime"] && time() >= $shop_activity["endtime"]) {
				$shop_activity["start_success_time"] = 10.0;
				$shop_activity["end_success_time"] = 10.0;
			}
			if (empty($id)) {
				$shop_activity["audio_volume"] = "1.0";
				$shop_activity["hint"] = "加微信号获取口令";
				$shop_activity["invitation_tip"] = "#昵称#，您好，邀请#邀请人数#人参加活动可领红包，目前还差#还差人数#人";
				$shop_activity["cuteface_name"] = "老板的颜值";
				$shop_activity["challenge_rule"] = "挑战#最小时间#秒到#最大时间#秒，成功后可领红包";
				$shop_activity["click_tip_before"] = "#昵称#，这个红包被封印了，请根据红包码提示解除封印";
				$shop_activity["click_tip"] = "您好，#昵称#，目前还差#还差人数#人可开启红包";
				$shop_activity["countdown_tip"] = "倒计时结束即可领取红包,如需减少时间请按红包码提示操作";
				$shop_activity["share_tips"] = "今日次数用完啦，根据红包码提示操作获取更多次数";
				$shop_activity["share_title"] = "我是#昵称#，在#活动#需要帮助";
				$shop_activity["share_desc"] = "我是#昵称#，在#活动#需要帮助，点击查看详情";
				$shop_activity["top_tips"] = "您好,#昵称#，本次扫码您有机会获得#最大金额#红包";
				$shop_activity["top_tips_red"] = "恭喜,#昵称#刚刚领取了#金额#红包";
				$shop_activity["open_tips"] = "请在微信服务通知中领取红包";
				$shop_activity["open_coupon_wish"] = "恭喜你还获得了#数量#张卡券，请到对应门店核销";
				$shop_activity["wish"] = "感谢您参加扫码领红包活动";
				$shop_activity["pay_desc"] = "您在#活动#中获得的#金额#元红包";
				$shop_activity["entry_audio_text"] = "您好，#昵称#，欢迎参加#活动#，本次活动您有机会领取#最大金额#元红包";
				$shop_activity["red_audio_text"] = "恭喜，#昵称#，您在#活动#中获得了#金额#元红包，同时获赠#卡券#张卡券，请到对应门店核销";
			}
			if ($shop_activity["rules"]) {
				$rules_arr = json_decode($shop_activity["rules"], true);
				$rules_str = '';
				foreach ($rules_arr as $value) {
					$value_str = implode(",", $value);
					$rules_str .= $value_str . "\r\n";
				}
			}
			$shop_activity["rules"] = $shop_activity["rules"] ? $rules_str : '';
			if ($shop_activity["buy_rules"]) {
				$buy_rules_arr = json_decode($shop_activity["buy_rules"], true);
				$buy_rules_str = '';
				foreach ($buy_rules_arr as $value) {
					$value_str = implode(",", $value);
					$buy_rules_str .= $value_str . "\r\n";
				}
			}
			$shop_activity["buy_rules"] = $shop_activity["buy_rules"] ? $buy_rules_str : '';
			if ($pid) {
				include $this->template("new_activity");
			} else {
				include $this->template("pattern");
			}
			exit;
		}
	}
}
$condition = "sid='{$shopid}'";
$status = intval($_GPC["status"]);
if ($status == 1) {
	$condition .= " AND endtime<{$_W["timestamp"]} AND endtime>0";
} else {
	if ($status == 2) {
		$condition .= " AND (endtime=0 OR endtime>={$_W["timestamp"]}) AND {$_W["timestamp"]}>=begintime AND status=1";
	} else {
		if ($status == 4) {
			$condition .= " AND  status = 4 AND (endtime=0 OR endtime>={$_W["timestamp"]})";
		}
	}
}
$activity_list = pdo_fetchall("SELECT * FROM " . tablename(TABLE_ACTIVITY) . " WHERE {$condition} ORDER BY createtime DESC");
if ($activity_list) {
	foreach ($activity_list as &$val) {
		if ($val["url_key"]) {
			$val["entry_url"] = $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&aid=" . $val["id"] . "&k=" . $val["url_key"];
		} else {
			$val["entry_url"] = $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&aid=" . $val["id"];
		}
		
		$val["register_url"] = $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&op=register&aid=" . $val["id"];
		if ($val["subscribe"] == 2) {
			if (empty($val["qrcode_url"])) {
				$res_get = $this->get_qrcode_url("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaared" . $val["id"], $val["qrcode_type"]);
				$val["qrcode_url"] = $res_get["url"];
				if ($res_get["url"]) {
					pdo_update(TABLE_ACTIVITY, array("qrcode_url" => $res_get["url"]), array("id" => $val["id"]));
				}
			}
		} else {
			$val["qrcode_url"] = $val["entry_url"];
		}
		$val["entry_url_base"] = base64_encode($val["qrcode_url"]);
		$val["register_url_base"] = base64_encode($val["register_url"]);
		if ($val["pattern"] == 3) {
			$val["register_url"] = $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&op=register&aid=" . $val["id"];
		}
		$sum_money_act = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_RED) . " WHERE aid='{$val["id"]}' AND status=1");
		$val["surplus_money"] = $val["money_sum"] - $sum_money_act["sum_money"];
		$qrcode_count = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_RED) . " where aid='{$val["id"]}'");
		$val["surplus_red"] = $val["qrcode_num"] - $qrcode_count;
		$val["qrcode_count"] = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where aid='{$val["id"]}' ");
		$val["qrcode_count_band"] = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where aid='{$val["id"]}' AND bid>0 ");
		$val["qrcode_count_notband"] = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where aid='{$val["id"]}' AND bid>0 AND status=0");
	}
}
$beforehand_list = pdo_fetchall("select bid from " . tablename(TABLE_QRCODE) . " WHERE sid='{$shopid}' GROUP BY bid");
foreach ($beforehand_list as &$value) {
	$beforehand_name = pdo_fetch("select name from " . tablename(TABLE_BEFOREHAND) . " where id='{$value["bid"]}'");
	$value["name"] = $beforehand_name["name"];
}
include $this->template("activity");