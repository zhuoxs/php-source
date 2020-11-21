<?php



//decode by http://www.yunlu99.com/

defined("IN_IA") or exit("Access Denied");

global $_GPC, $_W;

checklogin();

$uniacid = intval($_W["uniacid"]);

load()->func("tpl");

$op = $_GPC["op"] ? $_GPC["op"] : "display";

$check_auth = $this->module["config"];

$id = intval($_GPC["id"]);

if ($id) {

	$set = pdo_fetch("SELECT * FROM " . tablename(TABLE_BEFOREHAND) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $id));

	if (empty($set)) {

		message("数据错误！", '', "error");

	}

}

if ($op == "create_qrcode") {

	if (empty($set) || $set["qrcode_num"] < 1) {

		echo json_encode(array("sta" => 0, "error" => "数据错误"));

		exit;

	}

	$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where bid = :id", array(":id" => $id));

	if ($count_qrcode >= $set["qrcode_num"]) {

		echo json_encode(array("sta" => 2, "count" => $set["qrcode_num"]));

		exit;

	}

	$temp_min = 50;

	$qrcode_max_code = pdo_fetch("select code from " . tablename(TABLE_QRCODE) . " where bid = :id ORDER BY code DESC", array(":id" => $id));

	$max_code = $qrcode_max_code["code"] ? $qrcode_max_code["code"] : 0;

	$temp_count = min($temp_min, $set["qrcode_num"] - $count_qrcode);

	$account_api = WeAccount::create();

	$x = 1;

	while ($x <= $temp_count) {

		$uuid = $this->get_uuid($id, $uniacid);

		$code = $max_code + $x;

		

		if ($set["subscribe"] == 2) {

			$set["qrcode_type"] = $set["qrcode_one"] ? 0 : $set["qrcode_type"];

			$res_get = $this->get_qrcode_url($uuid . "red" . $id, $set["qrcode_type"]);

			$qrcode = $res_get["url"];

		}

		//$data = array("uniacid" => $uniacid, "uuid" => $uuid, "aid" => $id, "qrcode" => $qrcode ? $qrcode : '', "status" => 0, "createtime" => time());

		//pdo_insert(TABLE_QRCODE, $data);

		

		//$qrcode = $_W["siteroot"] . "addons/crad_qrcode_red/s.php?" . $uuid;

		$data = array("uniacid" => $uniacid, "uuid" => $uuid, "aid" => 0, "qrcode" => $qrcode ? $qrcode : '', "bid" => $id, "code" => $code, "status" => 0, "createtime" => time());

		pdo_insert(TABLE_QRCODE, $data);

		$x++;

	}

	echo json_encode(array("sta" => 1, "count" => $count_qrcode + $temp_count));

	exit;

} else {

	if ($op == "move_qrcode") {

		$sbid = intval($_GPC["sbid"]);

		$cid = intval($_GPC["cid"]);

		if (empty($cid) || empty($sbid)) {

			echo json_encode(array("sta" => 0, "error" => "参数错误"));

			exit;

		}

		if ($cid == $uniacid) {

			echo json_encode(array("sta" => 0, "error" => "不能同公众号互转"));

			exit;

		}

		$accounts_list = module_link_uniacid_fetch($_W["uid"], "crad_qrcode_red");

		$has_account = 0;

		foreach ($accounts_list as $key => $value) {

			if ($value["uniacid"] == $cid) {

				$has_account = 1;

				break;

			}

		}

		if (empty($has_account)) {

			echo json_encode(array("sta" => 0, "error" => "您没有该公众号的权限"));

			exit;

		}

		$beforehand = pdo_fetch("SELECT id,name,qrcode_num FROM " . tablename(TABLE_BEFOREHAND) . " WHERE uniacid = :uniacid AND sbid = :id", array(":uniacid" => $cid, ":id" => $sbid));

		$source_beforehand = pdo_fetch("SELECT id,sbid,name,qrcode_num FROM " . tablename(TABLE_BEFOREHAND) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $sbid));

		$beforehand_have = pdo_fetch("SELECT id,qrcode_num FROM " . tablename(TABLE_BEFOREHAND) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $cid, ":id" => $source_beforehand["sbid"]));

		if (empty($source_beforehand)) {

			echo json_encode(array("sta" => 0, "error" => "数据错误"));

			exit;

		}

		if (empty($beforehand) && empty($beforehand_have)) {

			$ymd_day = date("Ymd");

			$data["name"] = $source_beforehand["name"] . "[转移" . $ymd_day . "]";

			$data["uniacid"] = $cid;

			$data["status"] = 1;

			$data["sbid"] = $sbid;

			$data["qrcode_num"] = 0;

			$data["createtime"] = time();

			pdo_insert(TABLE_BEFOREHAND, $data);

			$new_bid = pdo_insertid();

		}

		if ($beforehand["id"]) {

			$new_bid = $beforehand["id"];

		}

		if ($beforehand_have["id"]) {

			$new_bid = $beforehand_have["id"];

		}

		$start_code = intval($_GPC["start_code"]);

		$end_code = intval($_GPC["end_code"]);

		$band_num = intval($_GPC["band_num"]);

		$bid_max_min = pdo_fetch("SELECT MAX(code) as max_id,MIN(code) as min_id FROM " . tablename(TABLE_QRCODE) . " where bid = :id AND aid<1 AND sid<1", array(":id" => $sbid));

		if (empty($bid_max_min["max_id"]) || empty($bid_max_min["min_id"])) {

			echo json_encode(array("sta" => 0, "error" => "参数错误"));

			exit;

		}

		$min_code = $start_code ? max($start_code, $bid_max_min["min_id"]) : $bid_max_min["min_id"];

		$max_code = $end_code ? min($end_code, $bid_max_min["max_id"]) : $bid_max_min["max_id"];

		$count_qrcode_code = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE bid = :id AND aid<1 AND sid<1 AND code<={$max_code} AND code>={$min_code}", array(":id" => $sbid));

		$count_qrcode_code = $count_qrcode_code ? $count_qrcode_code : 0;

		$band_num = $band_num ? $band_num : $count_qrcode_code;

		if ($count_qrcode_code < $band_num) {

			echo json_encode(array("sta" => 0, "error" => "预印码数量不足"));

			exit;

		}

		$count_qrcode_move = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE bid = :id AND aid<1 AND sid<1 AND sbid>0 AND code<={$max_code} AND code>={$min_code}", array(":id" => $sbid));

		$count_qrcode_move = $count_qrcode_move ? $count_qrcode_move : 0;

		if ($count_qrcode_move > 0) {

			pdo_query("UPDATE " . tablename(TABLE_QRCODE) . " SET uniacid={$cid},bid={$new_bid} WHERE bid = :id AND aid<1 AND sid<1 AND sbid>0 AND code<={$max_code} AND code>={$min_code} ORDER BY code ASC LIMIT {$count_qrcode_move}", array(":id" => $sbid));

		}

		$count_no = $band_num - $count_qrcode_move;

		if ($count_no > 0) {

			pdo_query("UPDATE " . tablename(TABLE_QRCODE) . " SET uniacid={$cid},suniacid={$uniacid},sbid={$sbid},bid={$new_bid} WHERE bid = :id AND aid<1 AND sid<1 AND sbid<1 AND code<={$max_code} AND code>={$min_code} ORDER BY code ASC LIMIT {$count_no}", array(":id" => $sbid));

		}

		if ($source_beforehand["sbid"]) {

			pdo_update(TABLE_BEFOREHAND, array("qrcode_num" => $source_beforehand["qrcode_num"] - $band_num), array("id" => $sbid));

		} else {

			pdo_update(TABLE_BEFOREHAND, array("qrcode_num" => $beforehand["qrcode_num"] ? $beforehand["qrcode_num"] + $band_num : $band_num), array("id" => $new_bid));

		}

		echo json_encode(array("sta" => 1, "count" => $band_num));

		exit;

	} else {

		if ($op == "get_not_band") {

			$sid = intval($_GPC["sid"]);

			if ($sid) {

				$where = "bid ='{$id}' AND aid<1 AND (sid<1 OR sid='{$sid}')";

			} else {

				$where = "bid ='{$id}' AND aid<1 AND sid<1";

			}

			$qrcode_not_band = pdo_fetchall("select code from " . tablename(TABLE_QRCODE) . " WHERE {$where} ORDER BY code ASC", array(":id" => $id));

			if (empty($qrcode_not_band)) {

				$beforehand_row["not_band"] = "无未绑号段";

			} else {

				$beforehand_row["not_band"] = "未绑号段:" . $this->section_code($qrcode_not_band);

			}

			echo json_encode($beforehand_row);

			exit;

		} else {

			if ($op == "download_qrcode") {

				$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where bid = :id", array(":id" => $id));

				if (empty($set) || $count_qrcode < 1) {

					echo json_encode(array("sta" => 0, "error" => "请先生成二维码"));

					exit;

				}

				$pindex = max(1, intval($_GPC["page"]));

				$psize = 20;

				$list_qrcode = pdo_fetchall("SELECT id,bid,uuid,code,qrcode FROM " . tablename(TABLE_QRCODE) . " where bid = :id ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":id" => $id));

				if (empty($list_qrcode)) {

					echo json_encode(array("sta" => 2));

					exit;

				}

				foreach ($list_qrcode as $value) {

					$this->get_qrcode($value["id"], $value["uuid"], 0, $id, $value["code"], $value["qrcode"]);

				}

				echo json_encode(array("sta" => 1, "count" => ($pindex - 1) * $psize + count($list_qrcode)));

				exit;

			} else {

				if ($op == "download_qrcode_notuse") {

					$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE bid = :id AND aid<1 AND sid<1", array(":id" => $id));

					if (empty($set) || $count_qrcode < 1) {

						echo json_encode(array("sta" => 0, "error" => "没有未绑定二维码"));

						exit;

					}

					$pindex = max(1, intval($_GPC["page"]));

					$psize = 20;

					$list_qrcode = pdo_fetchall("SELECT id,bid,uuid,code,qrcode FROM " . tablename(TABLE_QRCODE) . " WHERE bid = :id AND aid<1 AND sid<1 ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":id" => $id));

					if (empty($list_qrcode)) {

						echo json_encode(array("sta" => 2));

						exit;

					}

					foreach ($list_qrcode as $value) {

						$this->get_qrcode($value["id"], $value["uuid"], 0, $id, $value["code"], $value["qrcode"]);

					}

					echo json_encode(array("sta" => 1, "count" => ($pindex - 1) * $psize + count($list_qrcode)));

					exit;

				} else {

					if ($op == "download_qrcode_zip") {

						$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE bid = :id", array(":id" => $id));

						if (empty($set) || $count_qrcode < 1) {

							message("请先生成二维码", '', "error");

						}

						load()->func("file");

						$qrcode_path = ATTACHMENT_ROOT . "crad_qrcode_red/b" . $id . "/qrcode/";

						if (!is_dir($qrcode_path)) {

							if (function_exists("mkdirs")) {

								$dir = mkdirs($qrcode_path);

							} else {

								$dir = mkdir($qrcode_path, 0777, true);

							}

						}

						$qrcode_zip = $qrcode_path . $id . ".zip";

						if (file_exists($qrcode_zip)) {

							file_delete($qrcode_zip);

						}

						$zip = new ZipArchive();

						if ($zip->open($qrcode_zip, ZipArchive::CREATE) === TRUE) {

							$this->addFileToZip($qrcode_path, $zip);

							$zip->close();

						} else {

							message("生成压缩文件失败，请稍后重试！", '', "error");

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

							header("Content-Disposition:attachment; filename=\"" . $id . ".zip\"");

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

							message("下载失败，请稍后重试！", '', "error");

						}

					} else {

						if ($op == "download_excel") {

							$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where bid = :id", array(":id" => $id));

							if (empty($set) || $count_qrcode < 1) {

								message("请先生成二维码！", '', "error");

							}

							$list_excel = pdo_fetchall("SELECT id,uuid,bid,sbid,code,qrcode FROM " . tablename(TABLE_QRCODE) . " where bid = :id", array(":id" => $id));

							foreach ($list_excel as $key => $value) {

								$arr[$i]["id"] = $value["id"];

								$arr[$i]["code"] = ($value["sbid"] ? $value["sbid"] : $value["bid"]) . "_" . $value["code"];

								$arr[$i]["url"] = $value["qrcode"] ? $value["qrcode"] : $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&uuid=" . $value["uuid"] . "&code=" . $value["code"];

								$i++;

							}

							$this->exportexcel($arr, array("ID", "编号", "二维码参数"), "二维码列表-" . $set["name"]);

							exit;

						} else {

							if ($op == "download_txt") {

								$count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where bid = :id", array(":id" => $id));

								if (empty($set) || $count_qrcode < 1) {

									message("请先生成二维码！", '', "error");

								}

								ob_clean();

								header("Content-type:application/octet-stream");

								header("Accept-Ranges:bytes ");

								header("Content-Disposition:attachment;filename=二维码列表-" . $set["name"] . ".txt");

								header("Expires:0");

								header("Cache-Control:must-revalidate,post-check=0,pre-check=0");

								header("Pragma:public");

								$list_excel = pdo_fetchall("SELECT id,uuid,bid,sbid,code,qrcode FROM " . tablename(TABLE_QRCODE) . " where bid = :id", array(":id" => $id));

								echo "ID 编号 二维码参数\r\n";

								foreach ($list_excel as $key => $value) {

									$id_q = $value["id"];

									$code_q = ($value["sbid"] ? $value["sbid"] : $value["bid"]) . "_" . $value["code"];

									$url_q = $value["qrcode"] ? $value["qrcode"] : $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&uuid=" . $value["uuid"] . "&code=" . $value["code"];

									echo $id_q . " " . $code_q . " " . $url_q . "\r\n";

								}

								@flush();

								@ob_flush();

								exit;

							} else {

								if ($op == "del") {

									$id = intval($_GPC["id"]);

									$item = pdo_fetch("SELECT * FROM " . tablename(TABLE_BEFOREHAND) . " WHERE id = :id", array(":id" => $id));

									if (empty($item)) {

										message("抱歉，数据不存在或是已经删除！", referer(), "error");

									}

									if ($item["uniacid"] != $uniacid) {

										message("您没有权限操作");

									}

									if (pdo_delete(TABLE_BEFOREHAND, array("id" => $id)) === false) {

										message("删除失败！", referer(), "error");

									} else {

										pdo_delete(TABLE_QRCODE, array("bid" => $id));

										message("删除成功！", referer());

									}

								} else {

									if ($op == "deleteids") {

										$rowcount = 0;

										$notrowcount = 0;

										foreach ($_GPC["ids"] as $k => $id) {

											$id = intval($id);

											if (!empty($id)) {

												$item_task = pdo_fetch("SELECT * FROM " . tablename(TABLE_BEFOREHAND) . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));

												if (!empty($item_task)) {

													pdo_delete(TABLE_BEFOREHAND, array("id" => $id));

													$rowcount++;

												} else {

													$notrowcount++;

												}

											}

										}

										$this->message("操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!", '', 0);

									} else {

										if ($op == "deleteall") {

											$search = "uniacid='{$uniacid}'";

											pdo_delete(TABLE_BEFOREHAND, $search);

											message("删除成功", referer(), "success");

										} else {
                                            if ($op == "band_list") {
                                                $aid = intval($_GPC["aid"]);
                                                $sid = intval($_GPC["sid"]);
                                                $type = intval($_GPC["type"]);
                                                $activity_info = pdo_fetchall("select id,name from " . tablename(TABLE_ACTIVITY) . " where uniacid='{$uniacid}'");
                                                $condition = "WHERE uniacid='{$uniacid}' AND bid = '{$id}'";
                                                if ($aid) {
                                                    $condition .= " AND aid = '{$aid}'";
                                                } else {
                                                    if ($type == 2) {
                                                        $condition .= " AND aid>0";
                                                    }
                                                }
                                                if ($sid) {
                                                    $condition .= " AND sid = '{$sid}'";
                                                } else {
                                                    if ($type == 1) {
                                                        $condition .= " AND sid>0";
                                                    }
                                                }
                                                if ($type == 1) {
                                                    $fields = "sid";
                                                } else {
                                                    $fields = "aid";
                                                }
                                                $list = pdo_fetchall("SELECT {$fields} FROM " . tablename(TABLE_QRCODE) . " {$condition}  GROUP BY {$fields}");
                                                if ($list) {
                                                    foreach ($list as $key => &$value) {
                                                        if ($type == 1) {
                                                            $shop_name = pdo_fetch("SELECT name FROM " . tablename(TABLE_SHOP) . " WHERE id = :id", array(":id" => $value["sid"]));
                                                            $shop_info[$key]["id"] = $value["aid"];
                                                            $shop_info[$key]["name"] = $shop_name["name"];
                                                            $value["name"] = $shop_name["name"];
                                                            $qrcode_all = pdo_fetchall("select code from " . tablename(TABLE_QRCODE) . " WHERE bid='{$id}' AND sid='{$value["sid"]}' ORDER BY code ASC");
                                                            $value["code"] = $qrcode_all ? $this->section_code($qrcode_all) : '';
                                                        } else {
                                                            $activity_name = pdo_fetch("SELECT name FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $value["aid"]));
                                                            $activity_info[$key]["id"] = $value["aid"];
                                                            $activity_info[$key]["name"] = $activity_name["name"];
                                                            $value["name"] = $activity_name["name"];
                                                            $qrcode_all = pdo_fetchall("select code from " . tablename(TABLE_QRCODE) . " WHERE bid='{$id}' AND aid='{$value["aid"]}' ORDER BY code ASC");
                                                            $value["code"] = $qrcode_all ? $this->section_code($qrcode_all) : '';
                                                        }
                                                    }
                                                }
                                                include $this->template("band_list");
                                                exit;
                                            }
											if ($op == "post") {

												if (checksubmit("submit")) {

													if (empty($_GPC["name"])) {

														message("请输入名称！", '', "error");

													}

													if (!empty($set)) {

														$has_name = pdo_fetch("SELECT id FROM " . tablename(TABLE_BEFOREHAND) . " WHERE uniacid = :uniacid AND name = :name  AND id != :id", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"]), ":id" => $id));

													} else {

														$has_name = pdo_fetch("SELECT id FROM " . tablename(TABLE_BEFOREHAND) . " WHERE uniacid = :uniacid AND name = :name", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"])));

													}

													if ($has_name) {

														message("名称已经存在！", '', "error");

													}

													$data["name"] = trim($_GPC["name"]);

													$data["uniacid"] = $uniacid;

													$data["status"] = 1;

													$data["qrcode_num"] = intval($_GPC["qrcode_num"]);

													$data["createtime"] = time();

													if ($set) {

														pdo_update(TABLE_BEFOREHAND, $data, array("id" => $set["id"]));

													} else {

														pdo_insert(TABLE_BEFOREHAND, $data);

													}

													message("数据操作成功！", referer(), '');

												}

												include $this->template("beforehand");

											} else {

												$pindex = max(1, intval($_GPC["page"]));

												$psize = 10;

												$condition = "uniacid='{$uniacid}'";

												if (!empty($_GPC["keyword"])) {

													$condition .= " AND CONCAT(name) LIKE '%{$_GPC["keyword"]}%'";

												}

												$accounts_list = module_link_uniacid_fetch($_W["uid"], "crad_qrcode_red");

												foreach ($accounts_list as $key => $value) {

													if ($value["uniacid"] == $uniacid) {

														unset($accounts_list[$key]);

													}

												}

												$list = pdo_fetchall("select * from " . tablename(TABLE_BEFOREHAND) . "WHERE {$condition}  ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");

												if (!empty($list)) {

													foreach ($list as &$beforehand_row) {

														$qrcode_all = pdo_fetchall("select code from " . tablename(TABLE_QRCODE) . " WHERE bid='{$beforehand_row["id"]}' OR sbid='{$beforehand_row["id"]}' ORDER BY code ASC");

														$beforehand_row["qrcode_count"] = $qrcode_all ? count($qrcode_all) : 0;

														if ($beforehand_row["qrcode_count"] > 0) {

															if (empty($qrcode_all)) {

																$beforehand_row["qrcode_all"] = "无";

															} else {

																$beforehand_row["qrcode_all"] = $this->section_code($qrcode_all);

															}

															$qrcode_not_band = pdo_fetchall("select code from " . tablename(TABLE_QRCODE) . " WHERE bid = :id AND aid<1 AND sid<1 ORDER BY code ASC", array(":id" => $beforehand_row["id"]));

															if (empty($qrcode_not_band)) {

																$beforehand_row["not_band"] = "无";

															} else {

																$beforehand_row["not_band"] = $this->section_code($qrcode_not_band);

															}

															$qrcode_move = pdo_fetchall("select code from " . tablename(TABLE_QRCODE) . " WHERE sbid = :id ORDER BY code ASC", array(":id" => $beforehand_row["id"]));

															if (empty($qrcode_move)) {

																$beforehand_row["qrcode_move"] = "无";

															} else {

																$beforehand_row["qrcode_move"] = $this->section_code($qrcode_move);

															}

														}

													}

												}

												$total = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_BEFOREHAND) . " where {$condition}");

												$pager = pagination($total, $pindex, $psize);

												include $this->template("beforehand");

											}

										}

									}

								}

							}

						}

					}

				}

			}

		}

	}

}