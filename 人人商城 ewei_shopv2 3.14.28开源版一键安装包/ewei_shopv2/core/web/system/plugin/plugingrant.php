<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Plugingrant_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and gl.type = \'system\' and gl.deleted = 0';
		$params = array();
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND gl.createtime >= :starttime AND gl.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		$searchfield = strtolower(trim($_GPC['searchfield']));
		$keyword = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($keyword)) {
			if ($searchfield == 'uniacid') {
				$condition .= ' and w.name like :keyword ';
			}
			else {
				if ($searchfield == 'plugin') {
					$condition .= ' and p.name like :keyword ';
				}
			}

			$params[':keyword'] = '%' . $keyword . '%';
		}

		$list = pdo_fetchall('SELECT gl.*,w.name as wname,p.name as pname,p.thumb,p.iscom,p.identity FROM ' . tablename('ewei_shop_system_plugingrant_log') . ' as gl
                    left join ' . tablename('account_wechats') . ' as w on w.uniacid = gl.uniacid
                    left join ' . tablename('ewei_shop_plugin') . (' as p on p.id = gl.pluginid
			        WHERE 1 ' . $condition . ' ORDER BY gl.id desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_system_plugingrant_log') . ' as gl
                    left join ' . tablename('account_wechats') . ' as w on w.uniacid = gl.uniacid
                    left join ' . tablename('ewei_shop_plugin') . (' as p on p.id = gl.pluginid
			        WHERE 1 ' . $condition . ' '), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function grant()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (p('grant')) {
			p('grant')->pluginGrant($id);
		}

		show_json(1, array('url' => webUrl('system/plugin/plugingrant')));
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
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_plugingrant_log') . ' WHERE id =:id limit 1', array(':id' => $id));

		if ($_W['ispost']) {
			$acid = pdo_fetch('SELECT acid,uniacid FROM ' . tablename('account_wechats') . ' WHERE acid=:acid limit 1', array(':acid' => intval($_GPC['uniacid'])));
			$data = array('type' => 'system', 'uniacid' => intval($acid['uniacid']), 'month' => intval($_GPC['month']), 'createtime' => time(), 'isperm' => intval($_GPC['isperm']));

			if (empty($data['uniacid'])) {
				show_json(0, '请选择公众号');
			}

			$pluginid = is_array($_GPC['pluginid']) ? implode(',', $_GPC['pluginid']) : 0;

			if (strlen($pluginid) <= 0) {
				show_json(0, '请选择应用');
			}

			if ($data['month'] < 0) {
				show_json(0, '请输入正确的使用时长');
			}

			$pluginid = explode(',', $pluginid);

			foreach ($pluginid as $value) {
				$plugin = pdo_fetch('select `identity` from ' . tablename('ewei_shop_plugin') . ' where id = ' . $value . ' ');
				$data['identity'] = $plugin['identity'];
				$data['pluginid'] = $value;

				if (0 < $data['isperm']) {
					$lastitem = pdo_fetch('SELECT MAX(permendtime) as permendtime,permlasttime FROM ' . tablename('ewei_shop_system_plugingrant_log') . '
                            WHERE uniacid = ' . $data['uniacid'] . ' and pluginid = ' . $value . ' and isperm = 1 limit 1');
					if (!empty($lastitem) && 0 < $lastitem['permendtime']) {
						$data['permendtime'] = strtotime('+' . $data['month'] . ' month', $lastitem['permendtime']);
						$data['permlasttime'] = $lastitem['permendtime'];
					}
					else {
						$data['permendtime'] = strtotime('+' . $data['month'] . ' month');
					}
				}

				pdo_insert('ewei_shop_system_plugingrant_log', $data);
			}

			show_json(1, array('url' => webUrl('system/plugin/plugingrant')));
		}

		if (!empty($item) && 0 < $item['pluginid']) {
			$plugin = pdo_fetch('select * from ' . tablename('ewei_shop_plugin') . ' where id = ' . $item['pluginid'] . ' ');
			$item['title'] = $plugin['title'] = $plugin['name'];
		}

		if (!empty($item) && 0 < $item['uniacid']) {
			$account = pdo_fetch('select * from ' . tablename('account_wechats') . ' where acid = ' . $item['uniacid'] . ' ');
			$account['title'] = $account['name'];
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id FROM ' . tablename('ewei_shop_system_plugingrant_log') . (' WHERE id = \'' . $id . '\''));

		if (empty($item)) {
			message('抱歉，权限设置不存在或是已经被删除！', webUrl('system/plugin/plugingrant', array('op' => 'display')), 'error');
		}

		$log = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_log') . 'where id = :id', array(':id' => $id));
		$currentTime = time();
		$isForever = $log['month'] == 0;
		if ($currentTime < $log['permendtime'] || $isForever) {
			show_json(0, array('url' => referer(), 'message' => '不允许删除未到期授权应用'));
		}

		pdo_update('ewei_shop_system_plugingrant_log', array('deleted' => '1'), array('id' => $id));
		show_json(1, array('url' => webUrl('system/plugin/plugingrant'), 'message' => '删除成功'));
	}

	public function queryplugin()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$condition = ' and deprecated=0 and status=1 ';

		if (!empty($kwd)) {
			$condition .= ' AND name LIKE :keyword ';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$plugins = pdo_fetchall('select id,`name` as title,thumb,`desc` from ' . tablename('ewei_shop_plugin') . ' where 1 ' . $condition . ' order by displayorder asc LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_plugin') . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination2($total, $pindex, $psize, '', array('before' => 5, 'after' => 4, 'ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
		include $this->template();
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$condition = ' ';

		if (!empty($kwd)) {
			$condition .= ' AND acc.isdeleted=0 AND ( a.name LIKE :keyword or u.username like :keyword)';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT distinct a.acid, a.name FROM ' . tablename('account_wechats') . ' a  ' . ' left join ' . tablename('uni_account') . ' ac on ac.uniacid = a.uniacid ' . ' left join ' . tablename('account') . ' acc on acc.uniacid = ac.uniacid ' . ' left join ' . tablename('uni_account_users') . ' uac on uac.uniacid = ac.uniacid' . ' left join ' . tablename('users') . ' u on u.uid = uac.uid ' . (' WHERE 1 ' . $condition . ' order by a.acid desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('account_wechats') . '  a  ' . ' left join ' . tablename('uni_account') . ' ac on ac.uniacid = a.uniacid ' . ' left join ' . tablename('account') . ' acc on acc.uniacid = ac.uniacid ' . ' left join ' . tablename('uni_account_users') . ' uac on uac.uniacid = ac.uniacid' . ' left join ' . tablename('users') . ' u on u.uid = uac.uid ' . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination2($total, $pindex, $psize, '', array('before' => 5, 'after' => 4, 'ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
		include $this->template();
	}
}

?>
