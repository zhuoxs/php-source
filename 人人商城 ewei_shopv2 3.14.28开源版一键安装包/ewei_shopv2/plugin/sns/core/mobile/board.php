<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'sns/core/page_mobile.php';
class Board_EweiShopV2Page extends SnsMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$this->message('参数错误', mobileUrl('sns'));
		}

		$board = $this->model->getBoard($id);

		if (empty($id)) {
			$this->message('未找到版块!', mobileUrl('sns'));
		}

		$set = $this->set;

		if ($set['imagesnum'] == 0) {
			$set['imagesnum'] = 5;
		}

		$member = $this->model->getMember($_W['openid']);
		$isManager = $this->model->isManager($board['id']);
		$isSuperManager = $this->model->isSuperManager();
		if (!$isManager && !$isSuperManager) {
			$check = $this->model->check($member, $board);

			if (is_error($check)) {
				show_message($check['message'], mobileUrl('sns'), 'error');
			}
		}

		$postcount = $this->model->getPostCount($board['id']);
		$followcount = $this->model->getFollowCount($board['id']);
		$isfollow = $this->model->isFollow($board['id']);
		$isafollow = m('user')->followed($_W['openid']);
		$followtip = empty($this->set['followtip']) ? '想要和社友互动吗？需要您关注我们的公众号，点击【确定】关注后再来吧~' : $this->set['followtip'];
		$shopset = m('common')->getSysset('share');
		$followurl = empty($this->set['followurl']) ? $shopset['followurl'] : $this->set['followurl'];
		$tops = $this->model->getTops($board['id']);
		$catelist = pdo_fetchall('SELECT id,name FROM ' . tablename('ewei_shop_sns_complaincate') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY displayorder asc'));
		$url = str_replace('./index.php?', '', mobileUrl('sns/board', array('id' => $board['id'])));
		$loginurl = mobileUrl('account/login', array('backurl' => urlencode(base64_encode($url))));
		$_W['shopshare'] = array('title' => !empty($board['share_title']) ? $board['share_title'] : $board['title'], 'imgUrl' => !empty($board['share_icon']) ? tomedia($board['share_icon']) : tomedia($board['logo']), 'link' => mobileUrl('sns/board', array('id' => $board['id']), true), 'desc' => !empty($board['share_desc']) ? $board['share_desc'] : $board['desc']);
		$canpost = true;
		if (!$isManager && !$isSuperManager) {
			$check = $this->model->check($member, $board, true);
			$canpost = !is_error($check);
		}

		include $this->template();
	}

	public function best()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$this->message('参数错误', mobileUrl('sns'));
		}

		$board = $this->model->getBoard($id);

		if (empty($board)) {
			$this->message('未找到版块!', mobileUrl('sns'));
		}

		$catelist = pdo_fetchall('SELECT id,name FROM ' . tablename('ewei_shop_sns_complaincate') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY displayorder asc'));
		$member = m('member')->getMember($_W['openid']);
		$isManager = $this->model->isManager($board['id']);
		$isSuperManager = $this->model->isSuperManager();
		if (!$isManager && $isSuperManager) {
			$check = $this->model->check($member, $board);

			if (is_error($check)) {
				$this->message($check['message'], mobileUrl('sns'));
			}
		}

		$_W['shopshare'] = array('title' => !empty($board['share_title']) ? $board['share_title'] : $board['title'], 'imgUrl' => !empty($board['share_icon']) ? tomedia($board['share_icon']) : tomedia($board['logo']), 'link' => mobileUrl('sns/board/best', array('id' => $id), true), 'desc' => !empty($board['share_desc']) ? $board['share_desc'] : $board['desc']);
		include $this->template();
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$shop = m('common')->getSysset('shop');
		$uniacid = $_W['uniacid'];
		$bid = intval($_GPC['bid']);
		$isbest = trim($_GPC['isbest']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and `uniacid` = :uniacid and `pid`=0 and `deleted`=0';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($bid)) {
			$condition .= ' and `bid`=' . $bid;
		}

		if ($isbest == '1') {
			$condition .= ' and `isboardbest`=1';
		}

		$isSuperManager = $this->model->isSuperManager();
		$isManager = $this->model->isManager($bid);
		if (!$isManager && !$isSuperManager) {
			$condition .= ' and `checked`=1';
		}

		$sql = 'select id,title,createtime,content,images , nickname,avatar,isbest,isboardbest,checked from ' . tablename('ewei_shop_sns_post') . ('  where 1 ' . $condition . ' ORDER BY createtime desc,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . (' where 1 ' . $condition), $params);

		foreach ($list as &$row) {
			$row['avatar'] = $this->model->getAvatar($row['avatar']);
			$row['createtime'] = $this->model->timeBefore($row['createtime']);
			$row['goodcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_like') . ' where pid=:pid limit 1', array(':pid' => $row['id']));
			$row['postcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where pid=:pid and deleted = 0 limit 1', array(':pid' => $row['id']));
			$row['content'] = htmlspecialchars_decode($row['content']);
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
		}

		unset($row);
		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	public function relate()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$this->message('参数错误', mobileUrl('sns'));
		}

		$board = $this->model->getBoard($id);

		if (empty($id)) {
			$this->message('未找到版块!', mobileUrl('sns'));
		}

		$member = m('member')->getMember($_W['openid']);
		$isManager = $this->model->isManager($board['id']);
		$isSuperManager = $this->model->isSuperManager();
		if (!$isManager && $isSuperManager) {
			$check = $this->model->check($member, $board);

			if (is_error($check)) {
				$this->message($check['message'], mobileUrl('sns'));
			}
		}

		$condition = ' and `uniacid` = :uniacid and `cid`=:cid and `status`=1';
		$params = array(':uniacid' => $_W['uniacid'], ':cid' => $board['cid']);
		$sql = 'select id,title,logo,`desc`  from ' . tablename('ewei_shop_sns_board') . (' where 1 ' . $condition . ' order by displayorder desc');
		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$row['logo'] = tomedia($row['logo']);
			$row['postcount'] = $this->model->getPostCount($row['id']);
			$row['followcount'] = $this->model->getFollowCount($row['id']);
		}

		unset($row);
		$_W['shopshare'] = array('title' => !empty($board['share_title']) ? $board['share_title'] : $board['title'], 'imgUrl' => !empty($board['share_icon']) ? tomedia($board['share_icon']) : tomedia($board['logo']), 'link' => mobileUrl('sns/board/relate', array('id' => $id), true), 'desc' => !empty($board['share_desc']) ? $board['share_desc'] : $board['desc']);
		include $this->template();
	}

	public function lists()
	{
		global $_W;
		global $_GPC;
		$category = $this->model->getCategory();
		include $this->template();
	}

	public function get_boardlist()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and sb.uniacid=:uniacid and sb.status=1';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['cid'] == 'rec') {
			$condition .= ' and sb.isrecommand=1';
		}
		else {
			if (!empty($_GPC['cid'])) {
				$condition .= ' and sb.cid=' . intval($_GPC['cid']);
			}
		}

		if (!empty($_GPC['keywords'])) {
			$_GPC['keywords'] = trim($_GPC['keywords']);
			$condition .= ' and sb.title  like :keywords';
			$params[':keywords'] = '%' . $_GPC['keywords'] . '%';
		}

		$list = pdo_fetchall('SELECT sb.id,sb.title,sb.logo FROM ' . tablename('ewei_shop_sns_board') . ' as sb
                left join ' . tablename('ewei_shop_sns_category') . (' as sc on sc.id = sb.cid
                WHERE 1 ' . $condition . ' and sc.enabled = 1  ORDER BY sb.displayorder DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($list as &$row) {
			$row['postcount'] = $this->model->getPostCount($row['id']);
			$row['followcount'] = $this->model->getFollowCount($row['id']);
			$row['logo'] = tomedia($row['logo']);
		}

		unset($row);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_sns_board') . (' as sb WHERE 1 ' . $condition), $params);
		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	public function follow()
	{
		if (!$this->islogin) {
			show_json(0, '未登录');
		}

		global $_W;
		global $_GPC;
		$bid = intval($_GPC['bid']);
		$pid = intval($_GPC['pid']);

		if (empty($bid)) {
			show_json(0, '参数错误', mobileUrl('sns'));
		}

		$board = $this->model->getBoard($bid);

		if (empty($board)) {
			show_json(0, '未找到版块!', mobileUrl('sns'));
		}

		$follow = pdo_fetch('select id from ' . tablename('ewei_shop_sns_board_follow') . ' where bid=:bid and openid=:openid limit 1', array(':bid' => $bid, ':openid' => $_W['openid']));

		if (!empty($follow)) {
			pdo_delete('ewei_shop_sns_board_follow', array('id' => $follow['id']));
			show_json(1, array('isfollow' => false));
		}
		else {
			$follow = array('uniacid' => $_W['uniacid'], 'bid' => $bid, 'openid' => $_W['openid'], 'createtime' => time());
			pdo_insert('ewei_shop_sns_board_follow', $follow);
			show_json(1, array('isfollow' => true));
		}
	}
}

?>
