<?php
if (!(defined('IN_IA'))) 
{
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
		if (empty($openid)) 
		{
			return;
		}
		$member = m('member')->getMember($openid);
		if (empty($member)) 
		{
			return;
		}
		$poster = pdo_fetch('select * from ' . tablename('ewei_shop_task_poster') . ' where keyword=:keyword and uniacid=:uniacid and `status`=1 and `is_delete`=0 limit 1', array(':keyword' => $content, ':uniacid' => $_W['uniacid']));
		if (empty($poster)) 
		{
			m('message')->sendCustomNotice($openid, '未找到海报!');
			return;
		}
		$time = time();
		if ($time < $poster['timestart']) 
		{
			$starttext = ((empty($poster['starttext']) ? '活动于 [任务开始时间] 开始，请耐心等待...' : $poster['starttext']));
			$starttext = str_replace('[任务开始时间]', date('Y年m月d日 H:i', $poster['timestart']), $starttext);
			$starttext = str_replace('[任务结束时间]', date('Y年m月d日 H:i', $poster['timeend']), $starttext);
			m('message')->sendCustomNotice($openid, $starttext);
			return;
		}
		if ($poster['timeend'] < time()) 
		{
			$endtext = ((empty($poster['endtext']) ? '活动已结束，谢谢您的关注！' : $poster['endtext']));
			$endtext = str_replace('[任务开始时间]', date('Y-m-d H:i', $poster['timestart']), $endtext);
			$endtext = str_replace('[任务结束时间]', date('Y-m-d- H:i', $poster['timeend']), $endtext);
			m('message')->sendCustomNotice($openid, $endtext);
			return;
		}
		$img = '';
		$is_waiting = false;
		$task_count = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_type=' . $poster['poster_type'] . ' and is_reward=0 and failtime>' . time(), array(':uniacid' => $_W['uniacid'], ':join_user' => $member['openid']));
		if ($task_count) 
		{
			$task_info = pdo_fetch('select `needcount`,`completecount`,`is_reward`,`failtime` from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_id=:task_id and task_type=:task_type and  failtime>' . time() . ' order by `addtime` DESC limit 1', array(':uniacid' => $_W['uniacid'], ':join_user' => $member['openid'], ':task_id' => $poster['id'], ':task_type' => $poster['poster_type']));
			if ($task_info) 
			{
				$is_waiting = true;
				if ($task_info['is_reward'] == 0) 
				{
					$img = $this->create_poster($poster, $member);
				}
				else if ($task_info['is_reward'] == 1) 
				{
					if ($poster['is_repeat']) 
					{
						$img = $this->join_task($member, $poster);
					}
					else 
					{
						$img = $this->create_poster($poster, $member);
					}
				}
			}
			else 
			{
				m('message')->sendCustomNotice($openid, '您已经有同类型的任务正在进行，不能同时参加');
				return;
			}
		}
		else 
		{
			if ($poster['poster_type'] == 1) 
			{
				$poster_type = 2;
			}
			else if ($poster['poster_type'] == 2) 
			{
				$poster_type = 1;
			}
			$other_task_count = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_type=' . $poster_type . ' and failtime>' . time(), array(':uniacid' => $_W['uniacid'], ':join_user' => $member['openid']));
			if ($other_task_count) 
			{
				$default = pdo_fetchcolumn('select `data` from ' . tablename('ewei_shop_task_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
				if ($default) 
				{
					$default = unserialize($default);
					if ($default['is_posterall'] == 1) 
					{
						$end_task_count = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_type=' . $poster['poster_type'] . ' and failtime<' . time(), array(':uniacid' => $_W['uniacid'], ':join_user' => $member['openid']));
						if ($end_task_count) 
						{
							$end_task_info = pdo_fetch('select `needcount`,`completecount`,`failtime` from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_id=:task_id and task_type=:task_type and failtime<' . time() . ' order by `addtime` DESC limit 1', array(':uniacid' => $_W['uniacid'], ':join_user' => $member['openid'], ':task_id' => $poster['id'], ':task_type' => $poster['poster_type']));
							if ($end_task_info) 
							{
								if ($poster['is_repeat']) 
								{
									$is_waiting = true;
									$img = $this->join_task($member, $poster);
								}
								else 
								{
									m('message')->sendCustomNotice($openid, '您已经参加过此任务，不能重复参加');
									return;
								}
							}
							else 
							{
								$is_waiting = true;
								$img = $this->join_task($member, $poster);
							}
						}
						else 
						{
							$is_waiting = true;
							$img = $this->join_task($member, $poster);
						}
					}
					else if ($default['is_posterall'] == 0) 
					{
						m('message')->sendCustomNotice($openid, '您已经有另外类型的海报任务正在进行，不能同时参加');
						return;
						m('message')->sendCustomNotice($openid, '您已经有另外类型的海报任务正在进行，不能同时参加');
						return;
						$end_task_count = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_type=' . $poster['poster_type'] . ' and (is_reward=1 or failtime<' . time() . ')', array(':uniacid' => $_W['uniacid'], ':join_user' => $member['openid']));
						if ($end_task_count) 
						{
							$end_task_info = pdo_fetch('select `needcount`,`completecount`,`failtime` from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_id=:task_id and task_type=:task_type and (is_reward=1 or failtime<' . time() . ') order by `addtime` DESC limit 1', array(':uniacid' => $_W['uniacid'], ':join_user' => $member['openid'], ':task_id' => $poster['id'], ':task_type' => $poster['poster_type']));
							if ($end_task_info) 
							{
								if ($poster['is_repeat']) 
								{
									$is_waiting = true;
									$img = $this->join_task($member, $poster);
								}
								else 
								{
									m('message')->sendCustomNotice($openid, '您已经参加过此任务，不能重复参加');
									return;
								}
							}
							else 
							{
								$is_waiting = true;
								$img = $this->join_task($member, $poster);
							}
						}
						else 
						{
							$is_waiting = true;
							$img = $this->join_task($member, $poster);
						}
					}
				}
				else 
				{
					m('message')->sendCustomNotice($openid, '您已经有另外类型的海报任务正在进行，不能同时参加');
					return;
				}
			}
			else 
			{
				$end_task_count = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_type=' . $poster['poster_type'] . ' and (is_reward=1 or failtime<' . time() . ')', array(':uniacid' => $_W['uniacid'], ':join_user' => $member['openid']));
				$end_task_info = pdo_fetch('select `needcount`,`completecount`,`failtime` from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and join_user=:join_user and task_id=:task_id and task_type=:task_type and (is_reward=1 or failtime<' . time() . ') order by `addtime` DESC limit 1', array(':uniacid' => $_W['uniacid'], ':join_user' => $member['openid'], ':task_id' => $poster['id'], ':task_type' => $poster['poster_type']));
				$is_waiting = true;
				$img = $this->join_task($member, $poster);
				m('message')->sendCustomNotice($openid, '您已经参加过此任务，不能重复参加');
				return;
				$is_waiting = true;
				$img = $this->join_task($member, $poster);
				$is_waiting = true;
				$img = $this->join_task($member, $poster);
			}
		}
		if ($is_waiting) 
		{
			$waittext = ((!(empty($poster['waittext'])) ? htmlspecialchars_decode($poster['waittext'], ENT_QUOTES) : '您的专属海报正在拼命生成中，请等待片刻...'));
			$waittext = str_replace('[任务开始时间]', date('Y年m月d日 H:i', $poster['timestart']), $waittext);
			$waittext = str_replace('[任务结束时间]', date('Y年m月d日 H:i', $poster['timeend']), $waittext);
			m('message')->sendCustomNotice($openid, $waittext);
		}
		$mediaid = $img['mediaid'];
		if (!(empty($mediaid))) 
		{
			$task_complain = '亲爱的[任务执行者昵称]，恭喜您成功领取[任务名称]!' . "\r\n" . '下面是您的专属任务海报,好友扫描海报后即可提升您的人气值。' . "\r\n" . '人气值达到[任务目标]即可解锁任务奖励。' . "\r\n" . '[关注奖励列表]' . "\r\n" . '当前海报有效期至：[海报有效期]';
			$default = pdo_fetchcolumn('select `data` from ' . tablename('ewei_shop_task_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
			if ($default) 
			{
				$default = unserialize($default);
				$task_complain = $default['getposter']['value'];
			}
			if ($poster['getposter']) 
			{
				$task_complain = $poster['getposter'];
			}
			$poster['okdays'] = time() + $poster['days'];
			$poster['completecount'] = 0;
			$task_complain = $this->model->notice_complain($task_complain, $member, $poster, '', 2);
			$task_complain = htmlspecialchars_decode($task_complain, ENT_QUOTES);
			m('message')->sendCustomNotice($openid, $task_complain);
			m('message')->sendImage($openid, $mediaid);
		}
		else 
		{
			$task_complain = '亲爱的[任务执行者昵称]，恭喜您成功领取[任务名称]!' . "\r\n" . '下面是您的专属任务海报,好友扫描海报后即可提升您的人气值。' . "\r\n" . '人气值达到[任务目标]即可解锁任务奖励。' . "\r\n" . '[关注奖励列表]' . "\r\n" . '当前海报有效期至：[海报有效期]';
			$default = pdo_fetchcolumn('select `data` from ' . tablename('ewei_shop_task_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
			if ($default) 
			{
				$default = unserialize($default);
				$task_complain = $default['getposter']['value'];
			}
			$poster['okdays'] = time() + $poster['days'];
			$poster['completecount'] = 0;
			$task_complain = $this->model->notice_complain($task_complain, $member, $poster, '', 2);
			$task_complain = htmlspecialchars_decode($task_complain, ENT_QUOTES);
			m('message')->sendCustomNotice($openid, $task_complain);
			$oktext = '<a href=\'' . $img['img'] . '\'>点击查看您的专属海报</a>';
			m('message')->sendCustomNotice($openid, $oktext);
		}
	}
	private function join_task($member, $poster) 
	{
		global $_W;
		$time = time();
		$rec_reward = unserialize($poster['reward_data']);
		$rec_reward = $rec_reward['rec'];
		$rec_reward = serialize($rec_reward);
		$task_join = array('uniacid' => $_W['uniacid'], 'join_user' => $member['openid'], 'task_id' => $poster['id'], 'task_type' => 1, 'needcount' => $poster['needcount'], 'failtime' => $time + $poster['days'], 'addtime' => $time);
		if ($poster['poster_type'] == 2) 
		{
			$task_join['task_type'] = 2;
			$task_join['reward_data'] = $rec_reward;
		}
		pdo_insert('ewei_shop_task_join', $task_join);
		$id = pdo_insertid();
		$img = '';
		if ($id) 
		{
			$qr = $this->model->getQR($poster, $member);
			if (is_error($qr)) 
			{
				m('message')->sendCustomNotice($member['openid'], '生成二维码出错: ' . $qr['message']);
				exit();
			}
			$img = $this->model->createPoster($poster, $member, $qr);
		}
		if ($img) 
		{
			return $img;
		}
		return false;
	}
	private function create_poster($poster, $member) 
	{
		$qr = $this->model->getQR($poster, $member);
		if (is_error($qr)) 
		{
			m('message')->sendCustomNotice($member['openid'], '生成二维码出错: ' . $qr['message']);
			exit();
		}
		$img = $this->model->createPoster($poster, $member, $qr);
		if ($img) 
		{
			return $img;
		}
		return false;
	}
	public function reward() 
	{
		global $_W;
		global $_GPC;
		$member_info = $_GPC['member_info'];
		$poster = $_GPC['poster'];
		$join_info = $_GPC['join_info'];
		$qr = $_GPC['qr'];
		$openid = $_GPC['openid'];
		$qrmember = $_GPC['qrmember'];
		$poster['reward_data'] = htmlspecialchars_decode($poster['reward_data']);
		if ($join_info['task_type'] == 1) 
		{
			$this->model->reward($member_info, $poster, $join_info, $qr, $openid, $qrmember);
		}
		else if ($join_info['task_type'] == 2) 
		{
			$this->model->rankreward($member_info, $poster, $join_info, $qr, $openid, $qrmember);
		}
		return true;
	}
}
?>