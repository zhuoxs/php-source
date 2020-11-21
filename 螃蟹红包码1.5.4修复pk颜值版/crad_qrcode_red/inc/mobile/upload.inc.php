<?php

//decode by http://www.yunlu99.com/
defined("IN_IA") or exit("Access Denied");
set_time_limit(0);
error_reporting(0);
header("Content-type:application/json");
global $_GPC, $_W;
$uniacid = $_W["uniacid"];
$aid = intval($_GPC["aid"]);
$uuid = addslashes(trim($_GPC["uuid"]));
$openid = $_W["openid"];
$cfg = $this->module["config"]["api"];
load()->func("file");
if (empty($openid)) {
	$data["sta"] = 0;
	$data["error"] = "openid为空，配置错误或在非微信浏览器中打开";
	echo json_encode($data);
	die;
}
if (empty($uniacid)) {
	$data["sta"] = 0;
	$data["error"] = "参数错误";
	echo json_encode($data);
	die;
}
$activity = pdo_fetch("SELECT * FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :aid", array(":aid" => $aid));
$user = pdo_fetch("SELECT * FROM " . tablename(TABLE_USER) . " WHERE aid = :aid AND openid = :openid", array(":aid" => $aid, ":openid" => $openid));
if (empty($activity) || empty($user)) {
	$data["sta"] = 0;
	$data["error"] = "参数错误：数据异常";
	echo json_encode($data);
	die;
}
if ($activity["begintime"] && $_W["timestamp"] < $activity["begintime"]) {
	$data["sta"] = 0;
	$data["error"] = "活动还未开始";
	echo json_encode($data);
	die;
}
if ($activity["endtime"] && $_W["timestamp"] > $activity["endtime"]) {
	$data["sta"] = 0;
	$data["error"] = "活动已结束";
	echo json_encode($data);
	die;
}
if ($activity["begintime"] && $_W["timestamp"] < $activity["begintime"]) {
	$data["sta"] = 0;
	$data["error"] = "活动未开始";
	echo json_encode($data);
	exit;
}
if ($activity["endtime"] && $_W["timestamp"] > $activity["endtime"]) {
	$data["sta"] = 0;
	$data["error"] = "活动已结束";
	echo json_encode($data);
	exit;
}
if ($activity["status"] == 2) {
	$data["sta"] = 0;
	$data["error"] = "活动已暂停：" . $activity["stop_tips"];
	echo json_encode($data);
	exit;
}
if ($activity["status"] != 1) {
	$data["sta"] = 0;
	$data["error"] = "活动已关闭：";
	echo json_encode($data);
	exit;
}
if ($activity["pattern"] != 6 && $activity["pattern"] != 12) {
	$data["sta"] = 0;
	$data["error"] = "活动模式不匹配";
	echo json_encode($data);
	exit;
}
if ($activity["sid"]) {
	$shop = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP) . " WHERE id = :shopid", array(":shopid" => $activity["sid"]));
	if (empty($shop)) {
		$data["sta"] = 0;
		$data["error"] = "商家信息不存在";
		echo json_encode($data);
		die;
	}
	if ($shop["time_open"] && $shop["begintime"] && $_W["timestamp"] < $shop["begintime"]) {
		$data["sta"] = 0;
		$data["error"] = "商家授权开始时间未到";
		echo json_encode($data);
		die;
	}
	if ($shop["time_open"] && $shop["endtime"] && $_W["timestamp"] > $shop["endtime"]) {
		$data["sta"] = 0;
		$data["error"] = "商家授权时间已过";
		echo json_encode($data);
		die;
	}
}
if ($activity["statusd"] == 1 && $_COOKIE["gps"][$aid] != 1) {
	$data["sta"] = 0;
	$data["error"] = "您不在活动允许的地区内，请刷新页面试试";
	echo json_encode($data);
	exit;
}
if ($activity["statusd"] == 2 && $activity["site"] && $activity["sid"]) {
	if (empty($_COOKIE["lat"][$aid]) || empty($_COOKIE["lng"][$aid])) {
		$data["sta"] = 0;
		$data["error"] = "没获取到定位，请刷新页面试试";
		echo json_encode($data);
		exit;
	}
	if ($shop["latitude"] && $shop["longitude"]) {
		$distance = $this->GetDistance($shop["latitude"], $shop["longitude"], $_COOKIE["lat"][$aid], $_COOKIE["lng"][$aid]);
		if ($distance > $activity["site"] / 1000) {
			$data["sta"] = 0;
			$data["error"] = "您不在活动允许的地区内,请确定您手机是否开启了定位获取";
			echo json_encode($data);
			exit;
		}
	}
}
if ($activity["subscribe"] && empty($user["subscribe"])) {
	$data["sta"] = 0;
	$data["nosubscribe"] = 1;
	echo json_encode($data);
	exit;
}
$qrcode = pdo_fetch("SELECT id,uniacid,times,times_day,last_time,openid,uuid FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :aid AND uuid = :uuid", array(":aid" => $aid, ":uuid" => $uuid));
if (empty($qrcode) || empty($qrcode["openid"]) || $qrcode["openid"] != $openid && $activity["pattern"] != 12 || $qrcode["uniacid"] != $uniacid) {
	$data["sta"] = 0;
	$data["error"] = "二维码数据错误";
	echo json_encode($data);
	exit;
}
if ($qrcode["openid"] != $openid && $activity["pattern"] == 12) {
	$invitation_user = pdo_fetch("SELECT id,comment,time FROM " . tablename(TABLE_INVITATION_USER) . "WHERE tid=:tid AND openid=:openid ", array(":tid" => $qrcode["id"], ":openid" => $openid));
	if (empty($invitation_user)) {
		$data["sta"] = 0;
		$data["error"] = "来路数据错误";
		echo json_encode($data);
		exit;
	}
	$cuteface_other_count = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_CUTEFACE) . " WHERE tid = :tid AND openid!=:openid", array(":tid" => $qrcode["id"], ":openid" => $qrcode["openid"]));
	if ($cuteface_other_count >= $activity["friend_cuteface_num"]) {
		$data["sta"] = 0;
		$data["error"] = "已有足够的好友参与PK了，刷新页面看有没有其他惊喜";
		echo json_encode($data);
		exit;
	}
}
if ($activity["pattern"] != 12 && $activity["cuteface_num"] && $qrcode["times"] >= $activity["cuteface_num"]) {
	$data["sta"] = 0;
	$data["error"] = "测颜值超过最大次数";
	echo json_encode($data);
	exit;
}
$data["check_share"] = 0;
if ($activity["pattern"] != 12 && $activity["cuteface_num_day"]) {
	$cuteface_num_day_surplus = $qrcode["last_time"] >= strtotime(date("Y-m-d")) ? $activity["cuteface_num_day"] - $qrcode["times_day"] : $activity["cuteface_num_day"];
	if ($activity["share_open"]) {
		$add_one = $activity["add_one"] ? $activity["add_one"] : 1;
		$today_start = strtotime(date("Y-m-d"));
		$invitation_user = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_INVITATION_USER) . " WHERE tid=:tid AND createtime>={$today_start}", array(":tid" => $qrcode["id"]));
		if ($activity["share_num"]) {
			if ($invitation_user >= $activity["share_num"]) {
				$invitation_times = $add_one * $activity["share_num"];
				$cuteface_num_day_surplus += $invitation_times;
			} else {
				if ($invitation_user > 0) {
					$invitation_content = "还差<span>" . ($activity["share_num"] - $invitation_user) . "</span>好友即可增加<span>" . $add_one * $activity["share_num"] . "次</span>";
				}
			}
		} else {
			$cuteface_num_day_surplus += $add_one * $invitation_user;
		}
	}
	if ($cuteface_num_day_surplus < 1) {
		$data["sta"] = 0;
		if ($activity["share_open"] && empty($invitation_times)) {
			$data["check_share"] = 1;
			$data["error"] = $activity["share_tips"] ? $activity["share_tips"] : "今日次数用完啦，根据红包码提示操作获取更多次数";
		} else {
			$data["error"] = "今日测颜值超过最大次数,明天再来吧";
		}
		echo json_encode($data);
		exit;
	}
	if ($activity["cuteface_num"]) {
		$cuteface_num_day_surplus = min($cuteface_num_day_surplus, $activity["cuteface_num"] - $qrcode["times"]);
	}
}
$red_info = pdo_fetch("SELECT * FROM " . tablename(TABLE_RED) . " WHERE tid = :tid", array(":tid" => $qrcode["id"]));
if ($red_info) {
	$data["sta"] = 0;
	$data["error"] = "红包数据已经生成，如未收到红包请联系管理员";
	echo json_encode($data);
	exit;
}
if ($activity["pattern"] == 12) {
	$cuteface = pdo_fetch("SELECT id,openid,tid,image_thumb_url,mark,status FROM " . tablename(TABLE_CUTEFACE) . " WHERE tid = :tid AND openid=:openid", array(":tid" => $qrcode["id"], ":openid" => $openid));
	if ($cuteface) {
		$data["sta"] = 0;
		$data["error"] = "您已经测过颜值了";
		echo json_encode($data);
		exit;
	}
} else {
	$cuteface = pdo_fetch("SELECT id,openid,tid,image_thumb_url,mark,status FROM " . tablename(TABLE_CUTEFACE) . " WHERE tid = :tid", array(":tid" => $qrcode["id"]));
	if ($cuteface && $cuteface["openid"] != $openid) {
		$data["sta"] = 0;
		$data["error"] = "非法操作";
		echo json_encode($data);
		exit;
	}
}
if (intval($_GPC["upload_type"]) == 1) {
	$file = $_FILES["file"];
	$file_name = $file["name"];
	$file_tmp_name = $file["tmp_name"];
	$file_type = strtolower(substr($file_name, strpos($file_name, ".") + 1));
	$allow_type = array("jpg", "jpeg", "png");
	$re_dir = "images/{$uniacid}/crad_qrcode_red/" . date("Y/m/");
	$upload_path = ATTACHMENT_ROOT . $re_dir;
	$upload_file = md5(time() . $openid . rand(10000, 99999));
	$upload_file_name = $upload_file . "." . $file_type;
	if (!is_dir($upload_path)) {
		if (function_exists("mkdirs")) {
			mkdirs($upload_path);
		} else {
			mkdir($upload_path, 0777, true);
		}
	}
	if (!in_array($file_type, $allow_type)) {
		$data["sta"] = 0;
		$data["error"] = "上传图片类型不对";
		echo json_encode($data);
		die;
	}
	if (!is_uploaded_file($file_tmp_name)) {
		$data["sta"] = 0;
		$data["error"] = "不是通过HTTP POST上传的文件";
		echo json_encode($data);
		die;
	}
	if (!move_uploaded_file($file_tmp_name, $upload_path . $upload_file_name)) {
		$data["sta"] = 0;
		$data["error"] = "图片文件有误";
		echo json_encode($data);
		die;
	}
	$target_name = $upload_file . "_thumb." . $file_type;
	$filepath = $upload_path . $target_name;
	if ($this->image_recreate($upload_path . $upload_file_name, $filepath)) {
		file_delete($upload_path . $upload_file_name);
		$image_path = $re_dir . $target_name;
		$upload_file_name = $target_name;
	} else {
		file_delete($upload_path . $upload_file_name);
		$data["sta"] = 0;
		$data["error"] = "图片文件有误";
		echo json_encode($data);
		die;
	}
} else {
	$serverid = $_GPC["serverid"];
	load()->classs("weixin.account");
	if ($_W["account"]["level"] > 3) {
		$accObj = WeiXinAccount::create($_W["account"]);
	} else {
		if ($_W["oauth_account"]["level"] > 3) {
			$accObj = WeiXinAccount::create($_W["oauth_account"]);
		} else {
			$accObj = WeiXinAccount::create($_W["account"]);
		}
	}
	$access_token = $accObj->fetch_available_token();
	$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={$access_token}&media_id={$serverid}";
	$fileInfo = $this->downloadWeixinFile($url);
	switch ($fileInfo["header"]["content_type"]) {
		case "image/pjpeg":
		case "image/jpeg":
			$file_type = ".jpg";
			break;
		case "image/gif":
			$file_type = ".gif";
			break;
		case "image/png":
			$file_type = ".png";
			break;
	}
	if (!$file_type) {
		$data["sta"] = 0;
		$data["error"] = "图片格式错误";
		if ($fileInfo["body"]) {
			$error_body = json_decode($fileInfo["body"], true);
			if ($error_body["errmsg"]) {
				$data["error"] = "无法下载微信图片:" . $error_body["errmsg"];
			}
		}
		echo json_encode($data);
		die;
	}
	$re_dir = "images/{$uniacid}/crad_qrcode_red/" . date("Y/m/");
	$upload_path = ATTACHMENT_ROOT . $re_dir;
	$upload_file = md5(time() . $openid . rand(10000, 99999));
	$upload_file_name = $upload_file . $file_type;
	$filepath = $upload_path . $upload_file_name;
	$filecontent = $fileInfo["body"];
	if (!$filecontent) {
		$data["sta"] = 0;
		$data["error"] = "无法读取图片，请换张图试试";
		echo json_encode($data);
		die;
	}
	if (!is_dir($upload_path)) {
		if (function_exists("mkdirs")) {
			$dir = mkdirs($upload_path);
		} else {
			$dir = mkdir($upload_path, 0777, true);
		}
	}
	if (false !== $dir) {
		$local_file = fopen($filepath, "w");
		if (false !== $local_file) {
			if (false !== fwrite($local_file, $filecontent)) {
				fclose($local_file);
				$image_path = $re_dir . $upload_file_name;
			}
		} else {
			$data["sta"] = 0;
			$data["error"] = "写入图片失败";
			echo json_encode($data);
			die;
		}
	} else {
		$data["sta"] = 0;
		$data["error"] = "目录创建失败";
		echo json_encode($data);
		die;
	}
}
$image_data = file_get_contents($filepath);
if (!$image_data) {
	$data["sta"] = 0;
	$data["error"] = "无法获取图片";
	echo json_encode($data);
	die;
}
if (!empty($cfg["isremote"])) {
	$image_url_real = $cfg["qiniu_url"] . "/" . $upload_file_name;
} else {
    $image_url_real = tomedia($re_dir . $upload_file_name);
}
require_once '../addons/crad_qrcode_red/libs/baidu/AipFace.php';
$setting = $this->module['config'];
$cfg = $setting['baidu_config'];
if ($cfg['baidu_appid'] && $cfg['baidu_api_key'] && $cfg['baidu_api_secret']) {
    $APP_ID = $cfg['baidu_appid'];
    $API_KEY = $cfg['baidu_api_key'];
    $SECRET_KEY = $cfg['baidu_api_secret'];
    $aipFace = new AipFace($APP_ID, $API_KEY, $SECRET_KEY);
    $options = array();
    $options["face_field"] = "age,beauty,expression,faceshape,gender,glasses,landmark,race,quality,facetype";
    $options["max_face_num"] = 2;
    $options["face_type"] = "LIVE";
    $face = $aipFace->detect($image_url_real, "URL", $options);
    if (!empty($face['error'])) {
        exit(json_encode(array("sta" => 0, "error" => $face['error_msg'])));
    }
    $rest=$face['result'];
    $result = array('sta' => 1, 'data' => array('rotation_angle' => ceil($rest['face_list'][0]['location']["rotation"]), 'sex' => '保密', 'mark' =>ceil($rest['face_list'][0]['beauty']), 'age' =>  ceil($rest['face_list'][0]['age']), 'position' => array('detect_height' => ceil($rest['face_list'][0]['location']["height"]), 'detect_width' => ceil($rest['face_list'][0]['location']["width"]))));
} else {
    exit(json_encode(array("sta" => 0, "error" => "AI系统尚未连接接通")));
}
if (!$result["data"]["position"]["detect_height"] && !$result["data"]["position"]["detect_width"]) {
		if (file_exists($filepath)) {
			file_delete($filepath);
		}
		$data["sta"] = 2;
		$data["error"] = "测试失败，请上传一张靓照";
		echo json_encode($data);
		die;
	} else {
		$mark = $result["data"]["mark"];
		$age = $result["data"]["age"];
		$sex = $result["data"]["sex"];
		$position = $result["data"]["position"];
	}
