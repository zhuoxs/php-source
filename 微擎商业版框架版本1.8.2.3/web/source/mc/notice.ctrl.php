<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$_W['page']['title'] = '发送客服消息 - 粉丝管理 - 粉丝管理';
$dos = array('keyword', 'fans', 'transmit', 'post', 'tpl', 'log', 'end');
$do = in_array($do, $dos) ? $do : 'fans';
define('ACTIVE_FRAME_URL', url('mc/fans/tpl'));
if($do == 'keyword') {
	if($_W['isajax']) {
		$condition = '';
		$key_word = trim($_GPC['key_word']);
		if(!empty($key_word)) {
			$condition = " AND content LIKE '%{$key_word}%' AND (module = 'news' OR module = 'cover')";
		} else {
			$condition = " AND (module = 'news' OR module = 'cover')";
		}

		$data = pdo_fetchall('SELECT content, module, rid FROM ' . tablename('rule_keyword') . " WHERE uniacid = :uniacid AND status != 0 " . $condition . ' ORDER BY uniacid DESC,displayorder DESC LIMIT 100', array(':uniacid' => $_W['uniacid']));
		$exit_da = array();
		if(!empty($data)) {
			foreach($data as $da) {
				$exit_da[] = array('content' => $da['content'], 'rid' => $da['rid']);
			}
		}
		exit(json_encode($exit_da));
	}
	exit('error');
}

if($do == 'fans') {
	$fanid = intval($_GPC['fanid']);
	$fans = pdo_fetch('SELECT acid,openid FROM ' . tablename('mc_mapping_fans') . ' WHERE uniacid = :uniacid AND fanid = :fanid', array(':uniacid' => $_W['uniacid'], ':fanid' => $fanid));
	template('mc/notice');
	exit();
}

