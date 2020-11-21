<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('mc_mass');
$dos = array('default', 'post', 'send', 'ajax', 'news', 'fans', 'page', 'add', 'material');
$_W['page']['title'] = '微信群发-粉丝管理';
$do = in_array($do, $dos) ? $do : 'default';
if($do == 'page') {
	template('mc/page');
}

if($do == 'default') {
	if($_W['account']['level'] > 2) {
		$groups_data = pdo_fetch('SELECT * FROM ' . tablename('mc_fans_groups') . ' WHERE uniacid = :uniacid AND acid = :acid', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']));
		if(!empty($groups_data)) {
			$groups = iunserializer($groups_data['groups']);
		} else {
			message('未获取到粉丝分组信息,现在去拉取粉丝分组', url('mc/fangroup'), 'info');
		}
	}
	template('mc/mass');
}

if($do == 'news') {
	$condition = ' WHERE uniacid = :uniacid AND status = 1 AND module = :module';
	$param = array(':uniacid' => $_W['uniacid'], ':module' => 'news');
	if(!empty($_GPC['keyword'])) {
		$condition .= ' AND name LIKE :keyword';
		$param[':keyword'] = "%{$_GPC['keyword']}%";
	}
	$psize = 8;
	$pindex = max(1, intval($_GPC['page']));
	$limit = ' ORDER BY id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('rule') . $condition, $param);
	$data = pdo_fetchall('SELECT id, name FROM ' . tablename('rule') . $condition . $limit, $param, 'id');
	if(!empty($data)) {
		foreach($data as &$da) {
			$da['replies'] = pdo_fetchall('SELECT id,title,thumb FROM ' . tablename('news_reply') . ' WHERE rid = :rid ORDER BY `displayorder` DESC', array(':rid' => $da['id']));
			if(!empty($da['replies'])) {
				foreach($da['replies'] as &$li) {
					if(!empty($li['thumb'])) $li['thumb'] = tomedia($li['thumb']);
				}
			}
		}
	}
	$result = array(
		'list' => $data,
		'pager' => pagination($total, $pindex, $psize, '', array('before' => '2', 'after' => '3', 'ajaxcallback'=>'null')),
	);
	message($result, '', 'ajax');
}

if($do == 'fans') {
	$condition = " WHERE uniacid = :uniacid AND acid = :acid AND follow = 1 AND openid != ''";
	$param = array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']);
	if(!empty($_GPC['keyword'])) {
		$condition .= ' AND nickname LIKE :keyword';
		$param[':keyword'] = "%{$_GPC['keyword']}%";
	}
	$psize = 10;
	$pindex = max(1, intval($_GPC['page']));
	$limit = ' ORDER BY followtime DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_mapping_fans') . $condition, $param);
	$data = pdo_fetchall('SELECT fanid,openid,nickname,followtime,tag FROM ' . tablename('mc_mapping_fans') . $condition . $limit, $param, 'fanid');
	if(!empty($data)) {
		foreach($data as &$da) {
			$da['selected'] = 0;
			if(empty($da['nickname'])) {
				$da['nickname'] = $da['openid'];
			}
			$da['avatar'] = './resource/images/noavatar_middle.gif';
			if (!empty($da['tag']) && is_string($da['tag'])) {
				if (is_base64($da['tag'])){
					$da['tag'] = base64_decode($da['tag']);
				}
				if (is_serialized($da['tag'])) {
					$da['tag'] = @iunserializer($da['tag']);
				}
				if(!empty($da['tag']['headimgurl'])) {
					$da['avatar'] = tomedia($da['tag']['headimgurl']);
				}
				unset($da['tag']);
			}
			$da['followtime'] = date('Y-m-d H:i', $da['followtime']);
		}
	}
	$result = array(
		'list' => $data,
		'pager' => pagination($total, $pindex, $psize, '', array('before' => '2', 'after' => '3', 'ajaxcallback'=>'null')),
	);
	message($result, '', 'ajax');
}

