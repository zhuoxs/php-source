<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class build_EweiShopV2Page extends PluginPfMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$goods = array();
		$openid = trim($_GPC['openid']);
		$content = trim(urldecode($_GPC['content']));

		if (empty($openid)) {
			exit();
		}

		$member = m('member')->getMember($openid);

		if (empty($member)) {
			exit();
		}

		$poster = pdo_fetch('select * from ' . tablename('ewei_shop_postera') . ' where keyword2=:keyword and uniacid=:uniacid limit 1', array(':keyword' => $content, ':uniacid' => $_W['uniacid']));

		if (empty($poster)) {
			m('message')->sendCustomNotice($openid, '未找到海报!');
			exit();
		}

		$time = time();

		if ($time < $poster['timestart']) {
			$starttext = empty($poster['starttext']) ? '活动于 [starttime] 开始，请耐心等待...' : $poster['starttext'];
			$starttext = str_replace('[starttime]', date('Y年m月d日 H:i', $poster['timestart']), $starttext);
			$starttext = str_replace('[endtime]', date('Y年m月d日 H:i', $poster['timeend']), $starttext);
			m('message')->sendCustomNotice($openid, $starttext);
			exit();
		}

		if ($poster['timeend'] < time()) {
			$endtext = empty($poster['endtext']) ? '活动已结束，谢谢您的关注！' : $poster['endtext'];
			$endtext = str_replace('[starttime]', date('Y-m-d H:i', $poster['timestart']), $endtext);
			$endtext = str_replace('[endtime]', date('Y-m-d- H:i', $poster['timeend']), $endtext);
			m('message')->sendCustomNotice($openid, $endtext);
			exit();
		}

		if ($member['isagent'] != 1 || $member['status'] != 1) {
			if (empty($poster['isopen'])) {
				$opentext = !empty($poster['opentext']) ? htmlspecialchars_decode($poster['opentext'], ENT_QUOTES) : '您还不是我们分销商，去努力成为分销商，拥有你的专属海报吧!';
				m('message')->sendCustomNotice($openid, $opentext, trim($poster['openurl']));
				exit();
			}
		}

		$waittext = !empty($poster['waittext']) ? htmlspecialchars_decode($poster['waittext'], ENT_QUOTES) : '您的专属海报正在拼命生成中，请等待片刻...';
		$waittext = str_replace('[starttime]', date('Y年m月d日 H:i', $poster['timestart']), $waittext);
		$waittext = str_replace('[endtime]', date('Y年m月d日 H:i', $poster['timeend']), $waittext);
		m('message')->sendCustomNotice($openid, $waittext);
		$qr = $this->model->getQR($poster, $member);

		if (is_error($qr)) {
			m('message')->sendCustomNotice($openid, '生成二维码出错: ' . $qr['message']);
			exit();
		}

		$img = $this->model->createPoster($poster, $member, $qr);
		$mediaid = $img['mediaid'];

		if (!empty($mediaid)) {
			m('message')->sendImage($openid, $mediaid);
		}
		else {
			$oktext = '<a href=\'' . $img['img'] . '\'>点击查看您的专属海报</a>';
			m('message')->sendCustomNotice($openid, $oktext);
		}

		exit();
	}
}

?>
