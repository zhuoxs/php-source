<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('material_mass');
$_W['page']['title'] = '永久素材-微信素材';
$dos = array('image', 'del', 'export', 'news', 'down', 'list', 'purview', 'modal', 'send');
$do = in_array($do, $dos) ? $do : 'list';

if($do == 'down') {
	set_time_limit(0);
	load()->func('file');
	$acc = WeAccount::create();
	if(is_error($acc)) {
		message($acc, '', 'ajax');
	}
	$post = $_GPC['__input'];
	$type = $types = $post['type'];
	$count = $acc->getMaterialCount();
	if(is_error($count)) {
		message($count, '', 'ajax');
	}
	$cache_key = "media_sync:{$_W['uniacid']}";
	$has = cache_read($cache_key);
	if(!is_array($has)) {
		$has = array(0);
	}

	$key = $type . '_count';
	$total = $count[$key];
	$pindex = max(1, intval($post['page']));
	$psize = 15;
	$offset = ($pindex - 1) * $psize;
	if($total == 0 || ($pindex > ceil($total / $psize))) {
		$has_str = implode(',', $has);
		pdo_query('DELETE FROM ' . tablename('wechat_attachment') . "  WHERE uniacid = :uniacid AND type = :type AND id NOT IN ({$has_str})", array('uniacid' => $_W['uniacid'], ':type' => $type));
		if($type == 'news') {
			pdo_query('DELETE FROM ' . tablename('wechat_news') . "  WHERE uniacid = :uniacid AND attach_id NOT IN ({$has_str})", array('uniacid' => $_W['uniacid']));
		}
		cache_delete($cache_key);
		message(error(-2, $total), '', 'ajax');
	}
	if($pindex == ceil($total / $psize)) {
		$psize = $total % $psize == 0 ? 15 : ($total % $psize);
	}
	$result = $acc->batchGetMaterial($type, $offset, $psize);
	if(is_error($result)) {
		message($result, '', 'ajax');
	}
	$fail = array();
	if($type == 'voice') {
		$type = 'audio';
	}
	foreach($result['item'] as $data) {
		$pathinfo = pathinfo($data['name']);
		$data['name'] = $pathinfo['filename'] . '.' . $pathinfo['extension'];
		if($type != 'news') {
			$media = pdo_get('wechat_attachment', array('uniacid' => $_W['uniacid'], 'media_id' => $data['media_id']));
			$is_down = 0;
			$url = $tag = '';
			if($type == 'image') {
				if(!empty($media) && !empty($media['attachment'])) {
					if(strexists($media['attachment'], '//mmbiz.qlogo.cn') || (file_exists(ATTACHMENT_ROOT . $media['attachment']))) {
						$has[] = $media['id'];
						continue;
					}
				}
				if(strexists($data['url'], '//mmbiz.qlogo.cn')) {
					$url = $tag = $data['url'];
					$is_down = 1;
				}
			} elseif($types == 'voice') {
				if(!empty($media) && !empty($media['attachment'])) {
					if(file_exists(ATTACHMENT_ROOT . $media['attachment'])) {
						$has[] = $media['id'];
						continue;
					}
				}
			}
			if(!$is_down) {
								$stream = $acc->getMaterial($data['media_id']);
				if(is_error($stream)) {
					$data['message'] = $stream['message'];
					$fail[$data['media_id']] = $data;
					continue;
				}
			}
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $_W['acid'],
				'uid' => $_W['uid'],
				'filename' => $data['name'],
				'attachment' => $stream,
				'media_id' => $data['media_id'],
				'type' => $types,
				'model' => 'perm',
				'tag' => $tag,
				'createtime' => $data['update_time']
			);
			if(empty($media)) {
				pdo_insert('wechat_attachment', $insert);
				$media['id'] = pdo_insertid();
			} else {
				pdo_update('wechat_attachment', $insert, array('uniacid' => $_W['uniacid'], 'media_id' => $data['media_id']));
				$media_id = $media['id'];
			}
			$has[] = $media['id'];
		} else {
			$media = pdo_get('wechat_attachment', array('uniacid' => $_W['uniacid'], 'media_id' => $data['media_id']));
			if(empty($media)) {
				$insert = array(
					'uniacid' => $_W['uniacid'],
					'acid' => $_W['acid'],
					'uid' => $_W['uid'],
					'media_id' => $data['media_id'],
					'type' => $types,
					'model' => 'perm',
					'createtime' => $data['update_time']
				);
				pdo_insert('wechat_attachment', $insert);
				$insert_id = pdo_insertid();
			} else {
				pdo_update('wechat_attachment', array('createtime' => $data['update_time']), array('uniacid' => $_W['uniacid'], 'media_id' => $data['media_id']));
				$insert_id = $media['id'];
				pdo_delete('wechat_news', array('uniacid' => $_W['uniacid'], 'attach_id' => $insert_id));
			}
						$items = $data['content']['news_item'];
			if(!empty($items)) {
				foreach($items as $item) {
					$item['attach_id'] = $insert_id;
					$item['uniacid'] = $_W['uniacid'];
					pdo_insert('wechat_news', $item);
				}
			}
			$has[] = $insert_id;
		}
	}
	cache_write($cache_key, $has);
	message(error($result['total_count'], array('fail' => $fail, 'item_count' => $result['item_count'])), '', 'ajax');
}