if($do == 'post') {
	set_time_limit(0);
	error_reporting(E_ERROR);
	$post = $_GPC['__input'];
	if($_GPC['send_time'] == 2) {
		$time = strtotime($_GPC['time']);
		if($time <= TIMESTAMP || $time >= (TIMESTAMP + 86400*3 - 7200)) {
			$time = date('Y-m-d H:i', TIMESTAMP + 86400*3 - 7200);
			message(error(-1, "定时发送时间不能小于当前时间并且不能超过{$time}"), '', 'ajax');
		}
	}

	$acc = WeAccount::create($_W['acid']);
	if($post['msg_type'] == 'mpnews') {
		$rid = intval($post['data']);
		$rule = pdo_fetch('SELECT * FROM ' . tablename('rule') . ' WHERE uniacid = :uniacid AND id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $rid));
		if(empty($rule)) {
			message(error(-1, '规则不存在'), '', 'ajax');
		}
		$replies = pdo_fetchall('SELECT * FROM ' . tablename('news_reply') . ' WHERE rid = :rid ORDER BY `displayorder` DESC', array(':rid' => $rid));
				$thumb_message = '';
		foreach($replies as &$reply) {
			$flag = 1;
			if(empty($reply['content'])) {
				$thumb_message .= "标题为 '{$reply['title']}' 回复项的内容为空<br>";
			}
			if(!empty($_W['setting']['remote']['type'])) {
				load()->func('file');
				$reply['thumb'] = file_fetch(tomedia($reply['thumb']));
				if(is_error($reply['thumb'])) {
					$flag = 0;
					$thumb_message .= "标题为 '{$reply['title']}' 回复项的封面图片获取失败,请重新上传，错误详情：{$reply['thumb']['message']}<br>";
				}
			}
			if($flag) {
				$path = ATTACHMENT_ROOT . ltrim($reply['thumb'], '/');
				if(!file_exists($path)) {
					$thumb_message .= "标题为 '{$reply['title']}' 回复项的封面图片不存在<br>";
				} else {
					$extension = ltrim(strrchr($reply['thumb'], '.'), '.');
					if(!in_array($extension, array('jpg', 'png'))) {
						$thumb_message .= "标题为 '{$reply['title']}' 回复项的封面图片格式不对，仅支持jpg,png格式。<br>";
					}
					if(filesize($path) > 64 * 1024) {
						$thumb_message .= "标题为 '{$reply['title']}' 回复项的封面图片大于64K。<br>";
					}
				}
			}
		}
		if(!empty($thumb_message)) {
			message(error(-1, $thumb_message), '', 'ajax');
		}
		$articles = array(
			'articles' => array()
		);
		foreach($replies as &$reply) {
			$media = $acc->uploadMedia($reply['thumb']);
			if(is_error($media)) {
				message($media, '', 'ajax');
			}
			if(!strexists($reply['url'], 'http://') && !strexists($reply['url'], 'https://')) {
				$reply['url'] = $_W['siteroot'] . 'app' . ltrim($reply['url'], '.');
			}
			$str_find = array('../attachment/images');
			$str_replace = array($_W['siteroot'] . 'attachment/images');
			$reply['content'] =  str_replace($str_find, $str_replace, $reply['content']);
			$row = array(
				'title' => urlencode($reply['title']),
				'author' => urlencode($reply['author']),
				'digest' => urlencode($reply['description']),
				'content' => urlencode(addslashes(htmlspecialchars_decode($reply['content']))),
				'show_cover_pic' => intval($reply['incontent']),
				'content_source_url' => urlencode($reply['url']),
				'thumb_media_id' => $media['media_id'],
			);
			$articles['articles'][] = $row;
		}
		$status = $acc->uploadNews($articles);
		if(is_error($status)) {
			message($status, '', 'ajax');
		}
		$data['mpnews'] = array(
			'media_id' => $status['media_id'],
		);
		$data['msgtype'] = 'mpnews';
	}

	if($post['msg_type'] == 'text') {
		$data['text'] = array(
			'content' => urlencode(trim($post['data'])),
		);
		$data['msgtype'] = 'text';
	}

	if($post['msg_type'] == 'image') {
		$data['image'] = array(
			'media_id' => urlencode(trim($post['data'])),
		);
		$data['msgtype'] = 'image';
	}

	if($post['msg_type'] == 'voice') {
		$data['voice'] = array(
			'media_id' => urlencode(trim($post['data'])),
		);
		$data['msgtype'] = 'voice';
	}

	if($post['msg_type'] == 'video') {
		$video = array(
			'media_id' => $post['data']['media'],
			'title' => urlencode($post['data']['title']),
			'description' => urlencode($post['data']['description']),
		);
		$status = $acc->uploadVideo($video);
		if(is_error($status)) {
			message($status, '', 'ajax');
		}
				if($post['send_type'] == '3') {
			$data['video'] = array(
				'media_id' => $status['media_id'],
			);
			$data['msgtype'] = 'video';
		}
		if($post['send_type'] == '2') {
			$data['mpvideo'] = array(
				'media_id' => $status['media_id'],
			);
			$data['msgtype'] = 'mpvideo';
		}
	}

	if($post['send_type'] == 1) {
		$data['filter'] = array(
			'is_to_all' => true,
			'group_id' => 0,
		);
	} elseif($post['send_type'] == 2) {
		$data['filter'] = array(
			'is_to_all' => false,
			'group_id' => intval($post['send_group']),
		);
	} elseif($post['send_type'] == 3) {
		$data['touser'] = $post['openids'];
	}
	$record = 0;
	if($_GPC['send_time'] == 1) {
				$status = $acc->fansSendAll($data);
		if(is_error($status)) {
			message($status, '', 'ajax');
		}
	}
		if($post['msg_type'] == 'mpnews') {
		$post['msg_type'] = 'news';
	}
	$insert = array(
		'uniacid' => $_W['uniacid'],
		'acid' => $_W['acid'],
		'msgtype' => $post['msg_type'],
		'createtime' => TIMESTAMP,
	);
	if($post['send_time'] == 1) {
		$insert['status'] = 0;
	} else {
		$insert['sendtime'] = $time;
		$insert['status'] = 1;
		$insert['data'] = iserializer($data);
	}
	if($post['send_type'] == 1) {
		$insert['groupname'] = '全部用户';
		$insert['fansnum'] = '';
	} elseif($post['send_type'] == 2) {
		$groups_data = pdo_fetch('SELECT * FROM ' . tablename('mc_fans_groups') . ' WHERE uniacid = :uniacid AND acid = :acid', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']));
		$groups = iunserializer($groups_data['groups']);
		$insert['groupname'] = $groups[$post['send_group']]['name'];
		$insert['fansnum'] = $groups[$post['send_group']]['count'];
	} elseif($post['send_type'] == 3) {
				$insert['groupname'] = '根据粉丝openid群发';
		$insert['fansnum'] = count($post['openids']);
	}

	if(in_array($post['msg_type'], array('text', 'image', 'voice'))) {
		$insert['content'] = $post['data'];
	} elseif($post['msg_type'] == 'video') {
		$insert['content'] = $post['data']['media_id'];
	} elseif($post['msg_type'] == 'news') {
		$insert['content'] = intval($post['data']);
	}
	pdo_insert('mc_mass_record', $insert);
	message(error(1, ''), '', 'ajax');
}

if($do == 'send') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = ' WHERE `uniacid` = :uniacid AND `acid` = :acid';
	$pars = array();
	$pars[':uniacid'] = $_W['uniacid'];
	$pars[':acid'] = $_W['acid'];
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('mc_mass_record').$condition, $pars);
	$list = pdo_fetchall("SELECT * FROM ".tablename('mc_mass_record') . $condition ." ORDER BY `id` DESC LIMIT ".($pindex - 1) * $psize.','.$psize, $pars);
	$types = array('text' => '文本消息', 'image' => '图片消息', 'voice' => '语音消息', 'video' => '视频消息', 'news' => '图文消息');
	if(!empty($list)) {
		foreach($list as &$li) {
			if($li['msgtype'] == 'news') {
								$rid = intval($li['content']);
				if($rid > 0) {
					$li['rid'] = $rid;
					$li['rule_name'] = pdo_fetchcolumn('SELECT name FROM ' . tablename('rule') . ' WHERE id = :id', array(':id' => $rid));
				} else {
					$li['content'] = iunserializer($li['content']);
					$li['content'] = iurldecode($li['content']);
				}
			} elseif(in_array($li['msgtype'], array('image', 'voice', 'video'))) {
				$li['content'] = media2local($li['content']);
			}
		}
	}
	$pager = pagination($total, $pindex, $psize);
	template('mc/send');
}

function iurldecode($str) {
	if(!is_array($str)) {
		return urldecode($str);
	}
	foreach($str as $key => $val) {
		$str[$key] = iurldecode($val);
	}
	return $str;
}
