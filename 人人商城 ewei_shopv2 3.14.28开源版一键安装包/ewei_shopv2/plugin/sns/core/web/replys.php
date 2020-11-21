<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Replys_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and p.uniacid = :uniacid and p.pid=0';
		$params = array(':uniacid' => $_W['uniacid']);
		$pid = intval($_GPC['id']);
		$bid = 0;

		if (!empty($pid)) {
			$post = $this->model->getPost($pid);
			$member = $this->model->getMember($post['openid']);
			$member['postcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid=0 and deleted=0 limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
			$member['replycount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid>0 and deleted=0  limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));
			$level = array('levelname' => empty($set['levelname']) ? '社区粉丝' : $set['levelname'], 'color' => empty($set['levelcolor']) ? '#333' : $set['levelcolor'], 'bg' => empty($set['levelbg']) ? '#eee' : $set['levelbg']);

			if (!empty($member['sns_level'])) {
				$level = pdo_fetch('select * from ' . tablename('ewei_shop_sns_level') . ' where id=:id  limit 1', array(':id' => $member['sns_level']));
			}

			$post['content'] = $this->model->replaceContent($post['content']);
			$post['images'] = iunserializer($post['images']);

			if (!is_array($post['images'])) {
				$post['images'] = array();
			}

			$bid = $post['bid'];
			$isManager = $this->model->isManager($bid, $member['openid']);
		}

		if (!empty($bid)) {
			$board = $this->model->getBoard($bid);
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and `uniacid` = :uniacid and pid>0';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($post)) {
			$condition .= ' and pid=:pid ';
			$params[':pid'] = $pid;
		}

		if ($_GPC['deleted'] != '') {
			$condition .= ' and deleted=' . intval($_GPC['deleted']);
		}

		if ($_GPC['checked'] != '') {
			$condition .= ' and checked=' . intval($_GPC['checked']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and p.title  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$sql = 'select id,bid,pid, rpid,title,createtime,content,images ,openid, nickname,avatar,checked,deleted from ' . tablename('ewei_shop_sns_post') . ('  where 1 ' . $condition . ' ORDER BY createtime asc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . (' where 1 ' . $condition), $params);

		foreach ($list as $key => &$row) {
			$row['goodcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_like') . ' where pid=:pid limit 1', array(':pid' => $row['id']));
			$row['postcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where pid=:pid limit 1', array(':pid' => $row['id']));
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
			$row['imagewidth'] = '32%';
			$row['imagecount'] = count($rowimages);
			$row['content'] = $this->model->replaceContent($row['content']);
			$row['parent'] = false;

			if (!empty($row['rpid'])) {
				$parentPost = $this->model->getPost($row['rpid']);
				$row['parent'] = array('nickname' => $parentPost['nickname'], 'content' => $this->model->replaceContent($parentPost['content']));
			}

			if (empty($post)) {
				$board = $this->model->getBoard($row['bid']);
				$sthumb = tomedia($board['logo']);
				$subject = $this->model->getPost($row['pid']);
				$simages = iunserializer($subject['imagers']);

				if (!empty($simages)) {
					$sthumb = tomedia($simages[0]);
				}

				$row['subject'] = array('nickname' => $subject['nickname'], 'title' => $subject['title'], 'boardtitle' => $board['title'], 'thumb' => $sthumb);
			}

			$row['goodcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_like') . ' where uniacid=:uniacid and pid=:pid  limit 1', array(':uniacid' => $_W['uniacid'], ':pid' => $row['id']));
			$rmember = $this->model->getMember($row['openid']);
			$rlevel = array('levelname' => empty($set['levelname']) ? '社区粉丝' : $set['levelname'], 'color' => empty($set['levelcolor']) ? '#333' : $set['levelcolor'], 'bg' => empty($set['levelbg']) ? '#eee' : $set['levelbg']);

			if (!empty($rmember['sns_level'])) {
				$rlevel = pdo_fetch('select * from ' . tablename('ewei_shop_sns_level') . ' where id=:id  limit 1', array(':id' => $rmember['sns_level']));
			}

			$row['member'] = array('id' => $rmember['id'], 'sns_credit' => $rmember['sns_credit'], 'postcount' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid=0 and deleted=0 limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $rmember['openid'])), 'replycount' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid>0 and deleted=0 limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $rmember['openid'])));
			$row['level'] = $rlevel;
			$row['floor'] = ($pindex - 1) * $psize + $key + 2;
			$row['isAuthor'] = $row['openid'] == $post['openid'];
			$row['isManager'] = $this->model->isManager($row['bid']);
		}

		unset($row);
		$pager = pagination2($total, $pindex, $psize);
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
		$items = pdo_fetchall('SELECT id,title,content,openid, pid FROM ' . tablename('ewei_shop_sns_post') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			$msg = empty($item['pid']) ? '话题' : '评论';
			$content = $this->model->replaceContent($item['content']);

			if ($checked) {
				plog('sns.posts.edit', '审核通过' . $msg . ' ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
				pdo_update('ewei_shop_sns_post', array('checked' => 1), array('id' => $item['id']));

				if ($item['pid']) {
					$this->model->setCredit($item['openid'], $item['id'], SNS_CREDIT_DELETE_REPLY);
				}
				else {
					$this->model->setCredit($item['openid'], $item['id'], SNS_CREDIT_DELETE_POST);
				}
			}
			else {
				plog('sns.posts.edit', '取消审核' . $msg . ' ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 内容: ' . $content);
				pdo_update('ewei_shop_sns_post', array('checked' => 0), array('id' => $item['id']));

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
}

?>
