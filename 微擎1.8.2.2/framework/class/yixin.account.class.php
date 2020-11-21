<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class YiXinAccount extends WeAccount {
	private $account = null;
	
	public function __construct($account) {
		$sql = 'SELECT * FROM ' . tablename('account_yixin') . ' WHERE `acid`=:acid';
		$this->account = pdo_fetch($sql, array(':acid' => $account['acid']));
		if(empty($this->account)) {
			trigger_error('error uniAccount id, can not construct ' . __CLASS__, E_USER_WARNING);
		}
		$this->account['access_token'] = iunserializer($this->account['access_token']);
	}

	public function checkSign() {
		$token = $this->account['token'];
		$signkey = array($token, $_GET['timestamp'], $_GET['nonce']);
		sort($signkey, SORT_STRING);
		$signString = implode($signkey);
		$signString = sha1($signString);
		return $signString == $_GET['signature'];
	}

	public function fetchAccountInfo() {
		return $this->account;
	}

	public function checkIntoManage() {

	}
	
	public function queryAvailableMessages() {
		$messages = array('text', 'image', 'voice', 'video', 'location', 'subscribe', 'unsubscribe');
		if(!empty($this->account['key']) && !empty($this->account['secret'])) {
			$messages[] = 'click';
			if(!empty($this->account['key'])) {
				$messages[] = 'qr';
				$messages[] = 'trace';
				$messages[] = 'enter';
			}
		}
		return $messages;
	}
	
	public function queryAvailablePackets() {
		$packets = array('text', 'music', 'news');
		if(!empty($this->account['key']) && !empty($this->account['secret'])) {
			if(!empty($this->account['key'])) {
				$packets[] = 'image';
				$packets[] = 'voice';
				$packets[] = 'video';
				$packets[] = 'link';
				$packets[] = 'card';
			}
		}
		return $packets;
	}	

	public function isMenuSupported() {
		return !empty($this->account['key']) && !empty($this->account['secret']);
	}

	private function menuResponseParse($content) {
		if(!is_array($content)) {
			return error(-1, '接口调用失败，请重试！' . (is_string($content) ? "易信公众平台返回元数据: {$content}" : ''));
		}
		$dat = $content['content'];
		$result = @json_decode($dat, true);
		if(is_array($result) && $result['errcode'] == '0') {
			return true;
		} else {
			if(is_array($result)) {
				return error(-1, "易信公众平台返回接口错误. \n错误代码为: {$result['errcode']} \n错误信息为: {$result['errmsg']} \n错误描述为: " . $this->errorCode($result['errcode']));
			} else {
				return error(-1, '易信公众平台未知错误');
			}
		}
	}
	
	private function menuBuildMenuSet($menu) {
		$set = array();
		$set['button'] = array();
		foreach($menu as $m) {
			$entry = array();
			$entry['name'] = urlencode($m['title']);
			if(!empty($m['subMenus'])) {
				$entry['sub_button'] = array();
				foreach($m['subMenus'] as $s) {
					$e = array();
					$e['type'] = $s['type'] == 'url' ? 'view' : 'click';
					$e['name'] = urlencode($s['title']);
					if($e['type'] == 'view') {
						$e['url'] = $s['url'];
					} else {
						$e['key'] = urlencode($s['forward']);
					}
					$entry['sub_button'][] = $e;
				}
			} else {
				$entry['type'] = $m['type'] == 'url' ? 'view' : 'click';
				if($entry['type'] == 'view') {
					$entry['url'] = $m['url'];
				} else {
					$entry['key'] = urlencode($m['forward']);
				}
			}
			$set['button'][] = $entry;
		}
		$dat = json_encode($set);
		$dat = urldecode($dat);
		return $dat;
	}

	public function menuCreate($menu) {
		$dat = $this->menuBuildMenuSet($menu);
		$token = $this->fetch_token();
		$url = "https://api.yixin.im/cgi-bin/menu/create?access_token={$token}";
		$content = ihttp_post($url, $dat);
		return $this->menuResponseParse($content);
	}

	public function menuDelete() {
		$token = $this->fetch_token();
		$url = "https://api.yixin.im/cgi-bin/menu/delete?access_token={$token}";
		$content = ihttp_get($url);
		return $this->menuResponseParse($content);
	}

	public function menuModify($menu) {
		return $this->menuCreate($menu);
	}

	public function menuQuery() {
		$token = $this->fetch_token();
		$url = "https://api.yixin.im/cgi-bin/menu/get?access_token={$token}";
		$content = ihttp_get($url);
		if(!is_array($content)) {
			return error(-1, '接口调用失败，请重试！' . (is_string($content) ? "易信公众平台返回元数据: {$content}" : ''));
		}
		$dat = $content['content'];
		$result = @json_decode($dat, true);
		if(is_array($result) && !empty($result['menu'])) {
			$menus = array();
			foreach($result['menu']['button'] as $val) {
				$m = array();
				$m['type'] = $val['type'] == 'click' ? 'forward' : 'url';
				$m['title'] = $val['name'];
				if($m['type'] == 'forward') {
					$m['forward'] = $val['key'];
				} else {
					$m['url'] = $val['url'];
				}
				$m['subMenus'] = array();
				if(!empty($val['sub_button'])) {
					foreach($val['sub_button'] as $v) {
						$s = array();
						$s['type'] = $v['type'] == 'click' ? 'forward' : 'url';
						$s['title'] = $v['name'];
						if($s['type'] == 'forward') {
							$s['forward'] = $v['key'];
						} else {
							$s['url'] = $v['url'];
						}
						$m['subMenus'][] = $s;
					}
				}
				$menus[] = $m;
			}
			return $menus;
		} else {
			if(is_array($result)) {
				if($result['errcode'] == '46003') {
					return array();
				}
				return error(-1, "易信公众平台返回接口错误. \n错误代码为: {$result['errcode']} \n错误信息为: {$result['errmsg']} \n错误描述为: " . $this->errorCode($result['errcode']));
			} else {
				return error(-1, '易信公众平台未知错误');
			}
		}
	}

	private function fetch_token() {
		load()->func('communication');
		if(is_array($this->account['access_token']) && !empty($this->account['access_token']['token']) && !empty($this->account['access_token']['expire']) && $this->account['access_token']['expire'] > TIMESTAMP) {
			return $this->account['access_token']['token'];
		} else {
			if (empty($this->account['key']) || empty($this->account['secret'])) {
				itoast('请填写公众号的appid及appsecret, (需要你的号码为易信服务号)！', url('account/post', array('acid' => $this->account['acid'], 'uniacid' => $this->account['uniacid'])), 'error');
			}
			$url = "https://api.yixin.im/cgi-bin/token?grant_type=client_credential&appid={$this->account['key']}&secret={$this->account['secret']}";
			$content = ihttp_get($url);
			if(is_error($content)) {
				itoast('获取微信公众号授权失败, 请稍后重试！错误详情: ' . $content['message'], '', 'error');
			}
			$token = @json_decode($content['content'], true);
			if(empty($token) || !is_array($token) || empty($token['access_token']) || empty($token['expires_in'])) {
				itoast('获取微信公众号授权失败, 请稍后重试！ 公众平台返回原始数据为: <br />' . $content['meta'], '', 'error');
			}
			$record = array();
			$record['token'] = $token['access_token'];
			$record['expire'] = TIMESTAMP + $token['expires_in'];
			$row = array();
			$row['access_token'] = iserializer($record);
			pdo_update('account_yixin', $row, array('acid' => $this->account['acid']));
			return $record['token'];
		}
	}
}