if($do == 'post') {
	$msgtype = trim($_GPC['msgtype']);
	$acid = $_W['acid'];
	$send['touser'] = trim($_GPC['openid']);
	$send['msgtype'] = $msgtype;
	$fans = pdo_fetch('SELECT salt,acid,openid FROM ' . tablename('mc_mapping_fans') . ' WHERE acid = :acid AND openid = :openid', array(':acid' => $acid, ':openid' => $send['touser']));
	if($msgtype == 'text') {
		$send['text'] = array('content' => urlencode($_GPC['content']));
	} elseif($msgtype == 'image') {
		$send['image'] = array('media_id' => $_GPC['media_id']);
	} elseif($msgtype == 'voice') {
		$send['voice'] = array('media_id' => $_GPC['media_id']);
	} elseif($msgtype == 'video') {
		$send['video'] = array(
			'media_id' => $_GPC['media_id'],
			'thumb_media_id' => $_GPC['thumb_media_id'],
			'title' => urlencode($_GPC['title']),
			'description' => urlencode($_GPC['description'])
		);
	} elseif($msgtype == 'music') {
		$send['music'] = array(
			'musicurl' => tomedia($_GPC['musicurl']),
			'hqmusicurl' => tomedia($_GPC['hqmusicurl']),
			'title' => urlencode($_GPC['title']),
			'description' => urlencode($_GPC['description']),
			'thumb_media_id' => $_GPC['thumb_media_id'],
		);
	} elseif($msgtype == 'news') {
		$rid = intval($_GPC['ruleid']);
		$rule = pdo_fetch('SELECT module,name FROM ' . tablename('rule') . ' WHERE id = :rid', array(':rid' => $rid));
		if(empty($rule)) {
			exit(json_encode(array('status' => 'error', 'message' => '没有找到指定关键字的回复内容，请检查关键字的对应规则')));
		}
		$idata = array('rid' => $rid, 'name' => $rule['name'], 'module' => $rule['module']);
		$module = $rule['module'];
		$reply = pdo_fetchall('SELECT * FROM ' . tablename($module . '_reply') . ' WHERE rid = :rid', array(':rid' => $rid));
		if($module == 'cover') {
			$idata['do'] = $reply[0]['do'];
			$idata['cmodule'] = $reply[0]['module'];
		}
		if(!empty($reply)) {
			foreach($reply as $c) {
				$row = array();
				$row['title'] = urlencode($c['title']);
				$row['description'] = urlencode($c['description']);
				!empty($c['thumb']) && ($row['picurl'] = tomedia($c['thumb']));

				if(strexists($c['url'], 'http://') || strexists($c['url'], 'https://')) {
					$row['url'] = $c['url'];
				} else {
					$pass['time'] = TIMESTAMP;
					$pass['acid'] = $fans['acid'];
					$pass['openid'] = $fans['openid'];
					$pass['hash'] = md5("{$fans['openid']}{$pass['time']}{$fans['salt']}{$_W['config']['setting']['authkey']}");
					$auth = base64_encode(json_encode($pass));
					$vars = array();
					$vars['__auth'] = $auth;
					$vars['forward'] = base64_encode($c['url']);
					$row['url'] =  $_W['siteroot'] . 'app/' . murl('auth/forward', $vars);
				}
				$news[] = $row;
			}
			$send['news']['articles'] = $news;
		} else {
			$idata = array();
			$send['news'] = '';
		}
	}

	if($acid) {
		$acc = WeAccount::create($acid);
		$data = $acc->sendCustomNotice($send);
		if(is_error($data)) {
			exit(json_encode(array('status' => 'error', 'message' => $data['message'])));
		} else {
						$account = account_fetch($acid);
			$message['from'] = $_W['openid'] = $send['touser'];
			$message['to'] = $account['original'];
			if(!empty($message['to'])) {
				$sessionid = md5($message['from'] . $message['to'] . $_W['uniacid']);
				load()->classs('wesession');
				load()->classs('account');
				session_id($sessionid);
				WeSession::start($_W['uniacid'], $_W['openid'], 300);
				$processor = WeUtility::createModuleProcessor('chats');
				$processor->begin(300);
			}

			if($send['msgtype'] == 'news') {
				$send['news'] = $idata;
			}
						pdo_insert('mc_chats_record',array(
				'uniacid' => $_W['uniacid'],
				'acid' => $acid,
				'flag' => 1,
				'openid' => $send['touser'],
				'msgtype' => $send['msgtype'],
				'content' => iserializer($send[$send['msgtype']]),
				'createtime' => TIMESTAMP,
			));
			exit(json_encode(array('status' => 'success', 'message' => '消息发送成功')));
		}
		exit();
	}
}

if($do == 'tpl') {
	$fanid = intval($_GPC['id']);
	$fans = pdo_fetch('SELECT fanid,acid,uid,tag,openid FROM ' . tablename('mc_mapping_fans') . ' WHERE uniacid = :uniacid AND fanid = :id', array(':uniacid' => $_W['uniacid'], ':id' => $fanid));
	$account = account_fetch($fans['acid']);
	if(empty($account['original'])) {
		message('发送客服消息前,您必须完善公众号原始ID', url('account/post', array('acid' => $fans['acid'], 'uniacid' => $_W['uniacid'])));
	}
	$maxid = pdo_fetchcolumn('SELECT id FROM ' . tablename('mc_chats_record') . ' WHERE acid=:acid AND openid = :openid  ORDER BY id DESC LIMIT 1', array(':acid' => $fans['acid'], ':openid' => $fans['openid']));
	$maxid = ($maxid - 5) > 0 ? ($maxid - 5) : 0;
	if(!empty($fans)) {
		if (is_base64($fans['tag'])){
			$fans['tag'] = base64_decode($fans['tag']);
		}
		if (is_serialized($fans['tag'])) {
			$fans['tag'] = iunserializer($fans['tag']);
		}
	}
	if(!empty($fans['tag']['nickname'])) {
		$nickname = $fans['tag']['nickname'];
	} else {
		$nickname = $fans['openid'];
	}
	template('mc/notice');
}

