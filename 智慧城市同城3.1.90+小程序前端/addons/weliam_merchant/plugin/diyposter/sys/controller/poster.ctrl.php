<?php
defined('IN_IA') or exit('Access Denied');

class Poster_WeliamController {

	public function lists() {
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = ' and uniacid=:uniacid ';

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND `title` LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if (!empty($_GPC['type'])) {
			$condition .= ' AND `type` = :type';
			$params[':type'] = intval($_GPC['type']);
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename(PDO_NAME . 'poster') . (' WHERE 1 ' . $condition . ' ORDER BY createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(PDO_NAME . 'poster') . (' where 1 ' . $condition . ' '), $params);
		$pager = pagination($total, $pindex, $psize);
		
		include wl_template('poster/lists');
	}

	public function post() {
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename(PDO_NAME . 'poster') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			$data = json_decode(str_replace('&quot;', '\'', $item['data']), true);
			$item['otherbg'] = iunserializer($item['otherbg']);
		}

		if (checksubmit()) {
			$data = array(
				'uniacid' => $_W['uniacid'], 
				'title' => trim($_GPC['title']), 
				'type' => intval($_GPC['type']), 
				'bg' => trim($_GPC['bg']),
				'otherbg' => iserializer($_GPC['otherbg']),
				'data' => htmlspecialchars_decode($_GPC['data']), 
				'createtime' => time()
			);
			
			if (!empty($id)) {
				pdo_update(PDO_NAME . 'poster', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
			} else {
				pdo_insert(PDO_NAME . 'poster', $data);
				$id = pdo_insertid();
			}
			Tools::clearwxapp();
			Tools::clearposter();
			
			show_json(1, array('message' => '海报保存成功','url' => web_url('diyposter/poster/post', array('id' => $id))));
		}

		$imgroot = $_W['attachurl'];

		if (empty($_W['setting']['remote'])) {
			setting_load('remote');
		}

		if (!empty($_W['setting']['remote']['type'])) {
			$imgroot = $_W['attachurl_remote'];
		}

		$templist = Tools::getPosterTemp();

		include wl_template('poster/post');
	}

	public function delete() {
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$posters = pdo_fetchall('SELECT id,title FROM ' . tablename(PDO_NAME . 'poster') . (' WHERE id in ( ' . $id . ' ) and uniacid=') . $_W['uniacid']);
		foreach ($posters as $poster) {
			pdo_delete(PDO_NAME . 'poster', array('id' => $poster['id'], 'uniacid' => $_W['uniacid']));
		}
		Tools::clearwxapp();
		Tools::clearposter();
		
		show_json(1, array('url' => web_url('diyposter/poster/lists')));
	}
	
	public function clear() {
		global $_W;
		global $_GPC;
		Tools::clearwxapp();
		Tools::clearposter();
		show_json(1, array('url' => web_url('diyposter/poster/lists')));
	}
}
