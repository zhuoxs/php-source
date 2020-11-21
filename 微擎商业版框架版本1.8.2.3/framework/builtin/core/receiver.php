<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
class CoreModuleReceiver extends WeModuleReceiver {
	public function receive() {
		global $_W;
		if($this->message['event'] == 'subscribe' && !empty($this->message['ticket'])) {
			$sceneid = $this->message['scene'];
			$acid = $this->acid;
			$uniacid = $this->uniacid;
			$ticket = trim($this->message['ticket']);
			if(!empty($ticket)) {
				$qr = pdo_fetchall("SELECT `id`, `keyword`, `name`, `acid` FROM " . tablename('qrcode') . " WHERE `uniacid` = '{$uniacid}' AND ticket = '{$ticket}'");
				if(!empty($qr)) {
					if(count($qr) != 1) {
						$qr = array();
					} else {
						$qr = $qr[0];
					}
				}
			}
			if(empty($qr)) {
				$sceneid = trim($this->message['scene']);
				if(is_numeric($sceneid)) {
					$scene_condition = " `qrcid` = '{$sceneid}'";
				} else {
					$scene_condition = " `scene_str` = '{$sceneid}'";
				}
				$qr = pdo_fetch("SELECT `id`, `keyword`, `name`, `acid` FROM " . tablename('qrcode') . " WHERE `uniacid` = '{$uniacid}' AND {$scene_condition}");
			}
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $qr['acid'],
				'qid' => $qr['id'],
				'openid' => $this->message['from'],
				'type' => 1,
				'qrcid' => intval($sceneid),
				'scene_str' => $sceneid,
				'name' => $qr['name'],
				'createtime' => TIMESTAMP,
			);
			pdo_insert('qrcode_stat', $insert);
		} elseif($this->message['event'] == 'SCAN') {
			$acid = $this->acid;
			$uniacid = $this->uniacid;
			$sceneid = trim($this->message['scene']);
			if(is_numeric($sceneid)) {
				$scene_condition = " `qrcid` = '{$sceneid}'";
			} else {
				$scene_condition = " `scene_str` = '{$sceneid}'";
			}
			$row = pdo_fetch("SELECT `id`, `keyword`, `name`, `acid` FROM " . tablename('qrcode') . " WHERE `uniacid` = '{$uniacid}' AND {$scene_condition}");
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $row['acid'],
				'qid' => $row['id'],
				'openid' => $this->message['from'],
				'type' => 2,
				'qrcid' => intval($sceneid),
				'scene_str' => $sceneid,
				'name' => $row['name'],
				'createtime' => TIMESTAMP,
			);
			pdo_insert('qrcode_stat', $insert);
		} elseif ($this->message['event'] == 'user_get_card') {
			$sceneid = $this->message['outerid'];
			$acid = $this->acid;
			$uniacid = $this->uniacid;
			$row = pdo_get('qrcode', array('qrcid' => $sceneid));
			if (!empty($row)) {
				$insert = array(
					'uniacid' => $_W['uniacid'],
					'acid' => $row['acid'],
					'qid' => $row['id'],
					'openid' => $this->message['from'],
					'type' => 2,
					'qrcid' => $sceneid,
					'scene_str' => $sceneid,
					'name' => $row['name'],
					'createtime' => TIMESTAMP,
				);
				pdo_insert('qrcode_stat', $insert);
			}
		}
		if ($this->message['event'] == 'subscribe' && !empty($_W['account']) && ($_W['account']['level'] == ACCOUNT_SERVICE_VERIFY || $_W['account']['level'] == ACCOUNT_SUBSCRIPTION_VERIFY)) {
			$account_obj = WeAccount::create();
			$userinfo = $account_obj->fansQueryInfo($this->message['from']);
			if(!is_error($userinfo) && !empty($userinfo) && !empty($userinfo['subscribe'])) {
				$userinfo['nickname'] = stripcslashes($userinfo['nickname']);
				$userinfo['avatar'] = $userinfo['headimgurl'];
				$fans = array(
					'unionid' => $userinfo['unionid'],
					'nickname' => strip_emoji($userinfo['nickname']),
					'tag' => base64_encode(iserializer($userinfo)),
				);
				pdo_update('mc_mapping_fans', $fans, array('openid' => $this->message['from']));
				$uid = !empty($_W['member']['uid']) ? $_W['member']['uid'] : $this->message['from'];
				if (!empty($uid)) {
					$member = array();
					if (!empty($userinfo['nickname'])) {
						$member['nickname'] = $fans['nickname'];
					}
					if (!empty($userinfo['headimgurl'])) {
						$member['avatar'] = $userinfo['headimgurl'];
					}
					load()->model('mc');
					mc_update($uid, $member);
				}
			}
		}
	}
}