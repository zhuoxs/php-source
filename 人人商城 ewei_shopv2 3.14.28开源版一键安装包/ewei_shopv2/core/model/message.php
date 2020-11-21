<?php

class Message_EweiShopV2Model
{
	/**
     * 模板消息通知
     */
	public function sendTplNotice($touser, $template_id, $postdata, $url = '', $account = NULL, $miniprogram = array())
	{
		if (!$account) {
			$account = m('common')->getAccount();
		}

		if (!$account) {
			return NULL;
		}

		return $account->sendTplNotice($touser, $template_id, $postdata, $url, '#FF683F', $miniprogram);
	}

	public function sendCustomNotice($openid, $msg, $url = '', $account = NULL)
	{
		if (!$account) {
			$account = m('common')->getAccount();
		}

		if (!$account) {
			return NULL;
		}

		$content = '';

		if (is_array($msg)) {
			foreach ($msg as $key => $value) {
				if (!empty($value['title'])) {
					$content .= $value['title'] . ':' . $value['value'] . '
';
				}
				else {
					$content .= $value['value'] . '
';

					if ($key == 0) {
						$content .= '
';
					}
				}
			}
		}
		else {
			$content = addslashes($msg);
		}

		if (!empty($url)) {
			$content .= '<a href=\'' . $url . '\'>点击查看详情</a>';
		}

		return $account->sendCustomNotice(array(
			'touser'  => $openid,
			'msgtype' => 'text',
			'text'    => array('content' => urlencode($content))
		));
	}

	/**
     * 发送图片
     * @param type $openid
     * @param type $mediaid
     * @return type 
     */
	public function sendImage($openid, $mediaid)
	{
		$account = m('common')->getAccount();
		return $account->sendCustomNotice(array(
			'touser'  => $openid,
			'msgtype' => 'image',
			'image'   => array('media_id' => $mediaid)
		));
	}

	public function sendNews($openid, $articles, $account = NULL)
	{
		if (!$account) {
			$account = m('common')->getAccount();
		}

		return $account->sendCustomNotice(array(
			'touser'  => $openid,
			'msgtype' => 'news',
			'news'    => array('articles' => $articles)
		));
	}

	public function sendTexts($openid, $content, $url = '', $account = NULL)
	{
		if (!$account) {
			$account = m('common')->getAccount();
		}

		if (!empty($url)) {
			$content .= '
<a href=\'' . $url . '\'>点击查看详情</a>';
		}

		return $account->sendCustomNotice(array(
			'touser'  => $openid,
			'msgtype' => 'text',
			'text'    => array('content' => urlencode($content))
		));
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
