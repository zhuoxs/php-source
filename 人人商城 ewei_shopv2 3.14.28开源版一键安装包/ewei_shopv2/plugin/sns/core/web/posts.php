<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Posts_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and p.uniacid = :uniacid and p.pid=0';
		$params = array(':uniacid' => $_W['uniacid']);
		$bid = intval($_GPC['id']);

		if (!empty($bid)) {
			$board = $this->model->getBoard($bid);
			$condition .= ' and `bid`=' . $bid;
		}

		if ($_GPC['deleted'] != '') {
			$condition .= ' and deleted=' . intval($_GPC['deleted']);
		}

		if ($_GPC['checked'] != '') {
			$condition .= ' and checked=' . intval($_GPC['checked']);
		}

		$uid = intval($_GPC['uid']);

		if (!empty($uid)) {
			$m = m('member')->getMember($uid);

			if (!empty($m)) {
				$condition .= ' and p.openid=:openid';
				$params[':openid'] = $m['openid'];
			}
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ( p.title  like :keyword or p.nickname like :keyword )';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$sql = 'select p.id,p.title,p.createtime,p.content,p.images ,p.replytime, p.openid, p.nickname,p.avatar,p.isbest,p.isboardbest,p.istop,p.isboardtop,
        p.checked,p.deleted,p.isadmin,b.title as boardtitle,b.logo as boardlogo ' . '  from ' . tablename('ewei_shop_sns_post') . ' p ' . ' left join ' . tablename('ewei_shop_sns_board') . ' b on p.bid = b.id  and b.uniacid = p.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = p.openid and m.uniacid = p.uniacid ' . ('  where 1 ' . $condition . ' ORDER BY p.replytime DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' p ' . ' left join ' . tablename('ewei_shop_sns_board') . ' b on p.bid = b.id  and b.uniacid = p.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = p.openid and m.uniacid = p.uniacid ' . (' where 1 ' . $condition), $params);

		foreach ($list as &$row) {
			$row['replycount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where pid=:pid and deleted = 0 limit 1', array(':pid' => $row['id']));
			$images = array();
			$rowimages = iunserializer($row['images']);
			if (is_array($rowimages) && !empty($rowimages)) {
				foreach ($rowimages as $img) {
					if (count($images) <= 2) {
						$images[] = tomedia($img);
					}
				}
			}

			$row['images'] = $images;
			$row['imagewidth'] = '100%';
			$row['imagecount'] = count($rowimages);

			if (count($row['images']) == 2) {
				$row['imagewidth'] = '50%';
			}
			else {
				if (count($row['images']) == 3) {
					$row['imagewidth'] = '33%';
				}
			}

			$row['content'] = $this->model->replaceContent($row['content']);
			$images = iunserializer($row['images']);
			$thumb = '';
			if (is_array($images) && !empty($images)) {
				$thumb = $images[0];
			}

			if (empty($thumb)) {
				$thumb = $row['boardlogo'];
			}

			$row['thumb'] = $thumb;
			$row['needchecks'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where pid=:pid and checked=0 limit 1', array(':pid' => $row['id']));
		}

		unset($row);
		$pager = pagination2($total, $pindex, $psize);
		$category = $this->model->getCategory();
		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	public function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$uniacid = $_W['uniacid'];
		$item = pdo_fetch('select id,bid,title,content,images,istop,isbest,isboardtop,isboardbest,openid
                from ' . tablename('ewei_shop_sns_post') . ' where id = ' . $id . ' and uniacid = ' . $uniacid . ' ');

		if (!empty($item['images'])) {
			$piclist = array_merge(iunserializer($item['images']));
		}

		$board = pdo_fetchall('select id,title from ' . tablename('ewei_shop_sns_board') . ' where uniacid = ' . $uniacid . ' order by id desc ');
		$set = $this->set;

		if (isset($set['managers'])) {
			if (!empty($set['managers'])) {
				$openids = array();
				$strsopenids = explode(',', $set['managers']);

				foreach ($strsopenids as $openid) {
					$openids[] = '\'' . $openid . '\'';
				}

				$managers = pdo_fetchall('select id,nickname,openid from ' . tablename('ewei_shop_member') . '
                            where openid in (' . implode(',', $openids) . ') and uniacid = ' . $uniacid . ' ');
			}
		}

		$imagesData = $this->getSet();

		if ($_W['ispost']) {
			$title = trim($_GPC['title']);
			$len = istrlen($title);

			if ($len < 3) {
				show_json(0, '标题最少3个汉字或字符哦~');
			}

			if (25 < $len) {
				show_json(0, '标题最多25个汉字或字符哦~');
			}

			$content = trim(strip_tags($_GPC['content']));
			$len = istrlen($content);

			if ($len < 3) {
				show_json(0, '内容最少3个汉字或字符哦~');
			}

			$data = array('bid' => intval($_GPC['bid']), 'title' => trim($_GPC['title']), 'openid' => trim($_GPC['openid']), 'content' => trim($_GPC['content']), 'images' => '', 'createtime' => time(), 'replytime' => time(), 'istop' => intval($_GPC['istop']), 'isbest' => intval($_GPC['isbest']), 'isboardtop' => intval($_GPC['isboardtop']), 'isboardbest' => intval($_GPC['isboardbest']), 'checked' => 1, 'isadmin' => 1);

			if (!empty($data['openid'])) {
				$user = pdo_fetch('select avatar,nickname from ' . tablename('ewei_shop_member') . ' where openid = \'' . $data['openid'] . '\' and uniacid = ' . $uniacid . ' ');

				if (empty($user)) {
					show_json(0, '管理员不存在或已删除！');
				}

				$data['avatar'] = $user['avatar'];
				$data['nickname'] = $user['nickname'];
			}

			if (is_array($_GPC['images'])) {
				$imgcount = count($_GPC['images']);
				if ($imagesData['imagesnum'] < $imgcount && 0 < $imagesData['imagesnum']) {
					show_json(0, '话题图片最多上传' . $imagesData['imagesnum'] . '张！');
				}

				if (5 < $imgcount && $imagesData['imagesnum'] == 0) {
					show_json(0, '话题图片最多上传5张！');
				}

				$thumbs = $_GPC['images'];
				$thumb_url = array();

				foreach ($thumbs as $th) {
					$thumb_url[] = trim($th);
				}

				$data['images'] = serialize(m('common')->array_images($thumb_url));
			}

			if (!empty($id)) {
				pdo_update('ewei_shop_sns_post', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('sns.posts.edit', '编辑话题商品 ID: ' . $id . ' <br/>话题名称: ' . $data['title']);
			}
			else {
				$data['uniacid'] = $uniacid;
				pdo_insert('ewei_shop_sns_post', $data);
				$id = pdo_insertid();
				plog('sns.posts.add', '编辑话题商品 ID: ' . $id . '  <br/>话题名称: ' . $data['title']);
			}

			show_json(1, array('url' => webUrl('sns/posts/edit', array('id' => $id))));
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$deleted = intval($_GPC['deleted']);
		$items = pdo_fetchall('SELECT id,title,pid,openid, content FROM ' . tablename('ewei_shop_sns_post') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			$msg = empty($item['pid']) ? '话题' : '评论';
			$content = $this->model->replaceContent($item['content']);

			if ($deleted) {
				plog('sns.posts.delete', '删除' . $msg . ' ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
				pdo_update('ewei_shop_sns_post', array('deleted' => 1, 'deletedtime' => time()), array('id' => $item['id']));

				if ($item['pid']) {
					$this->model->setCredit($item['openid'], $item['id'], SNS_CREDIT_DELETE_REPLY);
				}
				else {
					$this->model->setCredit($item['openid'], $item['id'], SNS_CREDIT_DELETE_POST);
				}
			}
			else {
				plog('sns.posts.delete', '恢复' . $msg . ' ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
				pdo_update('ewei_shop_sns_post', array('deleted' => 0, 'deletedtime' => 0), array('id' => $item['id']));

				if ($item['pid']) {
					$this->model->setCredit($item['openid'], $item['id'], SNS_CREDIT_REPLY);
				}
				else {
					$this->model->setCredit($item['openid'], $item['id'], SNS_CREDIT_POST);
				}
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function delete1()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title,pid,openid, content,deleted FROM ' . tablename('ewei_shop_sns_post') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			$msg = empty($item['pid']) ? '话题' : '评论';
			$content = $this->model->replaceContent($item['content']);
			plog('sns.posts.delete', '彻底删除' . $msg . ' ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
			pdo_delete('ewei_shop_sns_post', array('id' => $item['id']));

			if (!empty($item['deleted'])) {
				if ($item['pid']) {
					$this->model->setCredit($item['openid'], $item['id'], SNS_CREDIT_DELETE_REPLY);
				}
				else {
					$this->model->setCredit($item['openid'], $item['id'], SNS_CREDIT_DELETE_POST);
				}
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function check()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$checked = intval($_GPC['checked']);
		$items = pdo_fetchall('SELECT id,title,content,openid, pid,bid FROM ' . tablename('ewei_shop_sns_post') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			$msg = empty($item['pid']) ? '话题' : '评论';
			$content = $this->model->replaceContent($item['content']);

			if ($checked) {
				plog('sns.posts.edit', '审核通过' . $msg . ' ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
				pdo_update('ewei_shop_sns_post', array('checked' => 1), array('id' => $item['id']));

				if ($item['pid']) {
					$this->model->setCredit($item['openid'], $item['bid'], SNS_CREDIT_REPLY);
				}
				else {
					$this->model->setCredit($item['openid'], $item['bid'], SNS_CREDIT_POST);
				}
			}
			else {
				plog('sns.posts.edit', '取消审核' . $msg . ' ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
				pdo_update('ewei_shop_sns_post', array('checked' => 0), array('id' => $item['id']));

				if ($item['pid']) {
					$this->model->setCredit($item['openid'], $item['bid'], SNS_CREDIT_DELETE_REPLY);
				}
				else {
					$this->model->setCredit($item['openid'], $item['bid'], SNS_CREDIT_DELETE_POST);
				}
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function top()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$all = intval($_GPC['all']);
		$top = intval($_GPC['top']);
		$msg = $all ? '全站' : '版块';
		$field = $all ? 'istop' : 'isboardtop';
		$items = pdo_fetchall('SELECT id,title,content,openid, pid FROM ' . tablename('ewei_shop_sns_post') . (' WHERE id in( ' . $id . ' ) and pid=0 AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			$content = $this->model->replaceContent($item['content']);

			if ($top) {
				plog('sns.posts.edit', $msg . '置顶 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
				pdo_update('ewei_shop_sns_post', array($field => 1), array('id' => $item['id']));
				$type = $all ? SNS_CREDIT_TOP : SNS_CREDIT_TOP_BOARD;
				$this->model->setCredit($item['openid'], $item['id'], $type);
			}
			else {
				plog('sns.posts.edit', '取消' . $msg . '置顶 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
				pdo_update('ewei_shop_sns_post', array($field => 0), array('id' => $item['id']));
				$type = $all ? SNS_CREDIT_TOP_CANCEL : SNS_CREDIT_TOP_BOARD_CANCEL;
				$this->model->setCredit($item['openid'], $item['id'], $type);
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function best()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$all = intval($_GPC['all']);
		$best = intval($_GPC['best']);
		$msg = $all ? '全站' : '版块';
		$field = $all ? 'isbest' : 'isboardbest';
		$items = pdo_fetchall('SELECT id,title,content,openid, pid FROM ' . tablename('ewei_shop_sns_post') . (' WHERE id in( ' . $id . ' ) and pid=0 AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			$content = $this->model->replaceContent($item['content']);

			if ($best) {
				plog('sns.posts.edit', $msg . '精华 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
				pdo_update('ewei_shop_sns_post', array($field => 1), array('id' => $item['id']));
				$type = $all ? SNS_CREDIT_BEST : SNS_CREDIT_BEST_BOARD;
				$this->model->setCredit($item['openid'], $item['id'], $type);
			}
			else {
				plog('sns.posts.edit', '取消' . $msg . '精华 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
				pdo_update('ewei_shop_sns_post', array($field => 0), array('id' => $item['id']));
				$type = $all ? SNS_CREDIT_BEST_CANCEL : SNS_CREDIT_BEST_BOARD_CANCEL;
				$this->model->setCredit($item['openid'], $item['id'], $type);
			}
		}

		show_json(1, array('url' => referer()));
	}
}

?>