if($do == 'list') {
	$type = trim($_GPC['type']) ? trim($_GPC['type']) : 'image';
	$condition = " WHERE uniacid = :uniacid AND type = :type AND model = :model AND media_id != ''";
	$params = array(':uniacid' => $_W['uniacid'], ':type' => $type, ':model' => 'perm');
	$id = intval($_GPC['id']);
	if($id > 0) {
		$condition .= ' AND id = :id';
		$params[':id'] = $id;
	}

	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$limit = " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ", {$psize}";

	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('wechat_attachment') . $condition, $params);
	$lists = pdo_fetchall('SELECT * FROM ' . tablename('wechat_attachment') . $condition . $limit, $params);
	if(!empty($lists)) {
		foreach($lists as &$row) {
			if($type == 'video') {
				$row['tag'] = iunserializer($row['tag']);
			} elseif($type == 'news') {
				$row['items'] = pdo_fetchall("SELECT * FROM " . tablename('wechat_news') . " WHERE uniacid = :uniacid AND attach_id = :attach_id ORDER BY id ASC", array(':uniacid' => $_W['uniacid'], ':attach_id' => $row['id']));
			}
		}
	}
	$pager = pagination($total, $pindex, $psize);

		$groups = pdo_fetch('SELECT * FROM ' . tablename('mc_fans_groups') . ' WHERE uniacid = :uniacid AND acid = :acid', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']));
	if(!empty($groups)) {
		$groups = iunserializer($groups['groups']);
	}
}

if($do == 'purview') {
	$wxname = trim($_GPC['wxname']);
	if(empty($wxname)) {
		exit('微信号不能为空');
	}
	$type = trim($_GPC['type']);
	$media_id = trim($_GPC['media_id']);
	$acc = WeAccount::create();
	$data = $acc->fansSendPreview($wxname, $media_id, $type);
	if(is_error($data)) {
		exit($data['message']);
	}
	exit('success');
}

if($do == 'send') {
	$group = intval($_GPC['group']);
	$type = trim($_GPC['type']);
	$id = intval($_GPC['id']);
	$media = pdo_get('wechat_attachment', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if(empty($media)) {
		exit('素材不存在或已经删除');
	}
	$media_id = trim($media['media_id']);
	$acc = WeAccount::create();
	$data = $acc->fansSendAll($group, $type, $media['media_id']);
	if(is_error($data)) {
		exit($data['message']);
	}
		$groups = pdo_fetch('SELECT * FROM ' . tablename('mc_fans_groups') . ' WHERE uniacid = :uniacid AND acid = :acid', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']));
	if(!empty($groups)) {
		$groups = iunserializer($groups['groups']);
	}
	$record = array(
		'uniacid' => $_W['uniacid'],
		'acid' => $_W['acid'],
		'groupname' => $groups[$group]['name'],
		'fansnum' => $groups[$group]['count'],
		'msgtype' => $type,
		'group' => $group,
		'attach_id' => $id,
		'status' => 0,
		'type' => 0,
		'sendtime' => TIMESTAMP,
		'createtime' => TIMESTAMP,
	);
	pdo_insert('mc_mass_record', $record);
	exit('success');
}



if($do == 'del') {
	$id = intval($_GPC['id']);
	$media = pdo_get('wechat_attachment', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if(empty($media)) {
		exit('素材不存在或已经删除');
	}
	$media_id = trim($media['media_id']);
	$acc = WeAccount::create();
	$data = $acc->delMaterial($media_id);
	if(is_error($data)) {
		exit($data['message']);
	} else {
		pdo_delete('wechat_attachment', array('uniacid' => $_W['uniacid'], 'id' => $id));
		if($type == 'image' || $type == 'voice') {
			$path = ATTACHMENT_ROOT . "/{$media['type']}s/{$_W['uniacid']}/material/{$media['$media_id']}";
			@unlink($path);
		} elseif($type == 'news') {
			pdo_delete('wechat_news', array('uniacid' => $_W['uniacid'], 'attach_id' => $id));
		}
		exit('success');
	}
}
template('material/display');
