<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'sns/core/page_mobile.php';
class User_EweiShopV2Page extends SnsMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $this->getSet();
		$id = intval($_GPC['id']);

		if (empty($id)) {
			if (!$this->islogin) {
				$url = str_replace('./index.php?', '', mobileUrl('sns/user'));
				$loginurl = mobileUrl('account/login', array('backurl' => urlencode(base64_encode($url))));
				header('location: ' . $loginurl);
				exit();
			}

			$member = $this->model->getMember($_W['openid']);
		}
		else {
			$member = $this->model->getMember($id);
		}

		$member['avatar'] = $this->model->getAvatar($member['avatar']);

		if (empty($member)) {
			show_message('未找到用户!', '', 'error');
		}

		$openid = $member['openid'];
		$level = array('levelname' => empty($set['levelname']) ? '社区粉丝' : $set['levelname'], 'color' => empty($set['levelcolor']) ? '#333' : $set['levelcolor'], 'bg' => empty($set['levelbg']) ? '#eee' : $set['levelbg']);

		if (!empty($member['sns_level'])) {
			$level = pdo_fetch('select * from ' . tablename('ewei_shop_sns_level') . ' where id=:id  limit 1', array(':id' => $member['sns_level']));
		}

		$boardcount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_board_follow') . ' where uniacid=:uniacid and openid=:openid', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
		$postcount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid=0 and deleted = 0 and checked=1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
		$boards = pdo_fetchall('select b.id,b.logo,b.title from ' . tablename('ewei_shop_sns_board_follow') . ' f ' . ' left join ' . tablename('ewei_shop_sns_board') . ' b on f.bid = b.id ' . '   where f.uniacid=:uniacid and f.openid=:openid limit 5', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
		$boards = set_medias($boards, 'logo');
		$follow = pdo_fetchall('select count(*) as num from ' . tablename('ewei_shop_sns_board_follow') . ' f ' . ' left join ' . tablename('ewei_shop_sns_board') . ' b on f.bid = b.id ' . '   where f.uniacid=:uniacid and f.openid=:openid ', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
		$followcount = $follow[0]['num'];
		$posts = pdo_fetchall('select p.id,p.images,p.title ,p.views, b.title as boardtitle,b.logo as boardlogo from ' . tablename('ewei_shop_sns_post') . ' p ' . ' left join ' . tablename('ewei_shop_sns_board') . ' b on p.bid = b.id ' . '   where p.uniacid=:uniacid and p.openid=:openid and pid=0 and deleted=0 and checked=1 order by createtime desc limit 3', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));

		foreach ($posts as &$r) {
			$images = iunserializer($r['images']);
			$thumb = '';
			if (is_array($images) && !empty($images)) {
				$thumb = $images[0];
			}

			if (empty($thumb)) {
				$thumb = $r['boardlogo'];
			}

			$r['thumb'] = tomedia($thumb);
		}

		unset($r);

		if ($openid == $_W['openid']) {
			$replycount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where uniacid=:uniacid and openid=:openid and pid>0 and deleted = 0 and checked=1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			$replys = pdo_fetchall('select p.id, p.content, p.views,
                  parent.id as parentid, 
                  parent.nickname as parentnickname,parent.title as parenttitle ,
                  rparent.nickname as rparentnickname
                  from ' . tablename('ewei_shop_sns_post') . ' p ' . ' left join ' . tablename('ewei_shop_sns_post') . ' parent on p.pid = parent.id ' . ' left join ' . tablename('ewei_shop_sns_post') . ' rparent on p.rpid = rparent.id ' . '   where p.uniacid=:uniacid and p.openid=:openid and p.pid>0 and p.deleted=0 and p.checked=1 order by p.createtime desc limit 3', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));

			foreach ($replys as &$r) {
				$parentnickname = $r['rparentnickname'];

				if (empty($parentnickname)) {
					$parentnickname = $r['parentnickname'];
				}

				$r['parentnickname'] = $parentnickname;
			}

			unset($r);
		}

		$_W['shopshare'] = array('title' => $this->set['share_title'], 'imgUrl' => tomedia($this->set['share_icon']), 'link' => mobileUrl('sns', array(), true), 'desc' => $this->set['share_desc']);
		include $this->template();
	}

	public function boards()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			if (!$this->islogin) {
				$url = str_replace('./index.php?', '', mobileUrl('sns/user/boards'));
				$loginurl = mobileUrl('account/login', array('backurl' => urlencode(base64_encode($url))));
				$this->message('您未登录!', $url, 'error');
			}

			$member = $this->model->getMember($_W['openid']);
		}
		else {
			$member = $this->model->getMember($id);
		}

		if (empty($member)) {
			show_message('未找到用户!', '', 'error');
		}

		$openid = $member['openid'];
		include $this->template();
	}

	public function get_boards()
	{
		global $_W;
		global $_GPC;

		if (empty($id)) {
			if (!$this->islogin) {
				show_json(0, '未登录!');
			}

			$member = $this->model->getMember($_W['openid']);
		}
		else {
			$member = $this->model->getMember($id);
		}

		if (empty($member)) {
			show_message('未找到用户!', '', 'error');
		}

		$openid = $member['openid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and f.uniacid = :uniacid and f.openid=:openid';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
		$sql = 'select b.id,b.logo,b.title from ' . tablename('ewei_shop_sns_board_follow') . ' f ' . ' left join ' . tablename('ewei_shop_sns_board') . ' b on f.bid = b.id ' . ('   where 1 ' . $condition . ' ORDER BY f.createtime asc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select b.id,b.logo,b.title from ' . tablename('ewei_shop_sns_board_follow') . ' f ' . ' left join ' . tablename('ewei_shop_sns_board') . ' b on f.bid = b.id ' . (' where 1 ' . $condition), $params);

		foreach ($list as &$row) {
			$row['postcount'] = $this->model->getPostCount($row['id']);
			$row['followcount'] = $this->model->getFollowCount($row['id']);
			$row['logo'] = tomedia($row['logo']);
		}

		unset($row);
		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	public function posts()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			if (!$this->islogin) {
				$url = str_replace('./index.php?', '', mobileUrl('sns/user/posts'));
				$loginurl = mobileUrl('account/login', array('backurl' => urlencode(base64_encode($url))));
				$this->message('您未登录!', $url, 'error');
			}

			$member = $this->model->getMember($_W['openid']);
		}
		else {
			$member = $this->model->getMember($id);
		}

		if (empty($member)) {
			show_message('未找到用户!', '', 'error');
		}

		$openid = $member['openid'];
		include $this->template();
	}

	public function get_posts()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			if (!$this->islogin) {
				show_json(0, '未登录!');
			}

			$member = $this->model->getMember($_W['openid']);
		}
		else {
			$member = $this->model->getMember($id);
		}

		$openid = $member['openid'];
		$shop = m('common')->getSysset('shop');
		$uniacid = $_W['uniacid'];
		$bid = intval($_GPC['bid']);
		$isbest = trim($_GPC['isbest']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and `uniacid` = :uniacid and `pid`=0 and `deleted`=0 and openid=:openid';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);

		if (!empty($bid)) {
			$condition .= ' and `bid`=' . $bid;
		}

		if ($isbest == '1') {
			$condition .= ' and `isboardbest`=1';
		}

		$isManager = $this->model->isManager($bid);

		if (!$isManager) {
			$condition .= ' and `checked`=1';
		}

		$sql = 'select id,title,createtime,content,images , nickname,avatar,isbest,isboardbest,checked from ' . tablename('ewei_shop_sns_post') . ('  where 1 ' . $condition . ' ORDER BY createtime desc,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . (' where 1 ' . $condition), $params);

		foreach ($list as &$row) {
			$row['avatar'] = $this->model->getAvatar($row['avatar']);
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			$row['goodcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_like') . ' where pid=:pid limit 1', array(':pid' => $row['id']));
			$row['postcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' where pid=:pid limit 1', array(':pid' => $row['id']));
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

	public function replys()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			if (!$this->islogin) {
				$url = str_replace('./index.php?', '', mobileUrl('sns/user/replys'));
				$loginurl = mobileUrl('account/login', array('backurl' => urlencode(base64_encode($url))));
				$this->message('您未登录!', $url, 'error');
			}

			$member = $this->model->getMember($_W['openid']);
		}
		else {
			$member = $this->model->getMember($id);
		}

		if (empty($member)) {
			show_message('未找到用户!', '', 'error');
		}

		$openid = $member['openid'];
		include $this->template();
	}

	public function get_replys()
	{
		global $_W;
		global $_GPC;

		if (!$this->islogin) {
			show_json(0, '未登录!');
		}

		$openid = $_W['openid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' p.uniacid=:uniacid and p.openid=:openid and p.pid>0 and p.deleted=0 and p.checked=1';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
		$sql = 'select p.id, p.content, p.views,
                  parent.id as parentid, parent.nickname as parentnickname,parent.title as parenttitle ,parent.images as parentimages,
                  rparent.nickname as rparentnickname,
                  b.title as boardtitle, b.logo as boardlogo,b.id as boardid
                  from ' . tablename('ewei_shop_sns_post') . ' p ' . ' left join ' . tablename('ewei_shop_sns_post') . ' parent on p.pid = parent.id ' . ' left join ' . tablename('ewei_shop_sns_post') . ' rparent on p.rpid = rparent.id ' . ' left join ' . tablename('ewei_shop_sns_board') . ' b on b.id=p.bid ' . ('   where 1 and ' . $condition . ' order by p.createtime desc limit ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_sns_post') . ' p ' . ' left join ' . tablename('ewei_shop_sns_post') . ' parent on p.pid = parent.id ' . ' left join ' . tablename('ewei_shop_sns_post') . ' rparent on p.rpid = rparent.id ' . (' where 1 and ' . $condition), $params);

		foreach ($list as &$r) {
			$parentnickname = $r['rparentnickname'];

			if (empty($parentnickname)) {
				$parentnickname = $r['parentnickname'];
			}

			$r['parentnickname'] = $parentnickname;
			$r['boardlogo'] = tomedia($r['boardlogo']);
			$images = iunserializer($r['parentimages']);
			$thumb = '';
			if (is_array($images) && !empty($images)) {
				$thumb = $images[0];
			}

			if (empty($thumb)) {
				$thumb = $r['boardlogo'];
			}

			$r['thumb'] = tomedia($thumb);
		}

		unset($r);
		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	public function delete_reply()
	{
		global $_W;
		global $_GPC;

		if (!$this->islogin) {
			show_json(0, '未登录!');
		}

		$id = intval($_GPC['id']);

		if (empty($id)) {
			show_json(0, '参数错误!');
		}

		$post = $this->model->getPost($id);

		if (empty($post)) {
			show_json(0, '数据未找到!');
		}

		if ($post['openid'] !== $_W['openid']) {
			show_json(0, '无权删除TA人数据!');
		}

		pdo_update('ewei_shop_sns_post', array('deleted' => 1, 'deletedtime' => time()), array('id' => $id));
		show_json(1);
	}

	public function submit_sign()
	{
		global $_W;
		global $_GPC;

		if (!$this->islogin) {
			show_json(0, '未登录!');
		}

		$sign = trim($_GPC['sign']);
		pdo_update('ewei_shop_sns_member', array('sign' => $sign), array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));
		show_json(1);
	}
}

?>
