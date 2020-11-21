<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class ChatsModuleProcessor extends WeModuleProcessor {
	public $priority = 255;
	public function begin($expire = 300) {
		$this->beginContext($expire);
		return true;
	}
	public function end() {
		$this->respText('系统消息：公众号关闭了对话功能！');
		$this->endContext();
		return;
	}
	public function respond() {
		global $_W;
		$msgtype = $this->message['type'];
				$allow = array('text', 'image', 'location', 'link', 'trace');
		if(!in_array($msgtype, $allow)) {
			return $this->respText('抱歉,系统仅支持 文字，图片，地理位置，链接类型的消息！');
		}
		$close = 0;
		if($msgtype == 'text') {
			$content = $this->message['content'];
			if($content == '关闭') {
				$content = '<span class="text-danger">系统消息：粉丝关闭了对话</span>';
				$close = 1;
			}
		} elseif($msgtype == 'image') {
			$content = $this->message['picurl'];
		} elseif($msgtype == 'location') {
			$content = iserializer(array(
				'location_x' => $this->message['location_x'],
				'location_y' => $this->message['location_y'],
				'scale' => $this->message['scale'],
			));
		} elseif($msgtype == 'link') {
			$content = $this->message['url'];
		}
		if(!empty($content)) {
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $_W['acid'],
				'openid' => $_W['openid'],
				'msgtype' => $msgtype,
				'flag' => 2,
				'content' => $content,
				'createtime' => TIMESTAMP
			);
			pdo_insert('mc_chats_record', $insert);
		}
		$this->refreshContext(300);
		if($close == 1) {
			$this->endContext();
			return $this->respText('您成功关闭回话。');
		}
		return $this->respText('');
	}
}
