<?php

defined('IN_IA') or exit('Access Denied');
require IA_ROOT . '/addons/xiaof_toupiao/global.php';
class Xiaof_toupiaoModule extends WeModule
{
	public function fieldsFormDisplay($rid = 0)
	{
		global $_W;
		$bindacid = pdo_fetchall('SELECT * FROM ' . tablename('xiaof_toupiao_acid') . ' WHERE `acid` = :acid', array(":acid" => $_W['uniacid']));
		$sids = array();
		foreach ($bindacid as $v) {
			$sids[] = intval($v['sid']);
		}
		$settinglists = pdo_fetchall('SELECT * FROM ' . tablename('xiaof_toupiao_setting') . ' WHERE `uniacid` = :uniacid OR `id` IN (\'' . implode('\',\'', $sids) . '\')  ORDER BY `created_at` DESC', array(":uniacid" => $_W['uniacid']));
		if ($rid != 0) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('xiaof_toupiao_rule') . ' WHERE `rid` = \'' . $rid . '\' limit 1');
			$sid = $item['sid'];
			$action = $item['action'];
		}
		include $this->template('rule');
	}
	public function fieldsFormSubmit($rid)
	{
		global $_W, $_GPC;
		$keywords = json_decode(htmlspecialchars_decode($_GPC['keywords']), true);
		$key = $_GPC['action'] == 3 ? $keywords[0]['content'] : md5($keywords[0]['content']);
		if ($item = pdo_fetch('SELECT * FROM ' . tablename('xiaof_toupiao_rule') . ' WHERE `rid` = \'' . $rid . '\' limit 1')) {
			pdo_update('xiaof_toupiao_rule', array("sid" => $_GPC['sid'], "uniacid" => $_W['uniacid'], "action" => $_GPC['action'], "keyword" => $key), array("rid" => $rid));
		} else {
			pdo_insert('xiaof_toupiao_rule', array("rid" => $rid, "sid" => $_GPC['sid'], "uniacid" => $_W['uniacid'], "action" => $_GPC['action'], "keyword" => $key));
		}
	}
	public function ruleDeleted($rid)
	{
		pdo_query('DELETE FROM ' . tablename('xiaof_toupiao_rule') . ' WHERE `rid` = \'' . $rid . '\'');
	}
	public function settingsDisplay($settings)
	{
		global $_W, $_GPC;
		$isfield = pdo_fieldexists('mc_mapping_fans', 'unionid');
		$file_path = MODULE_ROOT . '/data/site.txt';
		$content = file_get_contents($file_path);
		$site = explode('
', $content);
		$siteid = $site[0];
		$secret = $site[1];
		if (checksubmit()) {
			if (strpos($_GPC['secret'], '******') !== false) {
				if ($siteid) {
					$dat['siteid'] = $siteid;
				}
				if ($secret) {
					$dat['secret'] = $secret;
				}
			} else {
				$dat['siteid'] = $_GPC['siteid'];
				$dat['secret'] = $_GPC['secret'];
			}
			$this->_get_secret($dat);
			$this->_save_secret($dat);
			$dat['openweixin'] = $_GPC['openweixin'];
			$dat['fuzzysearch'] = $_GPC['fuzzysearch'];
			$dat['qrcodetips'] = $_GPC['qrcodetips'];
			$dat['activityadmin'] = $_GPC['activityadmin'];
			$dat['activitygift'] = $_GPC['activitygift'];
			$dat['activitylink'] = $_GPC['activitylink'];
			if ($_W['account']['level'] < 3) {
				$dat['openweixin'] = 0;
			}
			load()->func('file');
			if (!empty($_FILES['apiclient_cert']['name'])) {
				$apiclient_cert = file_upload($_FILES['apiclient_cert'], 'audio');
				$dat['apiclient_cert'] = $apiclient_cert['path'];
			} else {
				$dat['apiclient_cert'] = $this->module['config']['apiclient_cert'];
			}
			if (!empty($_FILES['apiclient_key']['name'])) {
				$apiclient_key = file_upload($_FILES['apiclient_key'], 'audio');
				$dat['apiclient_key'] = $apiclient_key['path'];
			} else {
				$dat['apiclient_key'] = $this->module['config']['apiclient_key'];
			}
			$dat['mch_id'] = $_GPC['mch_id'];
			$dat['mch_key'] = $_GPC['mch_key'];
			$dat['redpacklimit'] = $_GPC['redpacklimit'];
			$dat['redpackactname'] = $_GPC['redpackactname'];
			$dat['redpacksendname'] = $_GPC['redpacksendname'];
			$dat['redpackwishing'] = $_GPC['redpackwishing'];
			$dat['redpackremark'] = $_GPC['redpackremark'];
			$dat['smstype'] = $_GPC['smstype'];
			$dat['smsipnum'] = $_GPC['smsipnum'];
			$dat['smsphonenum'] = $_GPC['smsphonenum'];
			$dat['dayuak'] = $_GPC['dayuak'];
			$dat['dayusk'] = $_GPC['dayusk'];
			$dat['dayusign'] = $_GPC['dayusign'];
			$dat['dayumoduleid'] = $_GPC['dayumoduleid'];
			$dat['dayuname'] = $_GPC['dayuname'];
			$dat['juhe'] = $_GPC['juhe'];
			$dat['ipappcode'] = $_GPC['ipappcode'];
			$dat['hcipappcode'] = $_GPC['hcipappcode'];
			$dat['imagesaveqiniu'] = $_GPC['imagesaveqiniu'];
			$dat['qiniuak'] = $_GPC['qiniuak'];
			$dat['qiniusk'] = $_GPC['qiniusk'];
			$dat['qiniuzone'] = $_GPC['qiniuzone'];
			$dat['qiniuarea'] = $_GPC['qiniuarea'];
			$dat['qiniudomain'] = trim(str_replace(array("http://", "https://"), '', $_GPC['qiniudomain']));
			$dat['qiniupipeline'] = $_GPC['qiniupipeline'];
			$dat['baidumapak'] = $_GPC['baidumapak'];
			$dat['geetestid'] = $_GPC['geetestid'];
			$dat['geetestkey'] = $_GPC['geetestkey'];
			if ($dat['openweixin'] === 1 && !$isfield) {
				pdo_query('ALTER TABLE ' . tablename('mc_mapping_fans') . ' ADD  `unionid` VARCHAR( 50 ) NOT NULL');
			}
			$dat['openwildcarddomain'] = $_GPC['openwildcarddomain'];
			$dat['binddomain'] = array_filter($_GPC['binddomain']);
			foreach ($dat['binddomain'] as &$domainvalues) {
				$domainvalues = $this->makeHost($domainvalues);
				if (strexists($domainvalues, '*')) {
					$dat['openwildcarddomain'] = 1;
				}
			}
			$dat['paydomain'] = $this->makeHost($_GPC['paydomain']);
			$dat['sharedomain'] = $this->makeHost($_GPC['sharedomain']);
			$this->saveSettings($dat);
			if (count($dat['binddomain']) < 1) {
				$dat['binddomain'][] = $_W['siteroot'];
			}
			$host = '&lt;?php ' . PHP_EOL . '$_host = array();' . PHP_EOL;
			foreach ($dat['binddomain'] as $v) {
				$host .= '$_host[] = \'' . parse_url($v, PHP_URL_HOST) . '\';' . PHP_EOL;
			}
			$host_path = MODULE_ROOT . '/inc/host/';
			mkdirs($host_path);
			file_put_contents($host_path . 'acid' . $_W['uniacid'] . '.php', htmlspecialchars_decode($host));
			message('配置参数更新成功！', referer(), 'success');
		}
		include $this->template('setting');
	}
	protected function makeHost($domain)
	{
		if (empty($domain)) {
			return '';
		}
		$domain = rtrim(trim($domain), '/');
		if (strexists($domain, 'http://') or strexists($domain, 'https://')) {
			$hosts = parse_url($domain);
			$domain = $hosts['scheme'] . '://' . $hosts['host'] . $hosts['path'] . '/';
		} else {
			$domain = 'http://' . $domain . '/';
		}
		return $domain;
	}
	private function _get_secret($data = array())
	{
		global $_GPC;
		if (empty($data)) {
			return '';
		}
		$siteinfo = array("siteid" => $data['siteid'], "secret" => $data['secret']);
		require MODULE_ROOT . '/class/cloud.class.php';
		$cloud = new SupermanCloud($this->module, $siteinfo);
		$result = $cloud->api('check.index');

	}
	private function _save_secret($site = array())
	{
		$file_path = MODULE_ROOT . '/data/site.txt';
		$str = $site['siteid'] . '
' . $site['secret'];
		file_put_contents($file_path, $str);
	}
}