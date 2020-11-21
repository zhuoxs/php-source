<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Weixintemplate_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$list = $this->gettemplatelist();
		$industry = $this->getindustry();
		$industrytext = '';
		if ($industry && is_array($industry)) {
			foreach ($industry as $indu) {
				$industrytext .= $indu['first_class'] . '/' . $indu['second_class'] . '&nbsp;&nbsp;&nbsp;';
			}
		}

		include $this->template();
	}

	public function post()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$list = $this->gettemplatelist();
		$template = NULL;

		foreach ($list as $temp) {
			if ($temp['template_id'] == $id) {
				$template = $temp;
				break;
			}
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];

		if (empty($id)) {
			$ids = $_GPC['ids'];

			if (is_array($ids)) {
				foreach ($ids as $i) {
					$this->deltemplatebyid($i);
				}
			}
		}
		else {
			$this->deltemplatebyid($id);
		}

		show_json(1, array('url' => referer()));
	}

	public function getindustry()
	{
		global $_W;
		global $_GPC;
		load()->func('communication');
		$account = m('common')->getAccount();
		$token = $account->fetch_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=' . $token;
		$c = ihttp_request($url);
		$result = @json_decode($c['content'], true);

		if (!is_array($result)) {
			return false;
		}

		if (!empty($result['errcode'])) {
			return false;
		}

		return $result;
	}

	public function gettemplateid()
	{
		global $_W;
		global $_GPC;
		load()->func('communication');
		$bb = '{"template_id_short":"' . $_GPC['templateidshort'] . '"}';
		$account = m('common')->getAccount();
		$token = $account->fetch_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=' . $token;
		$c = ihttp_request($url, $bb);
		$result = @json_decode($c['content'], true);

		if (!is_array($result)) {
			show_json(0);
		}

		if (!empty($result['errcode'])) {
			show_json(0, $result['errmsg']);
		}

		show_json(1, $result);
	}

	public function gettemplatelist()
	{
		global $_W;
		global $_GPC;
		load()->func('communication');
		$account = m('common')->getAccount();
		$token = $account->fetch_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=' . $token;
		$c = ihttp_request($url);
		$result = @json_decode($c['content'], true);

		if (!is_array($result)) {
			return false;
		}

		if (!empty($result['errcode'])) {
			return false;
		}

		return $result['template_list'];
	}

	public function deltemplatebyid($template_id)
	{
		global $_W;
		global $_GPC;
		load()->func('communication');
		$bb = '{"template_id":"' . $template_id . '"}';
		$account = m('common')->getAccount();
		$token = $account->fetch_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token=' . $token;
		$c = ihttp_request($url, $bb);
		$result = @json_decode($c['content'], true);

		if (!is_array($result)) {
			show_json(0);
		}

		if (!empty($result['errcode'])) {
			show_json(0, $result['errmsg']);
		}
	}
}

?>