if($do == 'log') {
	$fanid = intval($_GPC['fanid']);
	$id = intval($_GPC['id']);
	$type = trim($_GPC['type']) ? trim($_GPC['type']) : 'asc';
	$fans = pdo_fetch('SELECT fanid,acid,openid,tag FROM ' . tablename('mc_mapping_fans') . ' WHERE uniacid = :uniacid AND fanid = :id', array(':uniacid' => $_W['uniacid'], ':id' => $fanid));
	if(!empty($fans)) {
		if (is_base64($fans['tag'])){
			$fans['tag'] = base64_decode($fans['tag']);
		}
		if (is_serialized($fans['tag'])) {
			$fans['tag'] = iunserializer($fans['tag']);
		}
		if(!empty($fans['tag']['headimgurl'])) {
			$avatar = rtrim($fans['tag']['headimgurl'], '0');
		} else {
			$avatar = 'resource/images/noavatar_middle.gif';
		}
	}
	if($type == 'asc') {
		$data = pdo_fetchall('SELECT * FROM ' . tablename('mc_chats_record') . ' WHERE acid=:acid AND openid = :openid AND id > :id ORDER BY id ASC LIMIT 5', array(':acid' => $fans['acid'], ':openid' => $fans['openid'], ':id' => $id), 'id');
	} else {
		$data = pdo_fetchall('SELECT * FROM ' . tablename('mc_chats_record') . ' WHERE acid=:acid AND openid = :openid AND id < :id ORDER BY id DESC LIMIT 5', array(':acid' => $fans['acid'], ':openid' => $fans['openid'], ':id' => $id), 'id');
	}
	ksort($data);
	if(!empty($data)) {
		$str = '';
		foreach($data as &$da) {
			$da['content'] = is_serialized($da['content']) ? iurldecode(iunserializer($da['content'])) : iurldecode($da['content']);
			if($da['flag'] == 2) {
				if($da['msgtype'] == 'text') {
					$str .= tpl_chats_log(emotion($da['content']), $da['createtime']);
				} elseif($da['msgtype'] == 'image') {
					$imageurl = tomedia($da['content'], true);
					$content = '<a href="'.$imageurl.'" target="_blank"><img src="'.$imageurl.'" width="200"></a>';
					$str .= tpl_chats_log($content, $da['createtime']);
				} elseif($da['msgtype'] == 'link') {
					$content = '<a href="'.$da['content'].'" target="_blank">'.$da['content'].'</a>';
					$str .= tpl_chats_log($content, $da['createtime']);
				} elseif($da['msgtype'] == 'location') {
					$content = '<a target="_blank" href="https://st.map.soso.com/api?size=800*600&center='.$da['content']['location_y'].','.$da['content']['location_x'].'&zoom='.$da['content']['scale'].'&markers='.$da['content']['location_y'].','.$da['content']['location_x'].'"><img src="data:image/jpg;base64,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"></a>';
					$str .= tpl_chats_log($content, $da['createtime']);
				}
			} else {
				if($da['msgtype'] == 'text') {
					$str .= tpl_chats_log(emotion($da['content']['content']), $da['createtime'], 1);
				} elseif($da['msgtype'] == 'image') {
					$image = media2local($da['content']['media_id']);
					$content = '<a href="'.$image.'" target="_blank"><img src="'.$image.'" width="200"></a>';
					$str .= tpl_chats_log($content, $da['createtime'], 1);
				} elseif($da['msgtype'] == 'voice') {
					$image = media2local($da['content']['media_id']);
					$content = '<a href="'.$image.'" target="_blank"><i class="fa fa-bullhorn"></i> 语音消息</a>';
					$str .= tpl_chats_log($content, $da['createtime'], 1);
				} elseif($da['msgtype'] == 'music') {
					$music = tomedia($da['content']['hqmusicurl']);
					if(empty($music)) {
						$music = tomedia($da['content']['musicurl']);
					}
					$content = '<a href="'.$music.'" target="_blank"><i class="fa fa-music"></i> 音乐消息</a>';
					$str .= tpl_chats_log($content, $da['createtime'], 1);
				} elseif($da['msgtype'] == 'video') {
					$video = media2local($da['content']['media_id']);
					$content = '<a href="'.$video.'" target="_blank"><i class="fa fa-video-camera"></i> 视频消息</a>';
					$str .= tpl_chats_log($content, $da['createtime'], 1);
				} elseif($da['msgtype'] == 'news') {
					if($da['content']['module'] == 'news') {
						$url = url('platform/reply/post', array('m' => 'news', 'rid' => $da['content']['rid']));
					} elseif($da['content']['module'] == 'cover') {
						if(in_array($da['content']['cmodule'], array('mc', 'site', 'card'))) {
							$url = url('platform/cover/' . $da['content']['cmodule']);
						} else {
							$eid = pdo_fetchcolumn('SELECT eid FROM ' . tablename('modules_bindings') . ' WHERE module = :m AND do = :do AND entry = :entry', array(':m' => $da['content']['cmodule'], ':do' => $da['content']['do'], ':entry' => 'cover'));
							$li['url'] = url('platform/cover/', array('eid' => $eid));
						}
					}
					$content = '<a href="'. $url .'" target="_blank"><i class="fa fa-file-image-o"></i> 图文消息：' . $da['content']['name'] . '</a>';
					$str .= tpl_chats_log($content, $da['createtime'], 1);
				}
			}
		}
		if($type == 'asc') {
			$exit = json_encode(array('code' => 1, 'str' => $str, 'id' => max(array_keys($data))));
		} else {
			$exit = json_encode(array('code' => 1, 'str' => $str, 'id' => min(array_keys($data))));
		}
	} else {
		$exit = json_encode(array('code' => 2, 'str' => '', 'id' => $id));
	}
	echo $exit;
	exit();
}

