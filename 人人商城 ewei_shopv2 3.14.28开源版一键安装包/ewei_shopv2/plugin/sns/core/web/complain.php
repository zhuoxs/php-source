<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Complain_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and uniacid=:uniacid ';
		$uniacid = $_W['uniacid'];
		$params = array(':uniacid' => $uniacid);
		$type = trim($_GPC['type']);

		if ($type == 'processed') {
			$condition .= ' and checked = 1 and deleted = 0 ';
		}
		else if ($type == 'untreated') {
			$condition .= ' and checked = 0 and deleted = 0 ';
		}
		else if ($type == 'cancel') {
			$condition .= ' and checked = -1 and deleted = 0 ';
		}
		else {
			if ($type == 'deleted') {
				$condition .= ' and deleted = 1 ';
			}
		}

		$starttime = intval($_GPC['']);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		$searchtime = trim($_GPC['searchtime']);

		if (!empty($searchtime)) {
			$condition .= ' and ' . $searchtime . 'time > ' . strtotime($_GPC['time']['start']) . ' and ' . $searchtime . 'time < ' . strtotime($_GPC['time']['end']) . ' ';
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and complaint_text like :keyword ';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$complains = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_sns_complain') . '
					WHERE 1=1 ' . $condition . ' ORDER BY id DESC limit ' . ($pindex - 1) * $psize . ',' . $psize, $params);

		if (empty($complains)) {
			$complains = array();
		}

		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_sns_complain') . (' WHERE 1 ' . $condition), $params);

		foreach ($complains as $key => $value) {
			$complains[$key]['complainant'] = $this->getMember($value['complainant']);
			$complains[$key]['defendant'] = $this->getMember($value['defendant']);
			$post = pdo_fetch('select content from ' . tablename('ewei_shop_sns_post') . '
											where id = ' . $value['postsid'] . ' and uniacid = ' . $value['uniacid'] . ' ');
			$content = $this->model->replaceContent($post['content']);
			$complains[$key]['content'] = $content;

			if ($value['complaint_type'] <= 0) {
				$complains[$key]['typename'] = '其他';
			}
			else {
				$complaint_type = pdo_fetch('select name from ' . tablename('ewei_shop_sns_complaincate') . '
											where id = ' . $value['complaint_type'] . ' and uniacid = ' . $value['uniacid'] . ' ');
				$complains[$key]['typename'] = $complaint_type['name'];
			}

			$complains[$key]['images'] = iunserializer($value['images']);

			if (!is_array($value['images'])) {
				$value['images'] = array();
			}
		}

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

		$items = pdo_fetchall('SELECT id,checked FROM ' . tablename('ewei_shop_sns_complain') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (empty($items)) {
			$items = array();
		}

		foreach ($items as $item) {
			if ($item['checked'] == 0) {
				$delete_update = pdo_update('ewei_shop_sns_complain', array('deleted' => 1, 'checked' => -1), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			}
			else {
				$delete_update = pdo_update('ewei_shop_sns_complain', array('deleted' => 1), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			}

			if (!$delete_update) {
				show_json(0, '删除投诉失败！');
			}

			plog('sns.posts.complain.delete', '删除投诉 ID: ' . $id . ' ');
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

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_sns_complain') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (empty($items)) {
			$items = array();
		}

		foreach ($items as $item) {
			pdo_delete('ewei_shop_sns_complain', array('id' => $item['id']));
			plog('sns.posts.complain.delete1', '彻底删除投诉 ID: ' . $id . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function checked()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$complain = pdo_fetch('select postsid,complainant from ' . tablename('ewei_shop_sns_complain') . ' where uniacid = ' . $_W['uniacid'] . ' and id = ' . $id . ' ');

		if (empty($complain)) {
			show_json(0, '该投诉申请不存在！');
		}

		$type = intval($_GPC['type']);

		if ($type <= 0) {
			$typename['name'] = '其他';
		}
		else {
			$typename = pdo_fetch('select name from ' . tablename('ewei_shop_sns_complaincate') . ' where id = ' . $type . ' and uniacid = ' . $_W['uniacid'] . ' ');
		}

		$post = pdo_fetch('select id,title,content,images from ' . tablename('ewei_shop_sns_post') . ' where uniacid = ' . $_W['uniacid'] . ' and id = ' . $complain['postsid'] . ' ');
		$post['content'] = $this->model->replaceContent($post['content']);
		$post['images'] = iunserializer($post['images']);

		if (!is_array($post['images'])) {
			$post['images'] = array();
		}

		if (empty($post)) {
			show_json(0, '该话题/评论不存在！');
		}

		if ($_W['ispost']) {
			$status = intval($_GPC['status']);

			if ($status == 1) {
				$delete_update = pdo_update('ewei_shop_sns_post', array('deleted' => 1), array('id' => $complain['postsid'], 'uniacid' => $_W['uniacid']));
				$delete_update = pdo_update('ewei_shop_sns_post', array('deleted' => 1), array('rpid' => $complain['postsid'], 'uniacid' => $_W['uniacid']));
				$complainPost = pdo_fetchall('select id from ' . tablename('ewei_shop_sns_complain') . '
				where postsid = ' . $complain['postsid'] . ' and uniacid = ' . $_W['uniacid'] . ' and checked = 0 ');

				if (empty($complainPost)) {
					$complainPost = array();
				}

				foreach ($complainPost as $key => $value) {
					$delete_update = pdo_update('ewei_shop_sns_complain', array('checked' => 1), array('id' => $value['id'], 'uniacid' => $_W['uniacid']));
					plog('sns.posts.complain.checked', '投诉 ID: ' . $id . ' 已处理，该话题/评论已删除！');
					$resule = $this->sendComMessage($value['id']);
				}
			}
			else if ($status == -1) {
				$delete_update = pdo_update('ewei_shop_sns_complain', array('checked' => -1), array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('sns.posts.complain.checked', '投诉 ID: ' . $id . ' 未通过审核！');
				$resule = $this->sendComMessage($id, false);
			}
			else {
				show_json(0, '请选择处理方式！');
			}

			show_json(1);
		}

		include $this->template();
	}

	public function sendComMessage($complainid, $type = true)
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$complainid = intval($complainid);

		if (empty($complainid)) {
			return NULL;
		}

		$complain = pdo_fetch('select id,complainant,postsid from ' . tablename('ewei_shop_sns_complain') . ' where id = ' . $complainid . ' and uniacid = ' . $uniacid . ' ');

		if (empty($complain)) {
			return NULL;
		}

		$member = $this->model->getMember($complain['complainant']);

		if (empty($member)) {
			return NULL;
		}

		$post = pdo_fetch('select id,pid from ' . tablename('ewei_shop_sns_post') . ' where id = ' . $complain['postsid'] . ' and uniacid = ' . $uniacid . ' ');

		if (empty($post)) {
			return NULL;
		}

		if ($post['pid'] == 0) {
			$info = '话题';
		}
		else {
			$info = '评论';
		}

		if ($type == false) {
			$remark = '您提交的对于' . $member['nickname'] . '发表' . $info . '的投诉未通过审核！谢谢您的关注！';
		}
		else {
			$remark = '您提交的对于' . $member['nickname'] . '发表' . $info . '的投诉通过审核！相关内容已删除，感谢您的支持！';
		}

		$msg = array(
			'first'  => array('value' => '投诉消息通知', 'color' => '#4a5077'),
			'remark' => array('value' => $remark, 'color' => '#4a5077')
		);
		m('message')->sendCustomNotice($complain['complainant'], $msg);
	}

	public function restore()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_sns_complain') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (empty($items)) {
			$items = array();
		}

		foreach ($items as $item) {
			pdo_update('ewei_shop_sns_complain', array('deleted' => 0, 'checked' => 0), array('id' => $item['id']));
			plog('sns.posts.complain.restore', '恢复投诉 ID: ' . $id . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function catedel()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,name FROM ' . tablename('ewei_shop_sns_complaincate') . ' WHERE id = ' . $id . ' AND uniacid=' . $_W['uniacid'] . '');

		if (!empty($item)) {
			pdo_delete('ewei_shop_sns_complaincate', array('id' => $id));
			plog('sns.posts.complaincate.delete', '删除投诉分类 ID: ' . $id . ' 标题: ' . $item['name'] . ' ');
		}

		show_json(1);
	}

	public function category()
	{
		global $_W;
		global $_GPC;

		if (!empty($_GPC['catid'])) {
			foreach ($_GPC['catid'] as $key => $value) {
				$data = array('name' => trim($_GPC['catname'][$key]), 'displayorder' => $key, 'status' => intval($_GPC['status'][$key]), 'uniacid' => $_W['uniacid']);

				if (empty($value)) {
					pdo_insert('ewei_shop_sns_complaincate', $data);
					$insert_id = pdo_insertid();
					plog('sns.posts.complaincate.add', '添加投诉分类 ID: ' . $insert_id);
				}
				else {
					pdo_update('ewei_shop_sns_complaincate', $data, array('id' => $value));
					plog('sns.posts.complaincate.edit', '修改投诉分类 ID: ' . $value);
				}
			}

			plog('sns.posts.complaincate.edit', '批量修改投诉分类');
			show_json(1);
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_sns_complaincate') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY displayorder asc'));
		include $this->template();
	}

	/**
	 * 获取会员信息
	 */
	public function getMember($openid = '')
	{
		global $_W;
		$uid = (int) $openid;

		if ($uid == 0) {
			$info = pdo_fetch('select id,avatar,nickname from ' . tablename('ewei_shop_member') . ' where  openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));

			if (empty($info)) {
				$info = pdo_fetch('select id,avatar,nickname from ' . tablename('ewei_shop_member') . ' where  openid_qq=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => str_replace('qq_', '', $openid)));
			}
		}
		else {
			$info = pdo_fetch('select id,avatar,nickname from ' . tablename('ewei_shop_member') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $openid));
		}

		if (!empty($info)) {
			$openid = $info['openid'];

			if (empty($info['uid'])) {
				$followed = m('user')->followed($openid);

				if ($followed) {
					load()->model('mc');
					$uid = mc_openid2uid($openid);

					if (!empty($uid)) {
						$info['uid'] = $uid;
						$upgrade = array('uid' => $uid);

						if (0 < $info['credit1']) {
							mc_credit_update($uid, 'credit1', $info['credit1']);
							$upgrade['credit1'] = 0;
						}

						if (0 < $info['credit2']) {
							mc_credit_update($uid, 'credit2', $info['credit2']);
							$upgrade['credit2'] = 0;
						}

						if (!empty($upgrade)) {
							pdo_update('ewei_shop_member', $upgrade, array('id' => $info['id']));
						}
					}
				}
			}

			$credits = m('member')->getCredits($openid);
			$info['credit1'] = $credits['credit1'];
			$info['credit2'] = $credits['credit2'];
		}

		return $info;
	}
}

?>
