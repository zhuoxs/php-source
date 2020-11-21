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
		$pindex = max(1, intval($_GPC['page']));
		$sort = trim($_GPC['sort']);
		$psize = 50;
		$condition = ' and gp.state = 1 ';
		$sortcondition = ' gp.displayorder desc ';
		$params = array();

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and p.name like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		if (empty($sort) || $sort == 'time') {
			$sortcondition = ' gp.createtime desc ';
		}
		else {
			if ($sort == 'sale') {
				$sortcondition = ' gp.sales desc ';
			}
		}

		$list = pdo_fetchall('SELECT gp.*,p.identity,p.name as pname,p.category,p.version,p.author,p.status FROM ' . tablename('ewei_shop_system_plugingrant_plugin') . ' as gp
                left join ' . tablename('ewei_shop_plugin') . (' as p on p.id = gp.pluginid
                WHERE 1 ' . $condition . ' ORDER BY ' . $sortcondition . ' LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($list as $key => $value) {
			$list[$key]['data'] = unserialize($value['data']);
		}

		$package = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_plugingrant_package') . ' 
                WHERE state = 1 and rec = 1 ORDER BY id desc ');

		foreach ($package as $key => $value) {
			$pluginid = explode(',', $value['pluginid']);

			foreach ($pluginid as $k => $v) {
				$package[$key]['package'][$k] = pdo_fetch('select `name`,thumb,iscom from ' . tablename('ewei_shop_plugin') . ' where id = ' . $v . ' ');
			}

			$package[$key]['data'] = unserialize($value['data']);
		}

		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_system_plugingrant_plugin') . ' as gp
                left join ' . tablename('ewei_shop_plugin') . (' as p on p.id = gp.pluginid
                WHERE 1 ' . $condition . ' '), $params);
		$pager = pagination($total, $pindex, $psize);
		$adv = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_plugingrant_adv') . ' WHERE enabled = 1  ORDER BY displayorder DESC ');
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = trim($_GPC['type']);

		if ($type == 'package') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_plugingrant_package') . ' WHERE id =:id limit 1', array(':id' => $id));
			$item['name'] = $item['text'];
			$item['data'] = unserialize($item['data']);
		}
		else {
			if ($type == 'plugin') {
				$item = pdo_fetch('SELECT gp.*,p.identity,p.name as pname,p.category,p.version,p.author,p.status,p.thumb,p.desc,p.isv2 FROM ' . tablename('ewei_shop_system_plugingrant_plugin') . ' gp
                left join ' . tablename('ewei_shop_plugin') . ' as p on p.id = gp.pluginid 
                WHERE gp.id =:id limit 1', array(':id' => $id));

				if (!empty($item)) {
					$package = pdo_fetchall('select * from ' . tablename('ewei_shop_system_plugingrant_package') . ' 
                    where find_in_set(\'' . $item['pluginid'] . '\',pluginid) and state = 1 ');

					foreach ($package as $key => $value) {
						$packplugin = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_plugin') . '  WHERE id in (' . $value['pluginid'] . ') ');
						$package[$key]['plugin'] = $packplugin;
						$package[$key]['data'] = unserialize($value['data']);
					}
				}

				$plugingrant_log = pdo_fetchall('select *  from ' . tablename('ewei_shop_system_plugingrant_log') . ' where uniacid=:uniacid and  pluginid=:pluginid ', array(':uniacid' => $_W['uniacid'], ':pluginid' => $item['pluginid']));

				if (!empty($plugingrant_log)) {
					$is_repeat = true;
				}

				$item['data'] = unserialize($item['data']);

				if (!empty($item)) {
					$plugin = array();
					$plugin = pdo_fetchall('select * from ' . tablename('ewei_shop_plugin') . ' where id in (' . trim($item['pluginid']) . ') ');

					foreach ($plugin as $key => &$value) {
						$value['title'] = $value['name'];
					}

					unset($value);
				}
			}
		}

		$setting = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_setting') . ' where 1 = 1 limit 1 ');
		$contacts = unserialize($setting['contact']);
		include $this->template();
	}

	public function create()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$cate = trim($_GPC['cate']);
		$setting = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_setting') . ' where 1 = 1 limit 1 ');
		$title = '';

		if ($cate == 'package') {
			$package = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_package') . ' 
                    where id = ' . $id . ' and state = 1 ');
			$packplugin = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_plugin') . '  WHERE id in (' . $package['pluginid'] . ') ');
			$package['plugin'] = $packplugin;

			foreach ($packplugin as $key => $value) {
				$title .= $value['name'] . ';';
			}

			$package['data'] = unserialize($package['data']);
		}
		else {
			if ($cate = 'plugin') {
				$item = pdo_fetch('SELECT gp.*,p.identity,p.name as pname,p.category,p.version,p.author,p.status,p.thumb,p.desc FROM ' . tablename('ewei_shop_system_plugingrant_plugin') . ' gp
                left join ' . tablename('ewei_shop_plugin') . ' as p on p.id = gp.pluginid 
                WHERE gp.id =:id and state = 1 limit 1', array(':id' => $id));
				$item['data'] = unserialize($item['data']);
				$title = !empty($item['name']) ? $item['name'] : $item['pname'];
			}
		}

		include $this->template();
	}

	public function payon()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$cate = trim($_GPC['cate']);
		$paytype = trim($_GPC['paytype']);
		$price = floatval($_GPC['price']);
		$month = floatval($_GPC['month']);
		$setting = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_setting') . ' where 1 = 1 limit 1 ');
		$title = '';
		$logdata = array('logno' => m('common')->createNO('system_plugingrant_log', 'logno', 'GT'), 'uniacid' => $_W['uniacid'], 'username' => $_W['user']['username'], 'price' => $price, 'month' => $month, 'createtime' => time());

		if ($cate == 'package') {
			$package = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_package') . ' 
                    where id = ' . $id . ' and state = 1 ');
			$packplugin = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_plugin') . '  WHERE id in (' . $package['pluginid'] . ') ');

			foreach ($packplugin as $key => $value) {
				$title .= $value['name'] . ';';
			}

			$package['data'] = unserialize($package['data']);
			$logdata['pluginid'] = $package['pluginid'];
		}
		else {
			if ($cate = 'plugin') {
				$item = pdo_fetch('SELECT gp.*,p.identity,p.name as pname,p.category,p.version,p.author,p.status,p.thumb,p.desc FROM ' . tablename('ewei_shop_system_plugingrant_plugin') . ' gp
                left join ' . tablename('ewei_shop_plugin') . ' as p on p.id = gp.pluginid 
                WHERE gp.id =:id limit 1', array(':id' => $id));
				$title = !empty($item['name']) ? $item['name'] : $item['pname'];
				$logdata['pluginid'] = intval($item['pluginid']);
			}
		}

		$params = array();

		if ($paytype == 'wechat') {
			$logdata['paytype'] = 1;
			$options = array();
			$options['appid'] = $setting['appid'];
			$options['mchid'] = $setting['mchid'];
			$options['apikey'] = $setting['apikey'];
			$params = array();
			$params['tid'] = $logdata['logno'];
			$params['fee'] = $price;
			$params['title'] = $title;
			$wechat = p('grant')->wechat_native_build($params, $options, 18);
			$wechat['success'] = false;
			$wechat['logno'] = $logdata['logno'];

			if (!is_error($wechat)) {
				$wechat['success'] = true;
			}
		}
		else {
			if ($paytype == 'alipay') {
				$logdata['paytype'] = 2;
				$params['tid'] = $logdata['logno'];
				$params['title'] = $title;
				$params['price'] = $price;
				$params['body'] = $_W['uniacid'];

				if (p('grant')) {
					$url = p('grant')->build($params);
				}
			}
		}

		pdo_insert('ewei_shop_system_plugingrant_order', $logdata);

		if ($paytype == 'wechat') {
			show_json(1, $wechat);
		}
		else {
			if ($paytype == 'alipay') {
				show_json(1, array('url' => $url));
			}
		}
	}

	public function paystatus()
	{
		global $_W;
		global $_GPC;
		$logno = trim($_GPC['logno']);
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_order') . ' where logno = \'' . $logno . '\'');

		if (0 < $order['paystatus']) {
			show_json(1);
		}
	}

	public function success()
	{
		global $_W;
		global $_GPC;
		$title = $_GET['subject'];
		unset($_GET['c']);
		unset($_GET['a']);
		unset($_GET['m']);
		unset($_GET['do']);
		unset($_GET['r']);

		if (p('grant')) {
			$result = p('grant')->verifyReturn($_GET);

			if (!$result) {
				return NULL;
			}
		}

		include $this->template();
	}
}

?>