if($do == 'end') {
	$fanid = intval($_GPC['fanid']);
	$fans = pdo_fetch('SELECT fanid,acid,openid FROM ' . tablename('mc_mapping_fans') . ' WHERE uniacid = :uniacid AND fanid = :id', array(':uniacid' => $_W['uniacid'], ':id' => $fanid));
	$account = account_fetch($fans['acid']);
	$message['from'] = $_W['openid'] = $fans['openid'];
	$message['to'] = $account['original'];
	if(!empty($message['to'])) {
		$sessionid = md5($message['from'] . $message['to'] . $_W['uniacid']);
		load()->classs('wesession');
		load()->classs('account');
		session_id($sessionid);
		WeSession::start($_W['uniacid'], $_W['openid'], 300);
		$processor = WeUtility::createModuleProcessor('chats');
		$processor->end();
	}
	if(!empty($_GPC['from'])) {
		$url = base64_decode($_GPC['from']);
	} else {
		$url = url('mc/fans/', array('acid' => $fans['acid']));
	}
	header('Location:' . $url);
	exit();
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
function tpl_chats_log($content, $time, $flag = 2) {
	global $avatar;
	if($flag == 2) {
		$str = '<div class="pull-left col-lg-12 col-md-12 col-sm-12 col-xs-12">' .
					'<div class="pull-left">' .
						'<img src="' . $avatar . '" width="35"><br>' .
					'</div>' .
					'<div class="alert alert-info pull-left infol">' .
						$content . '<br>' . date('m-d H:i:s', $time) .
					'</div>' .
					'<div style="clear:both"></div>' .
				'</div>'.
				'<div style="clear:both"></div>';
	} else {
		$str = '<div class="pull-left col-lg-12 col-md-12 col-sm-12 col-xs-12">' .
					'<div class="pull-right">' .
						'<img src="resource/images/gw-wx.gif" width="35" style="border:2px solid #418BCA;border-radius:5px"><br>' .
					'</div>' .
					'<div class="alert alert-info pull-right infor">' .
						$content . '<br>' .  date('m-d H:i:s', $time) .
					'</div>' .
					'<div style="clear:both"></div>' .
				'</div>'.
				'<div style="clear:both"></div>';
	}
	return $str;
}
