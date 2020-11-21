<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_qa_category') . ' where isrecommand=1 and enabled=1 and uniacid=:uniacid order by displayorder desc limit 8 ', array(':uniacid' => $_W['uniacid']));
		$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('ewei_shop_qa_adv') . ' where uniacid=:uniacid and enabled=1 order by displayorder desc', array(':uniacid' => $_W['uniacid']));
		$advs = set_medias($advs, 'thumb');
		$set = $this->model->getSet();

		if (!empty($set['share'])) {
			$_W['shopshare'] = array('title' => $set['enter_title'], 'imgUrl' => tomedia($set['enter_img']), 'desc' => $set['enter_desc'], 'link' => mobileUrl('qa'));

			if (p('commission')) {
				$commset = p('commission')->getSet();

				if (!empty($commset['level'])) {
					$member = m('member')->getMember($_W['openid']);
					if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
						$_W['shopshare']['link'] = mobileUrl('qa', array('mid' => $member['id']), true);
					}
					else {
						if (!empty($_GPC['mid'])) {
							$_W['shopshare']['link'] = mobileUrl('qa', array('mid' => $_GPC['mid']), true);
						}
					}
				}
			}
		}

		include $this->template();
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$cate = intval($_GPC['cate']);
		$keyword = trim($_GPC['keyword']);
		$isrecommand = intval($_GPC['isrecommand']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' q.uniacid=:uniacid and q.status=1 and c.enabled=1 ';

		if (!empty($cate)) {
			$condition .= ' and q.cate=' . $cate . ' ';
		}

		if (!empty($isrecommand)) {
			$condition .= ' and q.isrecommand=1 ';
		}

		if (!empty($keyword)) {
			$condition .= ' AND ((q.title like \'%' . $keyword . '%\') or (q.keywords like \'%' . $keyword . '%\')) ';
		}

		$params = array(':uniacid' => $_W['uniacid']);
		$sql = 'SELECT q.*, c.name as catename FROM ' . tablename('ewei_shop_qa_question') . ' q left join' . tablename('ewei_shop_qa_category') . (' `c` on c.id=q.cate and c.uniacid=q.uniacid where  1 and ' . $condition . ' ORDER BY q.displayorder DESC,q.id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_qa_question') . ' q left join' . tablename('ewei_shop_qa_category') . (' c on c.id=q.cate and c.uniacid=q.uniacid where  1 and ' . $condition . ' '), $params);

		if (!empty($total)) {
			foreach ($list as &$item) {
				$item['content'] = iunserializer($item['content']);
				$item['content'] = htmlspecialchars_decode($item['content']);
				$item['content'] = m('ui')->lazy($item['content']);
			}

			unset($item);
		}

		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_qa_question') . ' where id=:id and status=1 and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

			if (empty($item)) {
				$this->message('问题不存在!');
			}

			$item['content'] = iunserializer($item['content']);
			$item['content'] = htmlspecialchars_decode($item['content']);
			$item['content'] = m('ui')->lazy($item['content']);
		}

		$set = $this->model->getSet();

		if (!empty($set['share'])) {
			$_W['shopshare'] = array('title' => $item['title'], 'imgUrl' => tomedia($_W['shopset']['shop']['logo']), 'desc' => strip_tags($item['content']), 'link' => mobileUrl('qa/detail', array('id' => $item['id']), true));

			if (p('commission')) {
				$commset = p('commission')->getSet();

				if (!empty($commset['level'])) {
					$member = m('member')->getMember($_W['openid']);
					if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
						$_W['shopshare']['link'] = mobileUrl('qa/detail', array('id' => $item['id'], 'mid' => $member['id']), true);
					}
					else {
						if (!empty($_GPC['mid'])) {
							$_W['shopshare']['link'] = mobileUrl('qa/detail', array('id' => $item['id'], 'mid' => $_GPC['mid']), true);
						}
					}
				}
			}
		}

		include $this->template();
	}

	public function question()
	{
		global $_W;
		global $_GPC;
		$set = $this->model->getSet();
		$cate = intval($_GPC['cate']);

		if (!empty($cate)) {
			$category = pdo_fetch('select * from ' . tablename('ewei_shop_qa_category') . ' where id=:id and enabled=1 and uniacid=:uniacid limit 1 ', array(':id' => $cate, ':uniacid' => $_W['uniacid']));

			if (empty($category)) {
				$this->message('该分类不存在!');
			}
		}

		if (!empty($set['share'])) {
			$_W['shopshare'] = array('title' => $category['name'], 'imgUrl' => tomedia($category['thumb']), 'desc' => m('plugin')->getName('qa'), 'link' => mobileUrl('qa/question', array('cate' => $cate)));

			if (p('commission')) {
				$commset = p('commission')->getSet();

				if (!empty($commset['level'])) {
					$member = m('member')->getMember($_W['openid']);
					if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
						$_W['shopshare']['link'] = mobileUrl('qa/question', array('cate' => $cate, 'mid' => $member['id']), true);
					}
					else {
						if (!empty($_GPC['mid'])) {
							$_W['shopshare']['link'] = mobileUrl('qa/question', array('cate' => $cate, 'mid' => $_GPC['mid']), true);
						}
					}
				}
			}
		}

		include $this->template('qa/list');
	}

	public function category()
	{
		global $_W;
		global $_GPC;
		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_qa_category') . ' where enabled=1 and uniacid=:uniacid order by displayorder desc ', array(':uniacid' => $_W['uniacid']));

		if (empty($category)) {
			$this->message('没有任何分类!');
		}

		$set = $this->model->getSet();

		if (!empty($set['share'])) {
			$_W['shopshare'] = array('title' => '全部分类', 'imgUrl' => tomedia($_W['shopset']['shop']['logo']), 'desc' => m('plugin')->getName('qa'), 'link' => mobileUrl('qa/category'));

			if (p('commission')) {
				$commset = p('commission')->getSet();

				if (!empty($commset['level'])) {
					$member = m('member')->getMember($_W['openid']);
					if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
						$_W['shopshare']['link'] = mobileUrl('qa/category', array('mid' => $member['id']), true);
					}
					else {
						if (!empty($_GPC['mid'])) {
							$_W['shopshare']['link'] = mobileUrl('qa/category', array('mid' => $_GPC['mid']), true);
						}
					}
				}
			}
		}

		include $this->template();
	}
}

?>
