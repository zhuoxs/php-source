<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

define('TM_ABONUS_PAY', 'TM_ABONUS_PAY');
define('TM_ABONUS_UPGRADE', 'TM_ABONUS_UPGRADE');
define('TM_ABONUS_BECOME', 'TM_ABONUS_BECOME');

if (!class_exists('AbonusModel')) {
	class AbonusModel extends PluginModel
	{
		public function getSet($uniacid = 0)
		{
			$set = parent::getSet($uniacid);
			$set['texts'] = array('aagent' => empty($set['texts']['aagent']) ? '区域代理' : $set['texts']['aagent'], 'center' => empty($set['texts']['center']) ? '区域代理中心' : $set['texts']['center'], 'become' => empty($set['texts']['become']) ? '成为区域代理' : $set['texts']['become'], 'bonus' => empty($set['texts']['bonus']) ? '分红' : $set['texts']['bonus'], 'bonus_total' => empty($set['texts']['bonus_total']) ? '累计分红' : $set['texts']['bonus_total'], 'bonus_lock' => empty($set['texts']['bonus_lock']) ? '待结算分红' : $set['texts']['bonus_lock'], 'bonus_pay' => empty($set['texts']['bonus_lock']) ? '已结算分红' : $set['texts']['bonus_pay'], 'bonus_wait' => empty($set['texts']['bonus_wait']) ? '预计分红' : $set['texts']['bonus_wait'], 'bonus_detail' => empty($set['texts']['bonus_detail']) ? '分红明细' : $set['texts']['bonus_detail'], 'bonus_charge' => empty($set['texts']['bonus_charge']) ? '扣除提现手续费' : $set['texts']['bonus_charge']);
			return $set;
		}

		/**
         * 获取所有代理商等级
         * @global type $_W
         * @return type
         */
		public function getLevels($all = true, $default = false)
		{
			global $_W;

			if ($all) {
				$levels = pdo_fetchall('select * from ' . tablename('ewei_shop_abonus_level') . ' where uniacid=:uniacid order by id asc', array(':uniacid' => $_W['uniacid']));
			}
			else {
				$levels = pdo_fetchall('select * from ' . tablename('ewei_shop_abonus_level') . ' where uniacid=:uniacid and (ordermoney>0 or bonusmoney>0) order by bonus asc', array(':uniacid' => $_W['uniacid']));
			}

			if ($default) {
				$default = array('id' => '0', 'levelname' => empty($_S['abonus']['levelname']) ? '默认等级' : $_S['abonus']['levelname'], 'bonus1' => $_W['shopset']['abonus']['bonus1'], 'bonus2' => $_W['shopset']['abonus']['bonus2'], 'bonus3' => $_W['shopset']['abonus']['bonus3']);
				$levels = array_merge(array($default), $levels);
			}

			return $levels;
		}

		public function getBonus($openid = '', $params = array())
		{
			global $_W;

			if (in_array('ok', $params)) {
				$ret['ok'] = pdo_fetchcolumn('select ifnull(sum(paymoney1),0)+ifnull(sum(paymoney2),0)  + ifnull(sum(paymoney3),0)  from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and status=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('ok1', $params)) {
				$ret['ok1'] = pdo_fetchcolumn('select ifnull(sum(paymoney1),0)  from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and status=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('ok2', $params)) {
				$ret['ok2'] = pdo_fetchcolumn('select ifnull(sum(paymoney2),0)   from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and status=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('ok3', $params)) {
				$ret['ok3'] = pdo_fetchcolumn('select ifnull(sum(paymoney3),0)   from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and status=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('lock', $params)) {
				$ret['lock'] = pdo_fetchcolumn('select ifnull(sum(paymoney1),0)+ifnull(sum(paymoney2),0)  + ifnull(sum(paymoney3),0)  from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and status<>1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('lock1', $params)) {
				$ret['lock1'] = pdo_fetchcolumn('select ifnull(sum(paymoney1),0)  from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and status<>1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('lock2', $params)) {
				$ret['lock2'] = pdo_fetchcolumn('select ifnull(sum(paymoney2),0)   from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and status<>1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('lock3', $params)) {
				$ret['lock3'] = pdo_fetchcolumn('select ifnull(sum(paymoney3),0)  from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and status<>1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('total', $params)) {
				$ret['total'] = pdo_fetchcolumn('select ifnull(sum(paymoney1),0)+ifnull(sum(paymoney2),0)  + ifnull(sum(paymoney3),0)  from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('total1', $params)) {
				$ret['total1'] = pdo_fetchcolumn('select ifnull(sum(paymoney1),0)  from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('total2', $params)) {
				$ret['total2'] = pdo_fetchcolumn('select ifnull(sum(paymoney2),0)   from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			if (in_array('total3', $params)) {
				$ret['total3'] = pdo_fetchcolumn('select ifnull(sum(paymoney3),0)  from ' . tablename('ewei_shop_abonus_billp') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			}

			return $ret;
		}

		/**
         * 消息通知
         * @param type $message_type
         * @param type $openid
         * @return type
         */
		public function sendMessage($openid = '', $data = array(), $message_type = '')
		{
			global $_W;
			global $_GPC;
			$set = $this->getSet();
			$tm = $set['tm'];
			$templateid = $tm['templateid'];
			$member = m('member')->getMember($openid);
			$time = date('Y-m-d H:i:s', time());
			$usernotice = unserialize($member['noticeset']);
			$advanced = '';

			if (!is_array($usernotice)) {
				$usernotice = array();
			}

			if ($message_type == TM_ABONUS_PAY && empty($usernotice['abonus_pay'])) {
				if ($tm['is_advanced']) {
					if ($tm['abonus_pay_close_advanced']) {
						return false;
					}

					$message = '';
					$paytitle = '';

					if ($data['aagenttype'] == 1) {
						$message = $tm['pay1'];
						$paytitle = empty($tm['paytitle1']) ? '省级代理分红发放通知' : $tm['paytitle1'];
					}
					else if ($data['aagenttype'] == 2) {
						$message = $tm['pay2'];
						$paytitle = empty($tm['paytitle2']) ? '市级代理分红发放通知' : $tm['paytitle2'];
					}
					else {
						if ($data['aagenttype'] == 3) {
							$message = $tm['pay3'];
							$paytitle = empty($tm['paytitle3']) ? '区级代理分红发放通知' : $tm['paytitle3'];
						}
					}

					if (empty($message)) {
						return false;
					}

					$datas[] = array('name' => '昵称', 'value' => $member['nickname']);
					$datas[] = array('name' => '时间', 'value' => $time);
					$datas[] = array('name' => '打款方式', 'value' => $data['type']);

					if ($data['aagenttype'] == 1) {
						$datas[] = array('name' => '省级分红金额', 'value' => $data['paymoney1']);
						$datas[] = array('name' => '市级分红金额', 'value' => $data['paymoney2']);
						$datas[] = array('name' => '区级分红金额', 'value' => $data['paymoney3']);
					}
					else if ($data['aagenttype'] == 2) {
						$datas[] = array('name' => '市级分红金额', 'value' => $data['paymoney2']);
						$datas[] = array('name' => '区级分红金额', 'value' => $data['paymoney3']);
					}
					else {
						if ($data['aagenttype'] == 3) {
							$datas[] = array('name' => '区级分红金额', 'value' => $data['paymoney3']);
						}
					}

					$tag = 'abonus_pay';
					$text = '您的' . $set['texts']['bonus'] . '已打款！
' . date('Y-m-d H:i') . '
';
					$message = array(
						'first'    => array('value' => '亲爱的' . $member['nickname'] . '，您的' . $set['texts']['aagent'] . '的' . $set['texts']['bonus'] . '已打款', 'color' => '#ff0000'),
						'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
						'keyword2' => array('title' => '业务内容', 'value' => '您的区域代理分红已发放', 'color' => '#000000'),
						'keyword3' => array('title' => '处理结果', 'value' => '区域代理分红发放通知', 'color' => '#000000'),
						'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
						'remark'   => array('value' => '
感谢您的支持', 'color' => '#000000')
						);
					$toopenid = $openid;
				}
				else {
					$message = '';
					$paytitle = '';

					if ($data['aagenttype'] == 1) {
						$message = $tm['pay1'];
						$paytitle = empty($tm['paytitle1']) ? '省级代理分红发放通知' : $tm['paytitle1'];
					}
					else if ($data['aagenttype'] == 2) {
						$message = $tm['pay2'];
						$paytitle = empty($tm['paytitle2']) ? '市级代理分红发放通知' : $tm['paytitle2'];
					}
					else {
						if ($data['aagenttype'] == 3) {
							$message = $tm['pay3'];
							$paytitle = empty($tm['paytitle3']) ? '区级代理分红发放通知' : $tm['paytitle3'];
						}
					}

					if (empty($message)) {
						return false;
					}

					$message = str_replace('[昵称]', $member['nickname'], $message);
					$message = str_replace('[时间]', date('Y-m-d H:i:s', time()), $message);
					$message = str_replace('[打款方式]', $data['type'], $message);

					if ($data['aagenttype'] == 1) {
						$message = str_replace('[省级分红金额]', $data['paymoney1'], $message);
						$message = str_replace('[市级分红金额]', $data['paymoney2'], $message);
						$message = str_replace('[区级分红金额]', $data['paymoney3'], $message);
						$advanced = 'pay1_advanced';
					}
					else if ($data['aagenttype'] == 2) {
						$message = str_replace('[市级分红金额]', $data['paymoney2'], $message);
						$message = str_replace('[区级分红金额]', $data['paymoney3'], $message);
						$advanced = 'pay2_advanced';
					}
					else {
						if ($data['aagenttype'] == 3) {
							$message = str_replace('[区级分红金额]', $data['paymoney3'], $message);
							$advanced = 'pay3_advanced';
						}
					}

					$msg = array(
						'keyword1' => array('value' => '会员通知', 'color' => '#73a68d'),
						'keyword2' => array('value' => $paytitle, 'color' => '#73a68d'),
						'keyword3' => array('value' => $message, 'color' => '#73a68d')
						);
					return $this->sendNotice($openid, $tm, $advanced, $data, $member, $msg);
				}
			}
			else {
				if ($message_type == TM_ABONUS_UPGRADE && empty($usernotice['abonus_upgrade'])) {
					if ($tm['is_advanced']) {
						if ($tm['abonus_upgrade1_close_advanced'] && $tm['abonus_upgrade2_close_advanced'] && $tm['abonus_upgrade3_close_advanced']) {
							return false;
						}

						$message = '';
						$upgradetitle = '';
						if ($data['aagenttype'] == 1 && empty($tm['abonus_upgrade1_close_advanced'])) {
							$message = $tm['upgrade1'];
							$tag = 'abonus_upgrade1';
							$upgradetitle = empty($tm['upgradetitle1']) ? '省级代理等级升级通知' : $tm['upgradetitle1'];
						}
						else {
							if ($data['aagenttype'] == 2 && empty($tm['abonus_upgrade2_close_advanced'])) {
								$tag = 'abonus_upgrade2';
								$message = $tm['upgrade2'];
								$upgradetitle = empty($tm['upgradetitle2']) ? '市级代理等级升级通知' : $tm['upgradetitle2'];
							}
							else {
								if ($data['aagenttype'] == 3 && empty($tm['abonus_upgrade3_close_advanced'])) {
									$tag = 'abonus_upgrade3';
									$message = $tm['upgrade3'];
									$upgradetitle = empty($tm['upgradetitle3']) ? '区级代理等级升级通知' : $tm['upgradetitle3'];
								}
							}
						}

						if (empty($message)) {
							return false;
						}

						$datas[] = array('name' => '昵称', 'value' => $member['nickname']);
						$datas[] = array('name' => '时间', 'value' => $time);
						$datas[] = array('name' => '旧等级', 'value' => $data['oldlevel']['levelname']);
						$datas[] = array('name' => '新等级', 'value' => $data['newlevel']['levelname']);

						if ($member['aagenttype'] == 1) {
							$datas[] = array('name' => '旧省级分红比例', 'value' => $data['oldlevel']['bonus1'] . '%');
							$datas[] = array('name' => '旧市级分红比例', 'value' => $data['oldlevel']['bonus2'] . '%');
							$datas[] = array('name' => '旧区级分红比例', 'value' => $data['oldlevel']['bonus3'] . '%');
							$datas[] = array('name' => '新省级分红比例', 'value' => $data['newlevel']['bonus1'] . '%');
							$datas[] = array('name' => '新市级分红比例', 'value' => $data['newlevel']['bonus2'] . '%');
							$datas[] = array('name' => '新区级分红比例', 'value' => $data['newlevel']['bonus3'] . '%');
						}
						else if ($member['aagenttype'] == 2) {
							$datas[] = array('name' => '旧市级分红比例', 'value' => $data['oldlevel']['bonus2'] . '%');
							$datas[] = array('name' => '旧区级分红比例', 'value' => $data['oldlevel']['bonus3'] . '%');
							$datas[] = array('name' => '新市级分红比例', 'value' => $data['newlevel']['bonus2'] . '%');
							$datas[] = array('name' => '新区级分红比例', 'value' => $data['newlevel']['bonus3'] . '%');
						}
						else {
							if ($member['aagenttype'] == 3) {
								$datas[] = array('name' => '旧区级分红比例', 'value' => $data['oldlevel']['bonus3'] . '%');
								$datas[] = array('name' => '新区级分红比例', 'value' => $data['newlevel']['bonus3'] . '%');
							}
						}

						$text = '恭喜您升级为' . $data['newlevel']['levelname'] . '！
' . date('Y-m-d H:i') . '
';
						$message = array(
							'first'    => array('value' => '亲爱的' . $member['nickname'] . '，恭喜您升级为' . $data['newlevel']['levelname'], 'color' => '#ff0000'),
							'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
							'keyword2' => array('title' => '业务内容', 'value' => '您的区域代理等级从' . $data['oldlevel']['levelname'] . '升级为' . $data['newlevel']['levelname'] . '特此通知！', 'color' => '#000000'),
							'keyword3' => array('title' => '处理结果', 'value' => '区域等级升级通知', 'color' => '#000000'),
							'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
							'remark'   => array('value' => '
感谢您的支持', 'color' => '#000000')
							);
						$toopenid = $openid;
					}
					else {
						$message = $tm['upgrade'];
						$upgradetitle = '';

						if ($data['aagenttype'] == 1) {
							$message = $tm['upgrade1'];
							$upgradetitle = empty($tm['upgradetitle1']) ? '省级代理等级升级通知' : $tm['upgradetitle1'];
						}
						else if ($data['aagenttype'] == 2) {
							$message = $tm['upgrade2'];
							$upgradetitle = empty($tm['upgradetitle2']) ? '市级代理等级升级通知' : $tm['upgradetitle2'];
						}
						else {
							if ($data['aagenttype'] == 3) {
								$message = $tm['upgrade3'];
								$upgradetitle = empty($tm['upgradetitle3']) ? '区级代理等级升级通知' : $tm['upgradetitle3'];
							}
						}

						if (empty($message)) {
							return false;
						}

						$message = str_replace('[昵称]', $member['nickname'], $message);
						$message = str_replace('[时间]', date('Y-m-d H:i:s', time()), $message);
						$message = str_replace('[旧等级]', $data['oldlevel']['levelname'], $message);
						$message = str_replace('[新等级]', $data['newlevel']['levelname'], $message);
						$advanced = '';

						if ($member['aagenttype'] == 1) {
							$message = str_replace('[旧省级分红比例]', $data['oldlevel']['bonus1'] . '%', $message);
							$message = str_replace('[旧市级分红比例]', $data['oldlevel']['bonus2'] . '%', $message);
							$message = str_replace('[旧区级分红比例]', $data['oldlevel']['bonus3'] . '%', $message);
							$message = str_replace('[新省级分红比例]', $data['newlevel']['bonus1'] . '%', $message);
							$message = str_replace('[新市级分红比例]', $data['newlevel']['bonus2'] . '%', $message);
							$message = str_replace('[新区级分红比例]', $data['newlevel']['bonus3'] . '%', $message);
							$advanced = 'upgrade1_advanced';
						}
						else if ($member['aagenttype'] == 2) {
							$message = str_replace('[旧市级分红比例]', $data['oldlevel']['bonus2'] . '%', $message);
							$message = str_replace('[旧区级分红比例]', $data['oldlevel']['bonus3'] . '%', $message);
							$message = str_replace('[新市级分红比例]', $data['newlevel']['bonus2'] . '%', $message);
							$message = str_replace('[新区级分红比例]', $data['newlevel']['bonus3'] . '%', $message);
							$advanced = 'upgrade2_advanced';
						}
						else {
							if ($member['aagenttype'] == 3) {
								$message = str_replace('[旧区级分红比例]', $data['oldlevel']['bonus3'] . '%', $message);
								$message = str_replace('[新区级分红比例]', $data['newlevel']['bonus3'] . '%', $message);
								$advanced = 'upgrade3_advanced';
							}
						}

						$msg = array(
							'keyword1' => array('value' => '会员通知', 'color' => '#73a68d'),
							'keyword2' => array('value' => $upgradetitle, 'color' => '#73a68d'),
							'keyword3' => array('value' => $message, 'color' => '#73a68d')
							);
						return $this->sendNotice($openid, $tm, $advanced, $data, $member, $msg);
					}
				}
				else {
					if ($message_type == TM_ABONUS_BECOME && empty($usernotice['abonus_become'])) {
						if ($tm['is_advanced']) {
							if ($tm['abonus_become_close_advanced']) {
								return false;
							}

							if ($data['aagenttype'] == 1) {
								$aagenttype = '省级代理';
							}
							else if ($data['aagenttype'] == 2) {
								$aagenttype = '市级代理';
							}
							else {
								if ($data['aagenttype'] == 3) {
									$aagenttype = '区级代理';
								}
							}

							$tag = 'abonus_become';
							$text = '恭喜您成为' . $aagenttype . '！
' . date('Y-m-d H:i') . '
';
							$message = array(
								'first'    => array('value' => '亲爱的' . $member['nickname'] . '，恭喜您成为' . $aagenttype, 'color' => '#ff0000'),
								'keyword1' => array('title' => '业务类型', 'value' => '会员通知', 'color' => '#000000'),
								'keyword2' => array('title' => '业务内容', 'value' => '您已成为' . $aagenttype, 'color' => '#000000'),
								'keyword3' => array('title' => '处理结果', 'value' => '成为区域代理通知', 'color' => '#000000'),
								'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), 'color' => '#000000'),
								'remark'   => array('value' => '
感谢您的支持', 'color' => '#000000')
								);
							$toopenid = $openid;
							$datas[] = array('name' => '昵称', 'value' => $data['nickname']);
							$datas[] = array('name' => '时间', 'value' => $time);
							$datas[] = array('name' => '代理级别', 'value' => $aagenttype);
							$datas[] = array('name' => '代理区域', 'value' => $data['aagentareas']);
						}
						else {
							$message = $tm['become'];

							if (empty($message)) {
								return false;
							}

							$message = str_replace('[昵称]', $data['nickname'], $message);
							$message = str_replace('[时间]', date('Y-m-d H:i:s', $data['aagenttime']), $message);

							if ($data['aagenttype'] == 1) {
								$aagenttype = '省级代理';
							}
							else if ($data['aagenttype'] == 2) {
								$aagenttype = '市级代理';
							}
							else {
								if ($data['aagenttype'] == 3) {
									$aagenttype = '区级代理';
								}
							}

							$message = str_replace('[代理级别]', $aagenttype, $message);
							$message = str_replace('[代理区域]', $data['aagentareas'], $message);
							$msg = array(
								'keyword1' => array('value' => '会员通知', 'color' => '#73a68d'),
								'keyword2' => array('value' => !empty($tm['becometitle']) ? $tm['becometitle'] : '成为区域代理通知', 'color' => '#73a68d'),
								'keyword3' => array('value' => $message, 'color' => '#73a68d')
								);
							return $this->sendNotice($openid, $tm, 'become_advanced', $data, $member, $msg);
						}
					}
				}
			}

			m('notice')->sendNotice(array('openid' => $toopenid, 'tag' => $tag, 'default' => $message, 'cusdefault' => $text, 'datas' => $datas, 'plugin' => 'abonus'));
		}

		protected function sendNotice($touser, $tm, $tag, $datas, $member, $msg)
		{
			global $_W;
			if (!empty($tm['is_advanced']) && !empty($tm[$tag])) {
				$advanced_template = pdo_fetch('select * from ' . tablename('ewei_shop_member_message_template') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $tm[$tag], ':uniacid' => $_W['uniacid']));

				if (!empty($advanced_template)) {
					$url = !empty($advanced_template['url']) ? $this->replaceTemplate($advanced_template['url'], $tag, $datas, $member) : '';
					$advanced_message = array(
						'first'  => array('value' => $this->replaceTemplate($advanced_template['first'], $tag, $datas, $member), 'color' => $advanced_template['firstcolor']),
						'remark' => array('value' => $this->replaceTemplate($advanced_template['remark'], $tag, $datas, $member), 'color' => $advanced_template['remarkcolor'])
						);
					$data = iunserializer($advanced_template['data']);

					foreach ($data as $d) {
						$advanced_message[$d['keywords']] = array('value' => $this->replaceTemplate($d['value'], $tag, $datas, $member), 'color' => $d['color']);
					}

					if (!empty($advanced_template['template_id'])) {
						m('message')->sendTplNotice($touser, $advanced_template['template_id'], $advanced_message);
					}
					else {
						m('message')->sendCustomNotice($touser, $advanced_message);
					}
				}
			}
			else if (!empty($tm['templateid'])) {
				m('message')->sendTplNotice($touser, $tm['templateid'], $msg);
			}
			else {
				m('message')->sendCustomNotice($touser, $msg);
			}

			return true;
		}

		protected function replaceTemplate($str, $tag, $data, $member)
		{
			$arr = array('[昵称]' => $member['nickname'], '[时间]' => date('Y-m-d H:i:s', time()), '[提现方式]' => !empty($data['type']) ? $data['type'] : '', '[旧等级]' => !empty($data['oldlevel']['levelname']) ? $data['oldlevel']['levelname'] : '', '[新等级]' => !empty($data['newlevel']['levelname']) ? $data['newlevel']['levelname'] : '');

			switch ($tag) {
			case 'become_advanced':
				$arr['[时间]'] = date('Y-m-d H:i:s', $data['aagenttime']);
				$arr['[昵称]'] = $data['nickname'];
			case 'pay1_advanced':
				$arr['[昵称]'] = $data['nickname'];
				$arr['[时间]'] = date('Y-m-d H:i:s', $data['paytime']);
				$arr['[省级分红金额]'] = $data['paymoney1'];
				$arr['[市级分红金额]'] = $data['paymoney2'];
				$arr['[区级分红金额]'] = $data['paymoney3'];
			case 'pay2_advanced':
				$arr['[昵称]'] = $data['nickname'];
				$arr['[时间]'] = date('Y-m-d H:i:s', $data['paytime']);
				$arr['[市级分红金额]'] = $data['paymoney2'];
				$arr['[区级分红金额]'] = $data['paymoney3'];
			case 'pay3_advanced':
				$arr['[昵称]'] = $data['nickname'];
				$arr['[时间]'] = date('Y-m-d H:i:s', $data['paytime']);
				$arr['[区级分红金额]'] = $data['paymoney3'];
			case 'upgrade1_advanced':
				$arr['[旧省级分红比例]'] = !empty($data['oldlevel']['bonus1']) ? $data['oldlevel']['bonus1'] . '%' : '';
				$arr['[旧市级分红金额]'] = !empty($data['oldlevel']['bonus2']) ? $data['oldlevel']['bonus2'] . '%' : '';
				$arr['[旧区级分红金额]'] = !empty($data['oldlevel']['bonus3']) ? $data['oldlevel']['bonus3'] . '%' : '';
				$arr['[新省级分红比例]'] = !empty($data['newlevel']['bonus1']) ? $data['newlevel']['bonus1'] . '%' : '';
				$arr['[新市级分红金额]'] = !empty($data['newlevel']['bonus2']) ? $data['newlevel']['bonus2'] . '%' : '';
				$arr['[新区级分红金额]'] = !empty($data['newlevel']['bonus3']) ? $data['newlevel']['bonus3'] . '%' : '';
			case 'upgrade1_advanced':
				$arr['[旧市级分红金额]'] = !empty($data['oldlevel']['bonus2']) ? $data['oldlevel']['bonus2'] . '%' : '';
				$arr['[旧区级分红金额]'] = !empty($data['oldlevel']['bonus3']) ? $data['oldlevel']['bonus3'] . '%' : '';
				$arr['[新市级分红金额]'] = !empty($data['newlevel']['bonus2']) ? $data['newlevel']['bonus2'] . '%' : '';
				$arr['[新区级分红金额]'] = !empty($data['newlevel']['bonus3']) ? $data['newlevel']['bonus3'] . '%' : '';
			case 'upgrade3_advanced':
				$arr['[旧区级分红金额]'] = !empty($data['oldlevel']['bonus3']) ? $data['oldlevel']['bonus3'] . '%' : '';
				$arr['[新区级分红金额]'] = !empty($data['newlevel']['bonus3']) ? $data['newlevel']['bonus3'] . '%' : '';
				break;
			}

			foreach ($arr as $key => $value) {
				$str = str_replace($key, $value, $str);
			}

			return $str;
		}

		public function getLevel($openid)
		{
			global $_W;

			if (empty($openid)) {
				return false;
			}

			$member = m('member')->getMember($openid);

			if (empty($member['aagentlevel'])) {
				return false;
			}

			$level = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $member['aagentlevel']));
			return $level;
		}

		public function getInfo($openid, $options = NULL)
		{
			return p('commission')->getInfo($openid, $options);
		}

		/**
         * 代理商升级(根据分销订单)
         * @param type $mid
         */
		public function upgradeLevelByOrder($openid)
		{
			global $_W;

			if (empty($openid)) {
				return false;
			}

			$set = $this->getSet();

			if (empty($set['open'])) {
				return false;
			}

			$m = m('member')->getMember($openid);

			if (empty($m)) {
				return NULL;
			}

			$leveltype = intval($set['leveltype']);
			if ($leveltype == 4 || $leveltype == 5) {
				if (!empty($m['aagentnotupgrade'])) {
					return NULL;
				}

				$oldlevel = $this->getLevel($m['openid']);

				if (empty($oldlevel['id'])) {
					$oldlevel = array('levelname' => empty($set['levelname']) ? '普通代理商' : $set['levelname'], 'bonus' => $set['bonus']);
				}

				$orders = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('ewei_shop_order') . ' o ' . ' left join  ' . tablename('ewei_shop_order_goods') . ' og on og.orderid=o.id ' . ' where o.openid=:openid and o.status>=3 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
				$ordermoney = $orders['ordermoney'];
				$ordercount = $orders['ordercount'];

				if ($leveltype == 4) {
					$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid  and ' . $ordermoney . ' >= ordermoney and ordermoney>0  order by ordermoney desc limit 1'), array(':uniacid' => $_W['uniacid']));

					if (empty($newlevel)) {
						return NULL;
					}

					if (!empty($oldlevel['id'])) {
						if ($oldlevel['id'] == $newlevel['id']) {
							return NULL;
						}

						if ($newlevel['ordermoney'] < $oldlevel['ordermoney']) {
							return NULL;
						}
					}
				}
				else {
					if ($leveltype == 5) {
						$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid  and ' . $ordercount . ' >= ordercount and ordercount>0  order by ordercount desc limit 1'), array(':uniacid' => $_W['uniacid']));

						if (empty($newlevel)) {
							return NULL;
						}

						if (!empty($oldlevel['id'])) {
							if ($oldlevel['id'] == $newlevel['id']) {
								return NULL;
							}

							if ($newlevel['ordercount'] < $oldlevel['ordercount']) {
								return NULL;
							}
						}
					}
				}

				pdo_update('ewei_shop_member', array('aagentlevel' => $newlevel['id']), array('id' => $m['id']));
				$this->sendMessage($m['openid'], array('nickname' => $m['nickname'], 'oldlevel' => $oldlevel, 'newlevel' => $newlevel), TM_ABONUS_UPGRADE);
			}
			else {
				if (0 <= $leveltype && $leveltype <= 3) {
					$agents = array();

					if (!empty($set['selfbuy'])) {
						$agents[] = $m;
					}

					if (!empty($m['agentid'])) {
						$m1 = m('member')->getMember($m['agentid']);

						if (!empty($m1)) {
							$agents[] = $m1;
							if (!empty($m1['agentid']) && $m1['isagent'] == 1 && $m1['status'] == 1) {
								$m2 = m('member')->getMember($m1['agentid']);
								if (!empty($m2) && $m2['isagent'] == 1 && $m2['status'] == 1) {
									$agents[] = $m2;

									if (empty($set['selfbuy'])) {
										if (!empty($m2['agentid']) && $m2['isagent'] == 1 && $m2['status'] == 1) {
											$m3 = m('member')->getMember($m2['agentid']);
											if (!empty($m3) && $m3['isagent'] == 1 && $m3['status'] == 1) {
												$agents[] = $m3;
											}
										}
									}
								}
							}
						}
					}

					if (empty($agents)) {
						return NULL;
					}

					foreach ($agents as $agent) {
						$info = $this->getInfo($agent['id'], array('ordercount3', 'ordermoney3', 'order13money', 'order13'));

						if (!empty($info['aagentnotupgrade'])) {
							continue;
						}

						$oldlevel = $this->getLevel($agent['openid']);

						if (empty($oldlevel['id'])) {
							$oldlevel = array('levelname' => empty($set['levelname']) ? '普通代理商' : $set['levelname'], 'bonus' => $set['bonus']);
						}

						if ($leveltype == 0) {
							$ordermoney = $info['ordermoney3'];
							$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid and ' . $ordermoney . ' >= ordermoney and ordermoney>0  order by ordermoney desc limit 1'), array(':uniacid' => $_W['uniacid']));

							if (empty($newlevel)) {
								continue;
							}

							if (!empty($oldlevel['id'])) {
								if ($oldlevel['id'] == $newlevel['id']) {
									continue;
								}

								if ($newlevel['ordermoney'] < $oldlevel['ordermoney']) {
									continue;
								}
							}
						}
						else if ($leveltype == 1) {
							$ordermoney = $info['order13money'];
							$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid and ' . $ordermoney . ' >= ordermoney and ordermoney>0  order by ordermoney desc limit 1'), array(':uniacid' => $_W['uniacid']));

							if (empty($newlevel)) {
								continue;
							}

							if (!empty($oldlevel['id'])) {
								if ($oldlevel['id'] == $newlevel['id']) {
									continue;
								}

								if ($newlevel['ordermoney'] < $oldlevel['ordermoney']) {
									continue;
								}
							}
						}
						else if ($leveltype == 2) {
							$ordercount = $info['ordercount3'];
							$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid  and ' . $ordercount . ' >= ordercount and ordercount>0  order by ordercount desc limit 1'), array(':uniacid' => $_W['uniacid']));

							if (empty($newlevel)) {
								continue;
							}

							if (!empty($oldlevel['id'])) {
								if ($oldlevel['id'] == $newlevel['id']) {
									continue;
								}

								if ($newlevel['ordercount'] < $oldlevel['ordercount']) {
									continue;
								}
							}
						}
						else {
							if ($leveltype == 3) {
								$ordercount = $info['order13'];
								$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid  and ' . $ordercount . ' >= ordercount and ordercount>0  order by ordercount desc limit 1'), array(':uniacid' => $_W['uniacid']));

								if (empty($newlevel)) {
									continue;
								}

								if (!empty($oldlevel['id'])) {
									if ($oldlevel['id'] == $newlevel['id']) {
										continue;
									}

									if ($newlevel['ordercount'] < $oldlevel['ordercount']) {
										continue;
									}
								}
							}
						}

						pdo_update('ewei_shop_member', array('aagentlevel' => $newlevel['id']), array('id' => $agent['id']));
						$this->sendMessage($agent['openid'], array('nickname' => $agent['nickname'], 'oldlevel' => $oldlevel, 'newlevel' => $newlevel), TM_ABONUS_UPGRADE);
					}
				}
			}
		}

		/**
         * 代理商升级(根据下级数)
         * @param type $mid
         */
		public function upgradeLevelByAgent($openid)
		{
			global $_W;

			if (empty($openid)) {
				return false;
			}

			$set = $this->getSet();

			if (empty($set['open'])) {
				return false;
			}

			$m = m('member')->getMember($openid);

			if (empty($m)) {
				return NULL;
			}

			$leveltype = intval($set['leveltype']);
			if ($leveltype < 6 || 9 < $leveltype) {
				return NULL;
			}

			$info = $this->getInfo($m['id'], array());
			if ($leveltype == 6 || $leveltype == 8) {
				$agents = array($m);

				if (!empty($m['agentid'])) {
					$m1 = m('member')->getMember($m['agentid']);

					if (!empty($m1)) {
						$agents[] = $m1;
						if (!empty($m1['agentid']) && $m1['isagent'] == 1 && $m1['status'] == 1) {
							$m2 = m('member')->getMember($m1['agentid']);
							if (!empty($m2) && $m2['isagent'] == 1 && $m2['status'] == 1) {
								$agents[] = $m2;
							}
						}
					}
				}

				if (empty($agents)) {
					return NULL;
				}

				foreach ($agents as $agent) {
					$info = $this->getInfo($agent['id'], array());

					if (!empty($info['aagentnotupgrade'])) {
						continue;
					}

					$oldlevel = $this->getLevel($agent['openid']);

					if (empty($oldlevel['id'])) {
						$oldlevel = array('levelname' => empty($set['levelname']) ? '普通代理商' : $set['levelname'], 'bonus' => $set['bonus']);
					}

					if ($leveltype == 6) {
						$downs1 = pdo_fetchall('select id from ' . tablename('ewei_shop_member') . ' where agentid=:agentid and uniacid=:uniacid ', array(':agentid' => $m['id'], ':uniacid' => $_W['uniacid']), 'id');
						$downcount += count($downs1);

						if (!empty($downs1)) {
							$downs2 = pdo_fetchall('select id from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($downs1)) . ') and uniacid=:uniacid', array(':uniacid' => $_W['uniacid']), 'id');
							$downcount += count($downs2);

							if (!empty($downs2)) {
								$downs3 = pdo_fetchall('select id from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($downs2)) . ') and uniacid=:uniacid', array(':uniacid' => $_W['uniacid']), 'id');
								$downcount += count($downs3);
							}
						}

						$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid  and ' . $downcount . ' >= downcount and downcount>0  order by downcount desc limit 1'), array(':uniacid' => $_W['uniacid']));
					}
					else {
						if ($leveltype == 8) {
							$downcount = $info['level1'] + $info['level2'] + $info['level3'];
							$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid  and ' . $downcount . ' >= downcount and downcount>0  order by downcount desc limit 1'), array(':uniacid' => $_W['uniacid']));
						}
					}

					if (empty($newlevel)) {
						continue;
					}

					if ($newlevel['id'] == $oldlevel['id']) {
						continue;
					}

					if (!empty($oldlevel['id'])) {
						if ($newlevel['downcount'] < $oldlevel['downcount']) {
							continue;
						}
					}

					pdo_update('ewei_shop_member', array('aagentlevel' => $newlevel['id']), array('id' => $agent['id']));
					$this->sendMessage($agent['openid'], array('nickname' => $agent['nickname'], 'oldlevel' => $oldlevel, 'newlevel' => $newlevel), TM_ABONUS_UPGRADE);
				}
			}
			else {
				if (!empty($m['parnternotupgrade'])) {
					return NULL;
				}

				$oldlevel = $this->getLevel($m['openid']);

				if (empty($oldlevel['id'])) {
					$oldlevel = array('levelname' => empty($set['levelname']) ? '普通代理商' : $set['levelname'], 'bonus' => $set['bonus']);
				}

				if ($leveltype == 7) {
					$downcount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid=:agentid and uniacid=:uniacid ', array(':agentid' => $m['id'], ':uniacid' => $_W['uniacid']));
					$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid  and ' . $downcount . ' >= downcount and downcount>0  order by downcount desc limit 1'), array(':uniacid' => $_W['uniacid']));
				}
				else {
					if ($leveltype == 9) {
						$downcount = $info['level1'];
						$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid  and ' . $downcount . ' >= downcount and downcount>0  order by downcount desc limit 1'), array(':uniacid' => $_W['uniacid']));
					}
				}

				if (empty($newlevel)) {
					return NULL;
				}

				if ($newlevel['id'] == $oldlevel['id']) {
					return NULL;
				}

				if (!empty($oldlevel['id'])) {
					if ($newlevel['downcount'] < $oldlevel['downcount']) {
						return NULL;
					}
				}

				pdo_update('ewei_shop_member', array('aagentlevel' => $newlevel['id']), array('id' => $m['id']));
				$this->sendMessage($m['openid'], array('nickname' => $m['nickname'], 'oldlevel' => $oldlevel, 'newlevel' => $newlevel), TM_ABONUS_UPGRADE);
			}
		}

		/**
         * 分销商升级(根据佣金数)
         * @param type $mid
         */
		public function upgradeLevelByCommissionOK($openid)
		{
			global $_W;

			if (empty($openid)) {
				return false;
			}

			$set = $this->getSet();

			if (empty($set['open'])) {
				return false;
			}

			$m = m('member')->getMember($openid);

			if (empty($m)) {
				return NULL;
			}

			$leveltype = intval($set['leveltype']);

			if ($leveltype != 10) {
				return NULL;
			}

			if (!empty($m['aagentnotupgrade'])) {
				return NULL;
			}

			$oldlevel = $this->getLevel($m['openid']);

			if (empty($oldlevel['id'])) {
				$oldlevel = array('levelname' => empty($set['levelname']) ? '普通代理商' : $set['levelname'], 'bonus' => $set['bonus']);
			}

			$info = $this->getInfo($m['id'], array('pay'));
			$commissionmoney = $info['commission_pay'];
			$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid  and ' . $commissionmoney . ' >= commissionmoney and commissionmoney>0  order by commissionmoney desc limit 1'), array(':uniacid' => $_W['uniacid']));

			if (empty($newlevel)) {
				return NULL;
			}

			if ($oldlevel['id'] == $newlevel['id']) {
				return NULL;
			}

			if (!empty($oldlevel['id'])) {
				if ($newlevel['commissionmoney'] < $oldlevel['commissionmoney']) {
					return NULL;
				}
			}

			pdo_update('ewei_shop_member', array('aagentlevel' => $newlevel['id']), array('id' => $m['id']));
			$this->sendMessage($m['openid'], array('nickname' => $m['nickname'], 'oldlevel' => $oldlevel, 'newlevel' => $newlevel), TM_ABONUS_UPGRADE);
		}

		/**
         * 代理商升级(根据分红数)
         * @param type $mid
         */
		public function upgradeLevelByBonus($openid)
		{
			global $_W;

			if (empty($openid)) {
				return false;
			}

			$set = $this->getSet();

			if (empty($set['open'])) {
				return false;
			}

			$m = m('member')->getMember($openid);

			if (empty($m)) {
				return NULL;
			}

			$leveltype = intval($set['leveltype']);

			if ($leveltype != 11) {
				return NULL;
			}

			if (!empty($m['aagentnotupgrade'])) {
				return NULL;
			}

			$oldlevel = $this->getLevel($m['openid']);

			if (empty($oldlevel['id'])) {
				$oldlevel = array('levelname' => empty($set['levelname']) ? '默认等级' : $set['levelname'], 'bonus1' => $set['bonus1'], 'bonus2' => $set['bonus2'], 'bonus3' => $set['bonus3'], 'bonusmoney' => 0);
			}

			$bonusmoney = $this->getBonus($openid, array('ok'));
			$newlevel = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_level') . (' where uniacid=:uniacid  and ' . $bonusmoney['ok'] . ' >= bonusmoney and bonusmoney>0  order by bonusmoney desc limit 1'), array(':uniacid' => $_W['uniacid']));

			if (empty($newlevel)) {
				return NULL;
			}

			if ($oldlevel['id'] == $newlevel['id']) {
				return NULL;
			}

			if (!empty($oldlevel['id'])) {
				if ($newlevel['bonusmoney'] < $oldlevel['bonusmoney']) {
					return NULL;
				}
			}

			pdo_update('ewei_shop_member', array('aagentlevel' => $newlevel['id']), array('id' => $m['id']));
			$member = m('member')->getMember($openid);
			$this->sendMessage($m['openid'], array('nickname' => $m['nickname'], 'aagenttype' => $member['aagenttype'], 'oldlevel' => $oldlevel, 'newlevel' => $newlevel), TM_ABONUS_UPGRADE);
		}

		public function getBonusData($year = 0, $month = 0, $week = 0, $openid = '')
		{
			global $_W;
			$set = $this->getSet();
			$days = get_last_day($year, $month);
			$starttime = strtotime($year . '-' . $month . '-1');
			$endtime = strtotime($year . '-' . $month . '-' . $days);
			$settletimes = intval($set['settledays']) * 86400;
			if (1 <= $week && $week <= 4) {
				$weekdays = array();
				$i = $starttime;

				while ($i <= $endtime) {
					$ds = explode('-', date('Y-m-d', $i));
					$day = intval($ds[2]);
					$w = ceil($day / 7);

					if (4 < $w) {
						$w = 4;
					}

					if ($week == $w) {
						$weekdays[] = $i;
					}

					$i += 86400;
				}

				$starttime = $weekdays[0];
				$endtime = strtotime(date('Y-m-d', $weekdays[count($weekdays) - 1]) . ' 23:59:59');
			}
			else {
				$endtime = strtotime($year . '-' . $month . '-' . $days . ' 23:59:59');
			}

			$bill = pdo_fetch('select * from ' . tablename('ewei_shop_abonus_bill') . ' where uniacid=:uniacid and `year`=:years and `month`=:months and `week`=:week limit 1', array(':uniacid' => $_W['uniacid'], ':years' => $year, ':months' => $month, ':week' => $week));
			if (!empty($bill) && empty($openid)) {
				return array('ordermoney' => round($bill['ordermoney'], 2), 'ordercount' => $bill['ordercount'], 'bonusmoney1' => round($bill['bonusmoney1'], 2), 'bonusmoney_send1' => round($bill['bonusmoney_send1'], 2), 'bonusmoney2' => round($bill['bonusmoney2'], 2), 'bonusmoney_send2' => round($bill['bonusmoney_send2'], 2), 'bonusmoney3' => round($bill['bonusmoney3'], 2), 'bonusmoney_send3' => round($bill['bonusmoney_send3'], 2), 'aagentcount1' => $bill['aagentcount1'], 'aagentcount2' => $bill['aagentcount2'], 'aagentcount3' => $bill['aagentcount3'], 'starttime' => $starttime, 'endtime' => $endtime, 'billid' => $bill['id'], 'old' => true);
			}

			$ordermoney = 0;
			$bonusmoney = 0;
			$orders = pdo_fetchall('select id,openid,price,addressid, address from ' . tablename('ewei_shop_order') . (' where uniacid=' . $_W['uniacid'] . ' and addressid<>0 and status=3 and isabonus=0 and finishtime + ' . $settletimes . '>= ' . $starttime . ' and  finishtime + ' . $settletimes . '<=' . $endtime), array(), 'id');
			$pcondition = '';

			if (!empty($openid)) {
				$pcondition = ' and m.openid=\'' . $openid . '\'';
			}

			$aagents = pdo_fetchall('select m.id,m.openid,m.aagentlevel,m.aagenttype,m.aagentprovinces,m.aagentcitys,m.aagentareas, l.bonus1,l.bonus2,l.bonus3 from ' . tablename('ewei_shop_member') . ' m ' . '  left join ' . tablename('ewei_shop_abonus_level') . ' l on l.id = m.aagentlevel ' . ('  where m.uniacid=:uniacid and  m.isaagent=1 and m.aagentstatus=1 ' . $pcondition), array(':uniacid' => $_W['uniacid']));
			$aagentcount1 = 0;
			$aagentcount2 = 0;
			$aagentcount3 = 0;

			foreach ($aagents as &$a) {
				if (empty($a['aagentlevel']) || $a['bonus1'] == NULL && $a['bonus2'] == NULL && $a['bonus3'] == NULL) {
					$a['bonus1'] = floatval($set['bonus1']);
					$a['bonus2'] = floatval($set['bonus2']);
					$a['bonus3'] = floatval($set['bonus3']);
				}

				$a['aagentprovinces'] = iunserializer($a['aagentprovinces']);
				$a['aagentareas'] = iunserializer($a['aagentareas']);
				$a['aagentcitys'] = iunserializer($a['aagentcitys']);

				if ($a['aagenttype'] == 1) {
					++$aagentcount1;
				}
				else if ($a['aagenttype'] == 2) {
					++$aagentcount2;
				}
				else {
					if ($a['aagenttype'] == 3) {
						++$aagentcount3;
					}
				}

				$a['bonusmoney1'] = 0;
				$a['bonusmoney2'] = 0;
				$a['bonusmoney3'] = 0;
			}

			unset($a);

			foreach ($orders as $o) {
				$ordermoney += $o['price'];

				foreach ($aagents as &$a) {
					if (empty($set['selfbuy'])) {
						if ($a['openid'] == $o['openid']) {
							continue;
						}
					}

					!isset($a['bonusmoney1']) && $a['bonusmoney1'] = 0;
					!isset($a['bonusmoney2']) && $a['bonusmoney2'] = 0;
					!isset($a['bonusmoney3']) && $a['bonusmoney3'] = 0;
					$address = iunserializer($o['address']);

					if (!is_array($address)) {
						$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where id=:id limit 1', array(':id' => $o['addressid']));
					}

					if (empty($address) || !is_array($address)) {
						continue;
					}

					$bonusmoney1 = 0;
					$bonusmoney2 = 0;
					$bonusmoney3 = 0;

					if ($a['aagenttype'] == 1) {
						if (in_array($address['province'], $a['aagentprovinces'])) {
							$bonusmoney1 = round($o['price'] * $a['bonus1'] / 100, 2);
						}

						if (in_array($address['province'] . $address['city'], $a['aagentcitys'])) {
							$bonusmoney2 = round($o['price'] * $a['bonus2'] / 100, 2);
						}

						if (in_array($address['province'] . $address['city'] . $address['area'], $a['aagentareas'])) {
							$bonusmoney3 = round($o['price'] * $a['bonus3'] / 100, 2);
						}
					}
					else if ($a['aagenttype'] == 2) {
						if (in_array($address['province'] . $address['city'], $a['aagentcitys'])) {
							$bonusmoney2 = round($o['price'] * $a['bonus2'] / 100, 2);
						}

						if (in_array($address['province'] . $address['city'] . $address['area'], $a['aagentareas'])) {
							$bonusmoney3 = round($o['price'] * $a['bonus3'] / 100, 2);
						}
					}
					else {
						if ($a['aagenttype'] == 3) {
							if (in_array($address['province'] . $address['city'] . $address['area'], $a['aagentareas'])) {
								$bonusmoney3 = round($o['price'] * $a['bonus3'] / 100, 2);
							}
						}
					}

					$a['bonusmoney1'] += $bonusmoney1;
					$a['bonusmoney2'] += $bonusmoney2;
					$a['bonusmoney3'] += $bonusmoney3;
				}

				unset($a);
			}

			$bonusmoney = 0;
			$bonusmoney1 = 0;
			$bonusmoney2 = 0;
			$bonusmoney3 = 0;

			foreach ($aagents as &$a) {
				$bonusmoney_send = 0;
				$bonusmoney_send1 = 0;
				$bonusmoney_send2 = 0;
				$bonusmoney_send3 = 0;
				$a['charge'] = 0;
				$a['chargemoney'] = 0;
				if (floatval($set['paycharge']) <= 0 || floatval($set['paybegin']) <= $a['bonusmoney1'] + $a['bonusmoney2'] + $a['bonusmoney3'] && $a['bonusmoney'] <= floatval($set['payend'])) {
					$bonusmoney_send1 += round($a['bonusmoney1'], 2);
					$bonusmoney_send2 += round($a['bonusmoney2'], 2);
					$bonusmoney_send3 += round($a['bonusmoney3'], 2);
				}
				else {
					$bonusmoney_send1 += round($a['bonusmoney1'] - $a['bonusmoney1'] * floatval($set['paycharge']) / 100, 2);
					$bonusmoney_send2 += round($a['bonusmoney2'] - $a['bonusmoney2'] * floatval($set['paycharge']) / 100, 2);
					$bonusmoney_send3 += round($a['bonusmoney3'] - $a['bonusmoney3'] * floatval($set['paycharge']) / 100, 2);
					$a['charge'] = floatval($set['paycharge']);
					$a['chargemoney1'] = round($a['bonusmoney1'] * floatval($set['paycharge']) / 100, 2);
					$a['chargemoney2'] = round($a['bonusmoney2'] * floatval($set['paycharge']) / 100, 2);
					$a['chargemoney3'] = round($a['bonusmoney3'] * floatval($set['paycharge']) / 100, 2);
				}

				$a['bonusmoney_send1'] = $bonusmoney_send1;
				$a['bonusmoney_send2'] = $bonusmoney_send2;
				$a['bonusmoney_send3'] = $bonusmoney_send3;
				$bonusmoney1 += $bonusmoney_send1;
				$bonusmoney2 += $bonusmoney_send2;
				$bonusmoney3 += $bonusmoney_send3;
			}

			unset($p);
			return array('orders' => $orders, 'aagents' => $aagents, 'ordermoney' => round($ordermoney, 2), 'ordercount' => count($orders), 'bonusmoney1' => round($bonusmoney1, 2), 'bonusmoney2' => round($bonusmoney2, 2), 'bonusmoney3' => round($bonusmoney3, 2), 'aagentcount1' => $aagentcount1, 'aagentcount2' => $aagentcount2, 'aagentcount3' => $aagentcount3, 'starttime' => $starttime, 'endtime' => $endtime, 'old' => false);
		}

		public function getTotals()
		{
			global $_W;
			return array('total0' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_abonus_bill') . ' where uniacid=:uniacid and status=0 limit 1', array(':uniacid' => $_W['uniacid'])), 'total1' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_abonus_bill') . ' where uniacid=:uniacid and status=1 limit 1', array(':uniacid' => $_W['uniacid'])), 'total2' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_abonus_bill') . ' where uniacid=:uniacid and status=2  limit 1', array(':uniacid' => $_W['uniacid'])));
		}
	}
}

?>
