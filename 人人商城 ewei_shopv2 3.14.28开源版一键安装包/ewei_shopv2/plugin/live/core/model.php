<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class LiveModel extends PluginModel
{
	/**
     * 获取指定天数内销售额
     * @param $day
     */
	public function selectOrderPrice($day = 0, $roomid = 0)
	{
		global $_W;

		if (!empty($day)) {
			$createtime1 = strtotime(date('Y-m-d', time() - $day * 3600 * 24));
			$createtime2 = strtotime(date('Y-m-d', time()));
		}
		else {
			$createtime1 = strtotime(date('Y-m-d', time()));
			$createtime2 = strtotime(date('Y-m-d', time() + 3600 * 24));
		}

		$condition = '';

		if (0 < $roomid) {
			$condition = ' and liveid = ' . $roomid . ' ';
		}
		else {
			$condition = ' and liveid>0 ';
		}

		$sql = 'select id,price,createtime from ' . tablename('ewei_shop_order') . ' where uniacid = :uniacid ' . $condition . ' and ismr=0 and isparent=0 and (status > 0 or ( status=0 and paytype=3)) and deleted=0 and createtime between :createtime1 and :createtime2';
		$param = array(':uniacid' => $_W['uniacid'], ':createtime1' => $createtime1, ':createtime2' => $createtime2);
		$pdo_res = pdo_fetchall($sql, $param);
		$price = 0;

		foreach ($pdo_res as $arr) {
			$price += $arr['price'];
		}

		return round($price, 1);
	}

	/**
     * 获取基本设置
     */
	public function getSet()
	{
		global $_W;
		$set = array();
		$set = pdo_fetch('select * from ' . tablename('ewei_shop_live_setting') . ' where uniacid = :uniacid  ', array(':uniacid' => $_W['uniacid']));
		$plugin = pdo_fetch('select `name` from ' . tablename('ewei_shop_plugin') . ' where `identity` = \'live\' and isv2 = 1 and status = 1 ');
		$set['pluginname'] = $plugin['name'];
		return $set;
	}

	/**
     * 发送直播通知
     * @param $openid
     * @param $type
     * @param $roomid
     * @return array
     */
	public function sendLiveMessage($openid, $type, $roomid)
	{
		global $_W;
		global $_GPC;
		if (empty($openid) || empty($type) || empty($roomid)) {
			return error(-1, '参数不全');
		}

		$room = pdo_fetch('select * from ' . tablename('ewei_shop_live') . ' where uniacid = ' . $_W['uniacid'] . ' and id = ' . $roomid . ' ');
		$time = date('Y-m-d H:i', time());
		$datas[] = array('name' => '通知类型', 'value' => '已订阅');
		$datas[] = array('name' => '时间', 'value' => $time);

		if ($type == 'livefollow') {
			$datas[] = array('name' => '任务名称', 'value' => '【' . $room['title'] . '】订阅成功');
			$url = mobileUrl('live/room', array('id' => $roomid), true);
			$tag = 'livefollow';
			$remark = '
<a href=\'' . $url . '\'>点击查看详情</a>';
			$text = '您已订阅【' . $room['title'] . '】！
' . $remark;
			$message = array(
				'first'    => array('value' => '您好，您有新的直播订阅', 'color' => '#ff0000'),
				'keyword1' => array('title' => '任务名称', 'value' => '直播间订阅消息提醒', 'color' => '#000000'),
				'keyword2' => array('title' => '通知类型', 'value' => '已订阅', 'color' => '#000000'),
				'remark'   => array('value' => $text . '
感谢您的支持', 'color' => '#000000')
				);
		}
		else {
			if ($type == 'liveroom') {
				$room['livetime'] = date('Y-m-d H:i', $room['livetime']);
				$datas[] = array('name' => '任务名称', 'value' => '您订阅的【' . $room['title'] . '】将在' . $room['livetime'] . '开播！');
				$url = str_replace('addons/ewei_shopv2/plugin/live/task/', '', $_W['siteroot']);
				$url = $url . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=ewei_shopv2&do=mobile&r=live.room&id=' . $room['id'];
				$tag = 'livefollow';
				$remark = '
<a href=\'' . $url . '\'>点击查看详情</a>';
				$text = '您订阅的【' . $room['title'] . '】将在' . $room['livetime'] . '开播！
' . $remark;
				$message = array(
					'first'    => array('value' => '您好，您订阅的直播有新消息', 'color' => '#ff0000'),
					'keyword1' => array('title' => '任务名称', 'value' => '您订阅的【' . $room['title'] . '】将在' . $room['livetime'] . '开播！', 'color' => '#000000'),
					'keyword2' => array('title' => '通知类型', 'value' => '已订阅', 'color' => '#000000'),
					'remark'   => array('value' => $text . '
感谢您的支持', 'color' => '#000000')
					);
			}
		}

		m('notice')->sendNotice(array('openid' => $openid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'url' => $url, 'datas' => $datas));
	}

	/**
     * 获取直播状态
     * @param int $roomid
     * @return bool
     */
	public function isLiving($roomid = 0)
	{
		global $_W;

		if (!empty($roomid)) {
			$live = pdo_fetch('SELECT id FROM ' . tablename('ewei_shop_live') . ' WHERE id=:id AND uniacid=:uniacid  LIMIT 1', array(':id' => $roomid, ':uniacid' => $_W['uniacid']));

			if (!empty($live)) {
				return true;
			}
		}

		return false;
	}

	/**
     * 判断是否关注直播间
     * @param null $openid
     * @param int $roomid
     * @return bool
     */
	public function isFavorite($openid = NULL, $roomid = 0)
	{
		global $_W;
		if (!empty($openid) && !empty($roomid)) {
			$favorite = pdo_fetch('SELECT id FROM ' . tablename('ewei_shop_live_favorite') . 'WHERE uniacid=:uniacid AND roomid=:roomid AND openid=:openid AND `deleted`=0 LIMIT 1', array(':uniacid' => $_W['uniacid'], ':roomid' => $roomid, ':openid' => $openid));

			if (!empty($favorite)) {
				return true;
			}
		}

		return false;
	}

	/**
     * 获取所有表情
     * @return array
     */
	public function getEmoji()
	{
		return array('', '微笑', '撇嘴', '色', '发呆', '得意', '流泪', '害羞', '闭嘴', '睡', '大哭', '尴尬', '发怒', '调皮', '呲牙', '惊讶', '难过', '冷酷', '冷汗', '抓狂', '吐', '偷笑', '愉快', '白眼', '傲慢', '饥饿', '困', '惊恐', '流汗', '憨笑', '大兵', '奋斗', '咒骂', '疑问', '嘘', '晕', '抓狂', '哀', '骷髅', '敲打', '再见', '擦汗', '抠鼻', '鼓掌', '糗', '坏笑', '左哼哼', '右哼哼', '哈欠', '鄙视', '委屈', '快哭了', '阴险', '亲亲', '惊吓', '可怜', '菜刀', '西瓜', '啤酒', '篮球', '乒乓', '咖啡', '饭', '猪头', '玫瑰', '凋谢', '示爱', '爱心', '心碎', '蛋糕', '闪电', '炸弹', '刀', '足球', '瓢虫', '便便', '月亮', '太阳', '礼物', '拥抱', '强', '弱', '握手', '胜利', '抱拳', '勾引', '拳头', '差劲', '爱你', 'no', 'ok');
	}

	/**
     * 获取所有支持的直播列表
     * @return array
     */
	public function getLiveList()
	{
		return array('panda' => '熊猫直播', 'douyu' => '斗鱼直播', 'huajiao' => '花椒直播', 'yizhibo' => '一直播', 'inke' => '映客直播', '360.' => '水滴直播', 'qlive' => '青果直播', 'ys7' => '萤石直播');
	}

	/**
     * 表情转html标签
     * @param $str
     * @return string
     */
	public function emoji2html($str)
	{
		$emojiList = $this->getEmoji();

		foreach ($emojiList as $index => $emoji) {
			if ($emoji == $str) {
				return '<img class="face" src="../addons/ewei_shopv2/plugin/live/static/images/face/' . $index . '.gif?v=2" />';
			}
		}

		return '[' . $str . ']';
	}

	/**
     * 读取并处理聊天记录
     * @param int $roomid
     * @param bool $manage
     * @param int $uid
     * @return array
     */
	public function handleRecords($roomid = 0, $manage = false)
	{
		global $_W;

		if ($manage) {
			$uid = 'console' . '_' . $_W['uid'] . '_' . $_W['role'] . '_' . $_W['uniacid'];
		}

		$table = $this->getRedisTable('chat_records', $roomid);
		$table_length = redis()->lLen($table);
		$records_num = $manage ? 100 : 30;
		$start_index = $table_length < $records_num ? 0 : $table_length - $records_num;
		$records = redis()->lRange($table, $start_index, $table_length);

		if (empty($records)) {
			return array();
		}

		if ($manage) {
			$table_banned = 'ewei_shop_live_banned_' . $roomid;
			$bannedArr = array();
		}

		foreach ($records as &$record) {
			if (empty($record)) {
				continue;
			}

			$record = json_decode($record, true);
			if ($record['type'] == 'image' && !empty($record['text'])) {
				$imgurl = tomedia($record['text']);

				if ($manage) {
					$record['text'] = '<a href="' . $imgurl . '" target="_blank"><img src="' . $imgurl . '"/></a>';
				}
				else {
					$record['text'] = '<img src="' . $imgurl . '"/>';
				}
			}
			else if ($record['type'] == 'redpack') {
				if ($manage) {
					$record['text'] = '[余额红包] ' . $record['text'] . '，请到手机端查看';
				}
				else {
					$drawstatus = $this->getDrawStatus('redpack', $record['pushid'], $roomid);
					$redpacksubtitle = $drawstatus == 1 ? '已领取' : '立即领取';
					$redpackdrew = $drawstatus == 1 ? 'drew' : '';
					$record['text'] = '<div class="redpack ' . $redpackdrew . '" data-pushid="' . $record['pushid'] . '" data-title="' . $record['text'] . '"><p class="name">' . $record['text'] . '</p><p class="desc">' . $redpacksubtitle . '</p></div>';
				}
			}
			else if ($record['type'] == 'coupon') {
				if ($manage) {
					$record['text'] = '[优惠券] ' . $record['text'] . '，请到手机端查看';
				}
				else {
					$drawstatus = $this->getDrawStatus('coupon', $record['pushid'], $roomid);
					$couponsubtitle = $drawstatus == 1 ? '已领取' : '立即领取';
					$coupondrew = $drawstatus == 1 ? 'drew' : '';
					$record['text'] = '<div class="coupon ' . $coupondrew . '" data-pushid="' . $record['pushid'] . '" data-title="' . $record['text'] . '"><p class="name">' . $record['text'] . '</p><p class="desc">' . $couponsubtitle . '</p></div>';
				}
			}
			else {
				$_this = $this;
				$record['text'] = preg_replace_callback('/\\[([^\\]]+)\\]/', function($matches) use(&$_this) {
					return $_this->emoji2html($matches[1]);
				}, $record['text']);
				$atText = '';

				if (!empty($record['at'])) {
					$atUsers = iunserializer($record['at']);

					if (!empty($atUsers)) {
						foreach ($atUsers as $key => $nickname) {
							$atText .= '<span class="nickname';

							if ($key == $uid) {
								$atText .= ' self';
							}

							$atText .= '" data-uid="' . $key . '" data-nickname="' . $nickname . '">@';

							if ($key == $uid) {
								$atText .= '你';
							}
							else {
								$atText .= $nickname;
							}

							$atText .= ' </span>';
						}
					}
				}

				$record['text'] = $atText . $record['text'];
			}

			if ($record['status'] == 1) {
				$record['text'] = $record['mid'] == $uid ? '你' : '"' . $record['nickname'] . '"';
				$record['text'] .= '撤回了一条消息';
			}
			else {
				if ($record['status'] == 2) {
					if ($manage) {
						$record['text'] = $record['mid_manage'] == $uid ? '你' : $record['nickname_manage'];
						$record['text'] .= '删除了"' . $record['nickname'] . '"的一条消息';
					}
					else if ($record['mid'] == $uid) {
						$record['text'] = '管理员"' . $record['nickname_manage'] . '"删除了你一条消息';
					}
					else {
						$record['text'] = '"' . $record['nickname'] . '"撤回了一条消息';
					}
				}
			}

			if ($manage) {
				$uuid = $record['mid'];

				if (isset($bannedArr[$uuid])) {
					$record['banned'] = 1;
				}

				if (redis()->hExists($table_banned, $uuid)) {
					$record['banned'] = 1;
					$bannedArr[$uuid] = 1;
				}
			}
		}

		unset($record);
		unset($openid);
		unset($imgurl);
		return $records;
	}

	/**
     * 获取红包/优惠券状态
     * @param $type
     * @param $pushid
     */
	public function getDrawStatus($type, $pushid, $roomid)
	{
		global $_W;
		$table_list = $this->getRedisTable($type . '_list_' . $pushid, $roomid);
		$selfdata = redis()->hGet($table_list, $_W['openid']);

		if (!empty($selfdata)) {
			return 1;
		}

		return 0;
	}

	/**
     * 获取直播信息 - 单个
     * @param null $url
     * @param string $type
     */
	public function getLiveInfo($url = NULL, $type = 'auto')
	{
		if (empty($url)) {
			return error(1, '视频地址为空');
		}

		$liveList = $this->getLiveList();

		if ($type == 'auto') {
			foreach ($liveList as $key => $val) {
				if (strexists($url, $key)) {
					if ($key == 'huajiao') {
						$type = $key;
						continue;
					}

					$type = $key;
					break;
				}
			}

			if ($type == 'auto') {
				return error(1, '未自动识别到视频来源');
			}
		}

		$resultArr = array();
		load()->func('communication');

		switch ($type) {
		case 'panda':
			preg_match('/.*panda.tv\\/(\\d+)/is', $url, $matchs);

			if (empty($matchs)) {
				return error(1, '视频地址参数错误或所选来源错误');
			}

			$roomid = $matchs[1];

			if (strpos($matchs[0], 'xingyan') !== false) {
				$apiResult = ihttp_get('http://m.api.xingyan.panda.tv/room/baseinfo?xid=' . $roomid);
			}
			else {
				$apiResult = ihttp_get('https://room.api.m.panda.tv/index.php?callback=&method=room.shareapi&roomid=' . $roomid);
			}

			$apiResult = json_decode($apiResult['content'], true);
			$apiother = ihttp_get('https://api.m.panda.tv/ajax_stream_pull_get?roomid=' . $roomid . '&lite=1&roomkey=' . $apiResult['data']['videoinfo']['room_key'] . '&definition_option=1&hardware=1');
			$apiotherResult = json_decode($apiother['content'], true);
			$sign = $apiotherResult['data']['sign'];
			$ts = $apiotherResult['data']['ts'];

			if (!empty($apiResult['errno'])) {
				return error(2, '获取房间信息失败');
			}

			if (strpos($matchs[0], 'xingyan') !== false) {
				$resultArr = array('status' => $apiResult['data']['roominfo']['playstatus'] == 1 ? 1 : 0, 'poster' => $apiResult['data']['roominfo']['photo'], 'hls_url' => $apiResult['data']['videoinfo']['hlsurl']);
			}
			else {
				$resultArr = array('status' => $apiResult['data']['roominfo']['status'] == 2 ? 1 : 0, 'poster' => $apiResult['data']['roominfo']['pictures']['img'], 'hls_url' => $apiResult['data']['videoinfo']['address'] . '?sign=' . $sign . '' . $ts);
			}

			break;

		case 'douyu':
			preg_match('/.*douyu.com\\/(\\d+)/is', $url, $matchs);

			if (empty($matchs)) {
				return error(1, '视频地址参数错误或所选来源错误');
			}

			$roomid = $matchs[1];
			$apiResult = ihttp_get('https://m.douyu.com/html5/live?roomId=' . $roomid);
			$apiResult = json_decode($apiResult['content'], true);

			if (empty($apiResult['data'])) {
				return error(2, '获取房间信息失败');
			}

			if (!empty($apiResult['error'])) {
				return error(2, $apiResult['data']);
			}

			$resultArr = array('status' => $apiResult['data']['error'] == 0 ? 1 : 0, 'poster' => '../addons/ewei_shopv2/static/images/nopic.png', 'hls_url' => $apiResult['data']['hls_url']);

			if (!empty($resultArr['status'])) {
				$html = $apiResult = ihttp_get('https://m.douyu.com/' . $roomid);
			}

			break;

		case 'huajiao':
			preg_match('/.*huajiao.com\\/l\\/(\\d+)/is', $url, $matchs);

			if (empty($matchs)) {
				return error(1, '视频地址参数错误或所选来源错误');
			}

			$roomid = $matchs[1];
			$apiResult = ihttp_get('http://h.huajiao.com/l/index?liveid=' . $roomid);
			$html = $apiResult['content'];
			preg_match('@"feed":(.*?)"title"@is', $html, $feedInfo);

			if (empty($feedInfo)) {
				return error(2, '获取房间信息失败');
			}

			$feedInfo = rtrim($feedInfo[1], ',');
			$feedInfo .= '}';
			$feedInfo = json_decode($feedInfo, true);
			$resultArr = array('status' => $feedInfo['paused'] == 'N' ? 1 : 0, 'poster' => $feedInfo['image'], 'hls_url' => !empty($feedInfo['m3u8']) ? $feedInfo['m3u8'] : 'http://qh.cdn.huajiao.com/live_huajiao_v2/' . $feedInfo['sn'] . '/index.m3u8');
			break;

		case 'yizhibo':
			preg_match('/\\/l\\/(.*?).html/is', $url, $matchs);

			if (empty($matchs)) {
				return error(1, '视频地址参数错误或所选来源错误');
			}

			$roomid = $matchs[1];
			$apiResult = ihttp_get('http://www.yizhibo.com/l/' . $roomid . '.html');
			$html = $apiResult['content'];
			preg_match('@play_url:"(.*?)",@is', $html, $hls_url);
			preg_match('@covers:"(.*?)",@is', $html, $poster);
			preg_match('@status:(.*?),@is', $html, $status);
			$resultArr = array('status' => $status[1] == 10 ? 1 : 0, 'poster' => $poster[1], 'hls_url' => $hls_url[1]);
			$resultArr['hls_url'] = str_replace('http', 'https', $resultArr['hls_url']);
			break;

		case 'inke':
			$url = str_replace('share_uid', 'share', $url);
			preg_match('/.*liveid=(\\d+)/is', $url, $matchs);
			preg_match('/.*id=(\\d+)/is', $url, $matchs_bak);

			if (empty($matchs)) {
				if (empty($matchs_bak)) {
					return error(1, '视频地址参数错误或所选来源错误');
				}

				$matchs = $matchs_bak;
			}

			$roomid = $matchs[1];
			$roomInfo = ihttp_get('http://webapi.busi.inke.cn/mobile/Get_live_addr?liveid=' . $roomid);
			$roomInfo = json_decode($roomInfo['content'], true);
			if (empty($roomInfo) || !empty($roomInfo['error_code'])) {
				return error(2, '获取房间信息失败');
			}

			$resultArr = array('status' => $roomInfo['data']['status']);

			if (!empty($roomInfo['data']['status'])) {
				$resultArr['hls_url'] = $roomInfo['data']['live_addr'][0]['hls_stream_addr'];
				$resultArr['hls_url'] = str_replace('rtmp://', 'http://', $resultArr['hls_url']);
				$resultArr['rtmp_url'] = $roomInfo['data']['file'][0];
				$userInfo = ihttp_get('http://webapi.busi.inke.cn/mobile/user_info?liveid=' . $roomid);
				$userInfo = json_decode($userInfo['content'], true);
				if (!empty($userInfo) && empty($userInfo['error_code']) && !empty($userInfo['data'])) {
					$resultArr['poster'] = $userInfo['data']['image'];
				}
			}
			else {
				preg_match('/.*uid=(\\d+)/is', $url, $matchs);
				$uid = $matchs[1];
				$resultArr['hls_url'] = $roomInfo['data']['live_addr'][0]['hls_stream_addr'];
				$resultArr['hls_url'] = str_replace('rtmp://', 'http://', $resultArr['hls_url']);
				$resultArr['rtmp_url'] = $roomInfo['data']['file'][0];
				$userInfo = ihttp_get('http://webapi.busi.inke.cn/mobile/mobile_share_api?uid=' . $uid . '&liveid=' . $roomid);
				$userInfo = json_decode($userInfo['content'], true);
				$resultArr['hls_url'] = $userInfo['data']['media_info']['file'][0];
				$resultArr['poster'] = $userInfo['data']['media_info']['image'];
				$resultArr['status'] = 1;

				if (empty($userInfo['data']['media_info']['file'])) {
					$userInfo = ihttp_get('http://webapi.busi.inke.cn/web/live_share_pc?uid=' . $uid . '&id=' . $roomid);
					$userInfo = json_decode($userInfo['content'], true);
					$resultArr['hls_url'] = $userInfo['data']['file']['record_url'];
					$resultArr['poster'] = $userInfo['data']['file']['pic'];
					$resultArr['status'] = 1;
				}
			}

			break;

		case 'qlive':
			preg_match('/.*channel\\?id=(\\d+)/is', $url, $matchs);

			if (empty($matchs)) {
				return error(1, '视频地址参数错误或所选来源错误');
			}

			$roomid = $matchs[1];
			$apiResult = ihttp_get('https://qlive.163.com/live/square/cameraDetail?deviceId=' . $roomid . '&relateNum=0');
			load()->func('communication');
			$res = ihttp_request('https://qlive.163.com/live/square/camera/play', '{"deviceId":"' . $roomid . '"}', array('Content-Type' => 'application/json'));
			$res = json_decode($res['content'], true);
			$apiResult = json_decode($apiResult['content'], true);

			if (empty($apiResult['result']['cameraDetail'])) {
				return error(2, '获取房间信息失败');
			}

			$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
			$resultArr = array('status' => $apiResult['result']['cameraDetail']['canView'], 'poster' => $apiResult['result']['cameraDetail']['coverFileName'], 'hls_url' => empty($res['hlsUrl']) ? 'http://v.smartcamera.163.com/qingguo-public/' . $roomid . '/playlist.m3u8' : $res['hlsUrl']);
			break;

		case 'ys7':
			preg_match('/.*open.ys7.com\\/openlive\\/(\\w+)/is', $url, $matchs);

			if (empty($matchs)) {
				return error(1, '视频地址参数错误或所选来源错误');
			}

			$resultArr = array('status' => 1, 'poster' => '', 'hls_url' => $url);
			$resultArr['hls_url'] = str_replace('http', 'https', $resultArr['hls_url']);
			break;
		}

		$resultArr['type'] = $type;
		$resultArr['typeName'] = $liveList[$type];
		return $resultArr;
	}

	/**
     * 获取直播Redis表名
     * @param $table
     * @param $roomid
     * @return string
     */
	public function getRedisTable($table, $roomid)
	{
		return 'ewei_shop_live_' . $table . '_' . $roomid;
	}

	/**
     * 删除房间所有redis表
     * @param $roomid
     */
	public function deleteRedisTable($roomid)
	{
		if (empty($roomid)) {
			return NULL;
		}

		$table_settings = $this->getRedisTable('settings', $roomid);
		redis()->del($table_settings);
		$table_online = $this->getRedisTable('room', $roomid);
		redis()->del($table_online);
		$table_banned = $this->getRedisTable('banned', $roomid);
		redis()->del($table_banned);
		$table_push = $this->getRedisTable('push_records', $roomid);
		$table_push_order = $this->getRedisTable('push_records_order', $roomid);
		$push_records = redis()->lRange($table_push, 0, -1);

		if (!empty($push_records)) {
			foreach ($push_records as $index => $record) {
				$record = json_decode($record, true);

				if (empty($record)) {
					continue;
				}

				if ($record['type'] == 'redpack') {
					$table_redpack = $this->getRedisTable('redpack_' . $record['time'], $roomid);
					redis()->del($table_redpack);
					$table_redpack_list = $this->getRedisTable('redpack_list_' . $record['time'], $roomid);
					redis()->del($table_redpack_list);
					$table_redpack_order = $this->getRedisTable('redpack_order_' . $record['time'], $roomid);
					redis()->del($table_redpack_order);
				}
				else {
					if ($record['type'] == 'coupon') {
						$table_coupon = $this->getRedisTable('coupon_' . $record['time'], $roomid);
						redis()->del($table_coupon);
						$table_coupon_list = $this->getRedisTable('coupon_list_' . $record['time'], $roomid);
						redis()->del($table_coupon_list);
						$table_coupon_order = $this->getRedisTable('coupon_order_' . $record['time'], $roomid);
						redis()->del($table_coupon_order);
					}
				}
			}

			redis()->del($table_push);
			redis()->del($table_push_order);
		}
	}

	/**
     * 获取直播价格
     * @param array $goods
     * @param array $options
     * @param int $liveid
     * @return array|bool
     */
	public function getLivePrice($goods = array(), $liveid = 0)
	{
		global $_W;
		$options = array();
		if (empty($goods) || empty($liveid)) {
			return false;
		}

		$isLiveGoods = $this->isLiveGoods($goods['id'], $liveid);
		if (!$isLiveGoods || empty($isLiveGoods)) {
			return false;
		}

		$isLiving = $this->isLiving($liveid);

		if (!$isLiving) {
			return false;
		}

		if (!empty($goods['hasoption'])) {
			$options = $this->getLiveOptions($goods['id'], $liveid);
		}

		if (empty($options)) {
			if (floatval($goods['minprice']) <= floatval($isLiveGoods['liveprice'])) {
				return false;
			}

			$arr = array('minprice' => $isLiveGoods['liveprice'], 'maxprice' => $isLiveGoods['liveprice']);
		}
		else {
			$prices = array();

			foreach ($options as $option) {
				$prices[] = $option['marketprice'];
			}

			unset($option);
			$arr = array('minprice' => min($prices), 'maxprice' => max($prices));
		}

		$arr['minprice'] = price_format($arr['minprice']);
		$arr['maxprice'] = price_format($arr['maxprice']);
		return $arr;
	}

	/**
     * 查询是否是直播商品
     * @param int $goodsid
     * @param int $liveid
     * @return bool
     */
	public function isLiveGoods($goodsid = 0, $liveid = 0)
	{
		global $_W;
		if (empty($goodsid) || empty($liveid)) {
			return false;
		}

		$livegoods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_live_goods') . ' WHERE goodsid=:goodsid AND liveid=:liveid AND uniacid=:uniacid', array(':goodsid' => $goodsid, ':liveid' => $liveid, ':uniacid' => $_W['uniacid']));

		if (!empty($livegoods)) {
			return $livegoods;
		}

		return false;
	}

	/**
     * 获取商品规格+直播商品规格
     * @param int $goodsid
     * @param int $liveid
     * @return array|bool
     */
	public function getLiveOptions($goodsid = 0, $liveid = 0, $options = array())
	{
		global $_W;
		if (empty($goodsid) || empty($liveid)) {
			return false;
		}

		if (empty($options)) {
			$options = pdo_fetchall('SELECT id, marketprice FROM ' . tablename('ewei_shop_goods_option') . ' WHERE goodsid=:goodsid AND uniacid=:uniacid ORDER BY displayorder ASC', array(':goodsid' => $goodsid, ':uniacid' => $_W['uniacid']));
		}

		if (empty($options)) {
			return false;
		}

		$liveOptions = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_live_goods_option') . ' WHERE goodsid=:goodsid AND liveid=:liveid AND uniacid=:uniacid', array(':goodsid' => $goodsid, ':liveid' => $liveid, ':uniacid' => $_W['uniacid']), 'optionid');

		if (empty($liveOptions)) {
			return $options;
		}

		foreach ($options as &$option) {
			$optionid = $option['id'];
			$liveOption = $liveOptions[$optionid];
			if (empty($liveOption) || !isset($liveOption['liveprice'])) {
				continue;
			}

			if ($option['marketprice'] <= floatval($liveOption['liveprice'])) {
				continue;
			}

			$option['marketprice'] = $liveOption['liveprice'];
		}

		unset($option);
		return $options;
	}

	/**
     * 获取当前直播间商品列表
     * @param int $liveid
     */
	public function getAllGoods($liveid = 0)
	{
		global $_W;
		$goodslist = array();

		if (!empty($liveid)) {
			$goods = pdo_fetch('select goodsid from ' . tablename('ewei_shop_live') . ' where id = :liveid and uniacid = :uniacid ', array(':liveid' => $liveid, ':uniacid' => $_W['uniacid']));
			$goodsid = array();

			if (!empty($goods['goodsid'])) {
				$goodsid = explode(',', $goods['goodsid']);

				foreach ($goodsid as $key => $value) {
					$goodslist[$key] = pdo_fetch('SELECT lg.*,sg.id as id,lg.id as livegid,sg.marketprice,sg.thumb,sg.title FROM ' . tablename('ewei_shop_live_goods') . ' lg LEFT JOIN ' . tablename('ewei_shop_goods') . ' sg ON sg.id=lg.goodsid WHERE lg.liveid=:liveid AND lg.goodsid = :goodsid AND lg.uniacid=:uniacid', array(':liveid' => $liveid, ':goodsid' => $value, ':uniacid' => $_W['uniacid']));
				}
			}
		}

		return $goodslist;
	}

	/**
     * 获取socket通讯地址
     * @return bool|string
     */
	public function getWsAddress()
	{
		$file = EWEI_SHOPV2_CORE . 'socket/socket.config.php';

		if (!is_file($file)) {
			return false;
		}

		require_once $file;
		$ws = SOCKET_SERVER_SSL ? 'wss://' : 'ws://';
		return $ws . SOCKET_CLIENT_IP . ':' . SOCKET_SERVER_PORT;
	}
}

?>
