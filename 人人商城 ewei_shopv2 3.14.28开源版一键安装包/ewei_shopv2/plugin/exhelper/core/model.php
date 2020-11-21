<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class ExhelperModel extends PluginModel
{
	public function getInsertData($fields, $memberdata)
	{
		global $_W;
		return '';
	}

	public function tempData($type)
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid and type=:type and merchid=0';
		$params = array(':uniacid' => $_W['uniacid'], ':type' => $type);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND expressname LIKE :expressname';
			$params[':expressname'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$sql = 'SELECT id,expressname,expresscom,isdefault FROM ' . tablename('ewei_shop_exhelper_express') . (' where  1 and ' . $condition . ' ORDER BY isdefault desc, id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_exhelper_express') . (' where 1 and ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		return array('list' => $list, 'total' => $total, 'pager' => $pager, 'type' => $type);
	}

	public function setDefault($id, $type)
	{
		global $_W;
		$item = pdo_fetch('SELECT id,expressname,type FROM ' . tablename('ewei_shop_exhelper_express') . ' WHERE id=:id and type=:type AND uniacid=:uniacid and merchid=0', array(':id' => $id, ':type' => $type, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			pdo_update('ewei_shop_exhelper_express', array('isdefault' => 0), array('type' => $type, 'uniacid' => $_W['uniacid']));
			pdo_update('ewei_shop_exhelper_express', array('isdefault' => 1), array('id' => $id));

			if ($type == 1) {
				plog('exhelper.temp.express.setdefault', '设置默认快递单 ID: ' . $item['id'] . '， 模板名称: ' . $item['expressname'] . ' ');
			}
			else {
				if ($type == 2) {
					plog('exhelper.temp.invoice.setdefault', '设置默认发货单 ID: ' . $item['id'] . '， 模板名称: ' . $item['expressname'] . ' ');
				}
			}
		}
	}

	public function tempDelete($id, $type)
	{
		global $_W;
		$items = pdo_fetchall('SELECT id,expressname FROM ' . tablename('ewei_shop_exhelper_express') . (' WHERE id in( ' . $id . ' ) and type=:type and uniacid=:uniacid and merchid=0'), array(':type' => $type, ':uniacid' => $_W['uniacid']));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_exhelper_express', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));

			if ($type == 1) {
				plog('exhelper.temp.express.delete', '删除 快递助手 快递单模板 ID: ' . $item['id'] . '， 模板名称: ' . $item['expressname'] . ' ');
			}
			else {
				if ($type == 2) {
					plog('exhelper.temp.invoice.delete', '删除 快递助手 发货单模板 ID: ' . $item['id'] . '， 模板名称: ' . $item['expressname'] . ' ');
				}
			}
		}
	}

	public function getTemp()
	{
		global $_W;
		global $_GPC;
		$temp_sender = pdo_fetchall('SELECT id,isdefault,sendername,sendertel FROM ' . tablename('ewei_shop_exhelper_senduser') . ' WHERE uniacid=:uniacid and merchid=0 order by isdefault desc ', array(':uniacid' => $_W['uniacid']));
		$temp_express = pdo_fetchall('SELECT id,type,isdefault,expressname FROM ' . tablename('ewei_shop_exhelper_express') . ' WHERE type=1 and uniacid=:uniacid and merchid=0 order by isdefault desc ', array(':uniacid' => $_W['uniacid']));
		$temp_invoice = pdo_fetchall('SELECT id,type,isdefault,expressname FROM ' . tablename('ewei_shop_exhelper_express') . ' WHERE type=2 and uniacid=:uniacid and merchid=0 order by isdefault desc ', array(':uniacid' => $_W['uniacid']));
		$temp_esheet = pdo_fetchall('SELECT id,isdefault,esheetname FROM ' . tablename('ewei_shop_exhelper_esheet_temp') . ' WHERE uniacid=:uniacid and merchid=0 order by isdefault desc ', array(':uniacid' => $_W['uniacid']));
		return array('temp_sender' => $temp_sender, 'temp_express' => $temp_express, 'temp_invoice' => $temp_invoice, 'temp_esheet' => $temp_esheet);
	}

	/**
     * 调用电子面单接口
     */
	public function submitEOrder($requestData)
	{
		global $_W;
		global $_GPC;
		$requestData = json_encode($requestData, JSON_UNESCAPED_UNICODE);
		$printset = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exhelper_sys') . ' WHERE uniacid=:uniacid and merchid=0 limit 1', array(':uniacid' => $_W['uniacid']));

		if (empty($printset)) {
			return NULL;
		}

		$datas = array('EBusinessID' => $printset['ebusiness'], 'RequestType' => '1007', 'RequestData' => urlencode($requestData), 'DataType' => '2');
		$datas['DataSign'] = $this->encrypt($requestData, $printset['apikey']);
		$result = $this->sendPost('http://api.kdniao.com/api/EOrderService', $datas);
		return $result;
	}

	/**
     *  post提交数据
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据
     * @return url响应返回的html
     */
	public function sendPost($url, $datas)
	{
		load()->func('communication');
		return ihttp_post($url, $datas);
	}

	/**
     * 电商Sign签名生成
     * @param data 内容
     * @param appkey Appkey
     * @return DataSign签名
     */
	public function encrypt($data, $appkey)
	{
		return urlencode(base64_encode(md5($data . $appkey)));
	}
}

?>
