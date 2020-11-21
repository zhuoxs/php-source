<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $uniacid);
		$goodscodes = array();

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND title LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$goodscodes = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_goodscode_good') . '
                    WHERE 1 ' . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_goodscode_good') . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination($total, $pindex, $psize);
		include $this->template();
	}

	public function download()
	{
		header('Content-Type: text/html;charset=utf-8');
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$uniacid = $_W['uniacid'];

		if (empty($id)) {
			$id = trim($_GPC['ids']);
		}

		$items = pdo_fetchall('SELECT id,title,qrcode FROM ' . tablename('ewei_shop_goodscode_good') . (' WHERE id in(' . $id . ') AND uniacid=') . $_W['uniacid']);
		$res = array();

		foreach ($items as $key => $value) {
			$res[$key]['ima_path'] = $value['qrcode'];
			$res[$key]['title'] = $value['title'];
		}

		$filename = $_SERVER['DOCUMENT_ROOT'] . '/addons/ewei_shopv2/data/qrcode/' . $uniacid . '/Dwonload.zip';
		$zip = new ZipArchive();
		$zip->open($filename, $zip::CREATE);

		foreach ($res as $value) {
			$img = str_replace('/', '', strrchr($value['ima_path'], '/'));
			$fileData = $_SERVER['DOCUMENT_ROOT'] . '/addons/ewei_shopv2/data/qrcode/' . $uniacid;
			copy($img, $value['title'] . '.jpg');
			$filesss = iconv('UTF-8', 'GBK//IGNORE', $value['title'] . '.jpg');
			$zip->addFile($fileData . '/' . $img, $filesss);
		}

		$zip->close();
		ob_end_clean();
		header('Content-Type: application/force-download');
		header('Content-Transfer-Encoding: binary');
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename=' . time() . '.zip');
		header('Content-Length: ' . filesize($filename));
		error_reporting(0);
		readfile($filename);
		flush();
		ob_flush();
		@unlink($filename);
		include $this->template();
	}

	public function http_get_data($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL, $url);
		ob_start();
		curl_exec($ch);
		$return_content = ob_get_contents();
		ob_end_clean();
		$return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		return $return_content;
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
		$uniacid = intval($_W['uniacid']);
		$id = intval($_GPC['id']);

		if ($_W['ispost']) {
			$data = array('uniacid' => $uniacid, 'displayorder' => intval($_GPC['displayorder']), 'status' => intval($_GPC['status']), 'goodsid' => intval($_GPC['goodsid']));

			if (empty($data['goodsid'])) {
				show_json(0, '商品不能为空！');
			}

			$goods = pdo_fetch('select id,thumb,title from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and id = ' . $data['goodsid'] . ' ');

			if (empty($goods)) {
				show_json(0, '商品不存在！');
			}

			$codegoods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goodscode_good') . ' WHERE uniacid = ' . $uniacid . ' and goodsid = ' . $data['goodsid'] . ' ');
			if (!empty($codegoods) && empty($id)) {
				show_json(0, '该商品已添加，不能重复添加！');
			}

			$data['thumb'] = $goods['thumb'];
			$data['title'] = $goods['title'];

			if (!empty($id)) {
				pdo_update('ewei_shop_goodscode_good', $data, array('id' => $id));
				plog('sale.goodscode.edit', '编辑二维码商品 ID: ' . $id . ' <br/>商品名称: ' . $data['title']);
			}
			else {
				pdo_insert('ewei_shop_goodscode_good', $data);
				$id = pdo_insertid();
				plog('sale.goodscode.add', '添加二维码商品 ID: ' . $id . '  <br/>商品名称: ' . $data['title']);
			}

			$url = mobileUrl('goods/code', array('id' => $id, 'goodsid' => $data['goodsid']), true);
			$qrcode = m('qrcode')->createQrcode($url);
			pdo_update('ewei_shop_goodscode_good', array('qrcode' => $qrcode), array('id' => $id));
			show_json(1, array('url' => webUrl('sale/goodscode/edit', array('id' => $id))));
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goodscode_good') . ' WHERE uniacid = ' . $uniacid . ' and id = ' . $id . ' ');

		if (!empty($item)) {
			$goods = pdo_fetch('select id,thumb,title from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and id = ' . $item['goodsid'] . ' ');
		}

		if (!empty($item['thumb'])) {
			$item = set_medias($item, array('thumb'));
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goodscode_good') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_goodscode_good', array('deleted' => 1, 'status' => 0), array('id' => $item['id']));
			plog('sale.goodscode.delete', '删除二维码商品 ID: ' . $item['id'] . ' 商品名称: ' . $item['title'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goodscode_good') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_goodscode_good', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('sale.goodscode.edit', '修改二维码商品状态<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '开启' : '关闭');
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goodscode_good') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_goodscode_good', array('id' => $item['id']));
			plog('sale.goodscode.edit', '彻底删除二维码商品<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title']);
		}

		show_json(1, array('url' => referer()));
	}

	public function change()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			show_json(0, array('message' => '参数错误'));
		}

		$type = trim($_GPC['typechange']);
		$value = trim($_GPC['value']);

		if (!in_array($type, array('title', 'displayorder'))) {
			show_json(0, array('message' => '参数错误'));
		}

		$goodscode = pdo_fetch('select id from ' . tablename('ewei_shop_goodscode_good') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (empty($goodscode)) {
			show_json(0, array('message' => '参数错误'));
		}

		pdo_update('ewei_shop_goodscode_good', array($type => $value), array('id' => $id));
		show_json(1);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$kwd = trim($_GPC['keyword']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;
		$params = array();
		$params[':uniacid'] = $uniacid;
		$condition = ' and status=1 and deleted=0 and uniacid=:uniacid';

		if (!empty($kwd)) {
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title,thumb,content FROM ' . tablename('ewei_shop_goods') . ('
            WHERE 1 ' . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_goods') . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination($total, $pindex, $psize, '', array('before' => 5, 'after' => 4, 'ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
		$ds = set_medias($ds, array('thumb'));
		include $this->template();
	}
}

?>
