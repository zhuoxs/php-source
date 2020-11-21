<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Comment_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		$this->getList(0);
	}

	public function check()
	{
		$this->getList(1);
	}

	protected function getList($checked = 0)
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and c.uniacid=:uniacid and c.deleted=0 and g.merchid=' . $_W['merchid'];
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ( c.logsn like :keyword or g.title like :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND c.time >= :starttime AND c.time <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		if ($_GPC['virtual'] != '') {
			if (empty($_GPC['virtual'])) {
				$condition .= ' AND c.virtual=1';
			}
			else {
				$condition .= ' AND c.virtual=0';
			}
		}

		if (!empty($_GPC['replystatus'])) {
			$replystatus = intval($_GPC['replystatus']);

			if ($replystatus == 1) {
				$condition .= ' AND c.checked=0 AND c.virtual=0 ';
			}
			else if ($replystatus == 2) {
				$condition .= ' AND (c.append_content<>\'\' OR c.append_images<>\'\') AND c.append_checked=0 AND  c.virtual=0 ';
			}
			else if ($replystatus == 3) {
				$condition .= ' AND (c.reply_content=\'\' OR c.reply_images=\'\') ';
			}
			else {
				if ($replystatus == 4) {
					$condition .= ' AND (c.append_reply_content=\'\' OR c.append_reply_images=\'\') ';
				}
			}
		}

		if (!empty($checked)) {
			$condition .= ' AND (c.checked=0 OR ( (c.append_content<>\'\' OR c.append_images<>\'\') AND c.append_checked=0 )) AND c.virtual=0 ';
		}

		$list = pdo_fetchall('SELECT  c.*,g.title,g.thumb FROM ' . tablename('ewei_shop_creditshop_comment') . ' c  ' . ' left join ' . tablename('ewei_shop_creditshop_goods') . ' g on c.goodsid = g.id  ' . (' WHERE 1 ' . $condition . ' ORDER BY `time` desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_creditshop_comment') . ' c  ' . ' left join ' . tablename('ewei_shop_creditshop_goods') . ' g on c.goodsid = g.id  ' . (' WHERE 1 ' . $condition . ' '), $params);
		$pager = pagination($total, $pindex, $psize);
		include $this->template('creditshop/comment/index');
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_creditshop_comment') . ' WHERE id=:id and uniacid=:uniacid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$item['images'] = set_medias(iunserializer($item['images']));
			$item['reply_images'] = set_medias(iunserializer($item['reply_images']));
			$item['append_images'] = set_medias(iunserializer($item['append_images']));
			$item['append_reply_images'] = set_medias(iunserializer($item['append_reply_images']));

			if (!empty($item['goodsid'])) {
				$goods = pdo_fetch('select id,thumb,title from ' . tablename('ewei_shop_creditshop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $item['goodsid'], ':uniacid' => $_W['uniacid']));
			}
		}

		if ($_W['ispost']) {
			if (!empty($item) && empty($item['virtual'])) {
				$arr = array('reply_content' => trim($_GPC['reply_content']), 'append_reply_content' => trim($_GPC['append_reply_content']), 'checked' => intval($_GPC['checked']), 'append_checked' => intval($_GPC['append_checked']), 'reply_images' => is_array($_GPC['reply_images']) ? iserializer(m('common')->array_images($_GPC['reply_images'])) : iserializer(array()), 'append_reply_images' => is_array($_GPC['append_reply_images']) ? iserializer(m('common')->array_images($_GPC['append_reply_images'])) : iserializer(array()), 'reply_time' => time(), 'append_reply_time' => !empty($_GPC['append_reply_content']) || !empty($_GPC['append_reply_images']) ? time() : 0);
				pdo_update('ewei_shop_creditshop_comment', $arr, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			}
			else {
				$arr = array('goodsid' => intval($_GPC['goodsid']), 'openid' => trim($_GPC['openid']), 'nickname' => trim($_GPC['nickname']), 'headimg' => trim($_GPC['headimg']), 'level' => intval($_GPC['level']), 'content' => trim($_GPC['content']), 'images' => is_array($_GPC['images']) ? iserializer(m('common')->array_images($_GPC['images'])) : iserializer(array()), 'time' => !empty($_GPC['time']) ? strtotime($_GPC['time']) : time(), 'reply_content' => trim($_GPC['reply_content']), 'reply_images' => is_array($_GPC['reply_images']) ? iserializer(m('common')->array_images($_GPC['reply_images'])) : iserializer(array()), 'reply_time' => !empty($_GPC['reply_time']) ? strtotime($_GPC['reply_time']) : time(), 'append_content' => trim($_GPC['append_content']), 'append_images' => is_array($_GPC['append_images']) ? iserializer(m('common')->array_images($_GPC['append_images'])) : iserializer(array()), 'append_time' => !empty($_GPC['append_time']) ? strtotime($_GPC['append_time']) : time(), 'append_reply_content' => trim($_GPC['append_reply_content']), 'append_reply_images' => is_array($_GPC['append_reply_images']) ? iserializer(m('common')->array_images($_GPC['append_reply_images'])) : iserializer(array()), 'append_reply_time' => !empty($_GPC['append_reply_time']) ? strtotime($_GPC['append_reply_time']) : time());

				if (!empty($item)) {
					pdo_update('ewei_shop_creditshop_comment', $arr, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				}
				else {
					if (empty($arr['goodsid'])) {
						show_json(0, '请选择评价的商品！');
					}

					if (empty($arr['content']) || empty($_GPC['images'])) {
						show_json(0, '请设置首次评价的内容！');
					}

					$arr['uniacid'] = $_W['uniacid'];
					$arr['virtual'] = 1;
					pdo_insert('ewei_shop_creditshop_comment', $arr);
					$id = pdo_insertid();
				}
			}

			show_json(1, array('url' => webUrl('creditshop/comment/edit', array('id' => $id))));
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

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_creditshop_comment') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_creditshop_comment', array('deleted' => 1), array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
			$goods = pdo_fetch('select id,thumb,title from ' . tablename('ewei_shop_creditshop_goods') . ' where id=:id and merchid = ' . $_W['merchid'] . ' and uniacid=:uniacid limit 1', array(':id' => $item['goodsid'], ':uniacid' => $_W['uniacid']));
			plog('shop.comment.delete', '删除评价 ID: ' . $id . ' 商品ID: ' . $goods['id'] . ' 商品标题: ' . $goods['title']);
		}

		show_json(1, array('url' => referer()));
	}
}

?>