$rotation_angle = $result["data"]["rotation_angle"];
if ($rotation_angle >= 135) {
	$rotation_angle_image = 180;
} else {
	if ($rotation_angle >= 60 && $rotation_angle < 135) {
		$rotation_angle_image = 90;
	} else {
		if ($rotation_angle > -135 && $rotation_angle <= -60) {
			$rotation_angle_image = -90;
		} else {
			if ($rotation_angle <= -135) {
				$rotation_angle_image = -180;
			}
		}
	}
}
if (abs($result["data"]["rotation_angle"]) >= 60 && $rotation_angle_image) {
	$this->rotate($filepath, $rotation_angle_image);
	$post_data["image_data"] = file_get_contents($filepath);
	$content = ihttp_post($url, $post_data);
	$result = json_decode($content["content"], true);
	if ($result["data"]["position"]["detect_height"]) {
		$position = $result["data"]["position"];
	}
}
if ($position) {
	$resule_head = $this->image_resize($filepath, $upload_path . $upload_file . "_head" . $file_type, $position);
}
if (!empty($cfg["isremote"])) {
	$this->file_picremote_upload($upload_file_name, $cfg, $upload_path);
	$url = $cfg["qiniu_url"];
	$filepath_new = $url . "/" . $upload_file_name;
} else {
	if (!empty($_W["setting"]["remote"]["type"])) {
		$remotestatus = file_remote_upload($image_path, true);
		if (is_error($remotestatus)) {
			$data["sta"] = 0;
			$data["error"] = "远程附件上传失败，请检查配置并重新上传";
			echo json_encode($data);
			die;
		} else {
			if (file_exists($filepath)) {
				file_delete($filepath);
			}
		}
	}
}
if ($filepath_new) {
	$image_path = $filepath_new;
}
$data_insert = array("uniacid" => $uniacid, "openid" => $openid, "mark" => intval($mark), "sex" => $sex ? intval($sex) : 0, "age" => $age ? intval($age) : 0, "image_url" => $image_path, "image_thumb_url" => $image_path);
$data_insert["tid"] = $qrcode["id"];
$data_insert["status"] = 1;
$data_insert["add_time"] = time();
$data_insert["aid"] = $aid;
$data_insert["width_height"] = $resule_head ? $resule_head : 0;
$data_insert["image_head_url"] = $resule_head ? $re_dir . $upload_file . "_head" . $file_type : $image_path;
$data_insert["position"] = $position ? json_encode($position) : '';
if (empty($cuteface)) {
	pdo_insert(TABLE_CUTEFACE, $data_insert);
	$cuteface = $data_insert;
	$cuteface["id"] = pdo_insertid();
	if (!$cuteface["id"]) {
		if (file_exists($filepath)) {
			file_delete($filepath);
		}
		if (file_exists($upload_path . $upload_file . "_head" . $file_type)) {
			file_delete($upload_path . $upload_file . "_head" . $file_type);
		}
		$data["sta"] = 0;
		$data["error"] = "数据保存失败，稍后重试";
		echo json_encode($data);
		die;
	}
} else {
	pdo_update(TABLE_CUTEFACE, $data_insert, array("id" => $cuteface["id"]));
	$cuteface = $data_insert;
}
$cuteface_out = array();
if ($activity["pattern"] == 12) {
	$cuteface_out["send_red"] = 0;
	if ($qrcode["openid"] == $openid) {
		$cuteface_out["cuteface_own"] = 1;
	} else {
		$cuteface_out["cuteface_own"] = 0;
	}
	$cuteface_all = pdo_fetchall("SELECT id,openid,tid,image_thumb_url,mark,status FROM " . tablename(TABLE_CUTEFACE) . " WHERE tid = :tid ORDER BY id ASC", array(":tid" => $qrcode["id"]));
	if ($cuteface_all) {
		$max_mark = 0;
		$max_cid = 0;
		foreach ($cuteface_all as &$value) {
			$red_nickname = pdo_fetch("SELECT nickname,headimgurl FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid= :aid", array(":openid" => $value["openid"], ":aid" => $aid));
			$value["nickname"] = $red_nickname["nickname"];
			$value["headimgurl"] = $red_nickname["headimgurl"];
			if ($value["mark"] > $max_mark) {
				$max_mark = $value["mark"];
				$max_cid = $value["id"];
			}
			if ($value["openid"] == $qrcode["openid"]) {
				$cuteface_own = $value;
			} else {
				$cuteface_users[] = $value;
			}
		}
	}
	$count_cuteface_user = count($cuteface_users);
	$temp_least = $activity["friend_cuteface_num"] - $count_cuteface_user;
	$least_cuteface_users = $temp_least > 0 ? $temp_least : 0;
	$html_res = '';
	$cuteface_out["nickname_red"] = '';
	$x = 0;
	while ($x <= $activity["friend_cuteface_num"]) {
		if ($cuteface_all[$x]) {
			$html_res .= "<div class='crown_li'>";
			if ($cuteface_all[$x]["id"] == $max_cid) {
				$cuteface_red = $cuteface_all[$x];
				$cuteface_out["nickname_red"] = $cuteface_all[$x]["nickname"];
				$html_res .= "<div class='crown_first'>";
				$html_res .= "<img src='../addons/crad_qrcode_red/template/mobile/img/crown.png' /></div>";
			}
			$html_res .= "<div class='crownli_img'>";
			$image_cuteface = $cuteface_all[$x]["image_thumb_url"] ? tomedia($cuteface_all[$x]["image_thumb_url"]) : $cuteface_all[$x]["headimgurl"];
			$html_res .= "<img src='" . $image_cuteface . "' class='' />";
			$html_res .= "</div>";
			$html_res .= "<div class='crownli_yes'>";
			$html_res .= "<div class='crownli_one'>";
			if ($cuteface_all[$x]["openid"] == $openid) {
				$html_res .= "您的颜值";
			} else {
				$html_res .= $cuteface_all[$x]["nickname"];
			}
			$html_res .= "</div><div class='crownli_two'>" . $cuteface_all[$x]["mark"] . "分</div>";
			$html_res .= "</div>";
			$html_res .= "</div>";
		} else {
			$html_res .= "<div class='crown_li'>";
			$html_res .= "<div class='crownli_img'>";
			$html_res .= "<img src='../addons/crad_qrcode_red/template/mobile/img/me.png' />";
			$html_res .= "</div>";
			$html_res .= "<div class='crownli_yes'>";
			$html_res .= "<div class='crownli_one'>等待加入</div>";
			$html_res .= "</div>";
			$html_res .= "</div>";
		}
		$x++;
	}
	$cuteface_out["tips"] = '';
	if (empty($cuteface_own)) {
		$cuteface_red = array();
		$least_cuteface_users = $least_cuteface_users + 1;
	}
	if ($least_cuteface_users > 0) {
		$cuteface_out["tips"] = "还差<span>" . $least_cuteface_users . "人</span>参与PK，颜值最高者得红包！";
	} else {
		if (!empty($cuteface_own) && !empty($cuteface_red) && $temp_least == 0) {
			$red_infos = pdo_fetch("SELECT * FROM " . tablename(TABLE_RED) . " WHERE tid = :tid", array(":tid" => $qrcode["id"]));
			if (!$red_infos) {
				$sum_money_act = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_RED) . " WHERE aid='{$aid}'");
				$total_red = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_RED) . " WHERE aid='{$aid}'");
				$total_red_user = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_RED) . " WHERE aid=:aid AND openid = :openid", array(":aid" => $aid, ":openid" => $cuteface_red["openid"]));
				$today_start = strtotime(date("Y-m-d"));
				$total_red_user_day = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_RED) . " WHERE aid=:aid AND openid = :openid AND createtime>{$today_start}", array(":aid" => $aid, ":openid" => $cuteface_red["openid"]));
				if (!$activity["get_num"] || $total_red_user < $activity["get_num"]) {
					if (!$activity["get_num_day"] || $total_red_user_day < $activity["get_num_day"]) {
						if (!$activity["money_sum"] || $sum_money_act["sum_money"] < $activity["money_sum"]) {
							if (!$activity["qrcode_num"] || $total_red < $activity["qrcode_num"]) {
								$money = $this->get_red_money($activity, $total_red, $sum_money_act["sum_money"]);
								if ($money >= 0.3) {
									$update = array("status" => 1);
									$data_red = array("uniacid" => $uniacid, "openid" => $cuteface_red["openid"], "money" => $money, "aid" => $aid, "shopid" => $activity["sid"], "status" => 0, "tid" => $qrcode["id"], "createtime" => time());
									if (pdo_fieldexists("crad_qrcode_red_red", "trade_no")) {
										if ($activity["payway"] == 0) {
											$data_red["trade_no"] = random(10) . date("Ymd") . random(3);
										} else {
											if ($cfg["sl_pay"] == 1) {
												$mchid_s = $this->data_decrypt($cfg["mchid_sl"], $cfg["ticket"]);
												$data_red["trade_no"] = $mchid_s . date("YmdHis") . rand(1000, 9999);
											} else {
												$data_red["trade_no"] = $cfg["mchid"] . date("YmdHis") . rand(1000, 9999);
											}
										}
									}
									if (pdo_insert(TABLE_RED, $data_red) !== false) {
										$insertid = pdo_insertid();
										if ($insertid) {
											pdo_update(TABLE_QRCODE, array("status" => 2), array("id" => $qrcode["id"]));
											$qrcode["status"] = 2;
											$red_info = $data_red;
											$red_info["id"] = $insertid;
											$user_info = pdo_fetch("SELECT * FROM " . tablename(TABLE_USER) . " WHERE aid = :aid AND openid = :openid", array(":aid" => $aid, ":openid" => $cuteface_red["openid"]));
											$res_send = $this->cash($activity, $red_info, $qrcode["uuid"], $user_info);
											$res_arr = json_decode($res_send, true);
											if ($res_arr["sta"] == 1) {
												pdo_update(TABLE_QRCODE, array("status" => 3), array("id" => $qrcode["id"]));
											}
											if ($cuteface_red["openid"] == $openid) {
												$cuteface_out["send_red"] = 1;
											} else {
												$cuteface_out["send_red"] = 2;
											}
											$cuteface_out["money"] = $money;
										}
									}
								}
							}
						}
					}
				}
			}
		}
		if ($cuteface_red["openid"] == $openid && $cuteface_own) {
			$cuteface_out["send_red"] = 3;
		}
	}
	$cuteface_out["content"] = $html_res;
	$cuteface_out["least_user"] = $least_cuteface_users;
} else {
	$updata_task_times = array("times" => $qrcode["times"] + 1, "last_time" => time());
	if ($qrcode["last_time"] < strtotime(date("Y-m-d"))) {
		$updata_task_times["times_day"] = 1;
	} else {
		$updata_task_times["times_day"] = $qrcode["times_day"] + 1;
	}
	pdo_update(TABLE_QRCODE, $updata_task_times, array("id" => $qrcode["id"]));
	$cuteface_out["check_share"] = 0;
	if ($cuteface["mark"] >= $activity["cuteface_mark"]) {
		$cuteface_out["win"] = 1;
	} else {
		$cuteface_out["win"] = 0;
	}
	if ($activity["cuteface_num_day"] && $cuteface_num_day_surplus - 1 > 0) {
		$cuteface_out["content"] = "今日剩余<span>" . ($cuteface_num_day_surplus - 1) . "次</span>";
	} else {
		if ($activity["cuteface_num_day"] && $invitation_content) {
			$cuteface_out["check_share"] = 1;
			$cuteface_out["content"] = $invitation_content;
		} else {
			if ($activity["cuteface_num_day"] && $invitation_times > 0) {
				$cuteface_out["content"] = "今日挑战超过最大次数,明天再来吧";
			} else {
				if ($activity["cuteface_num_day"] > 0 && $activity["share_open"]) {
					$cuteface_out["content"] = $activity["share_tips"] ? $activity["share_tips"] : "今日次数用完啦，根据红包码提示操作获取更多次数";
				} else {
					if ($activity["cuteface_num"] - $updata_task_times["times"] > 0) {
						$cuteface_out["content"] = "今日次数已用完,累计剩余<span>" . ($activity["cuteface_num"] - $updata_task_times["times"]) . "次</span>";
					} else {
						$cuteface_out["content"] = '';
					}
				}
			}
		}
	}
}
$cuteface_out["mark"] = $cuteface["mark"];
$cuteface_out["status"] = $cuteface["status"];
$cuteface_out["image_thumb_url"] = tomedia($cuteface["image_thumb_url"]);
$cuteface_out["nickname"] = $userinfo["nickname"];
$cuteface_out["sta"] = 1;
exit(json_encode($cuteface_out));