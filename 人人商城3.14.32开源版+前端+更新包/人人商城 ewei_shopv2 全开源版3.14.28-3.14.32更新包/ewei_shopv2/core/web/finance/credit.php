<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Credit_EweiShopV2Page extends WebPage
{
	protected function main($type = 'credit1')
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and log.uniacid=:uniacid and (log.module=:module1  or log.module=:module2) and log.credittype=:credittype';
		$condition1 = ' and log.uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid'], ':module1' => 'ewei_shopv2', ':module2' => 'ewei_shop', ':credittype' => $type);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and (m.realname like :keyword or m.nickname like :keyword or m.mobile like :keyword or u.username like :keyword)';
			$condition1 .= ' and (m.realname like :keyword or m.nickname like :keyword or m.mobile like :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND log.createtime >= :starttime AND log.createtime <= :endtime ';
			$condition1 .= ' AND log.createtime >= :starttime AND log.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		if (!empty($_GPC['level'])) {
			$condition .= ' and m.level=' . intval($_GPC['level']);
			$condition1 .= ' and m.level=' . intval($_GPC['level']);
		}

		if (!empty($_GPC['groupid'])) {
			$condition .= ' and m.groupid=' . intval($_GPC['groupid']);
			$condition1 .= ' and m.groupid=' . intval($_GPC['groupid']);
		}

		$search_flag = 0;
		if ($_GPC['groupid'] || $_GPC['level'] || $_GPC['keyword']) {
			$search_flag = 1;

			if ($type == 'credit1') {
				$table2 = 'select log.id,log.num,log.presentcredit,log.createtime,log.remark,log.credittype,m.id as mid,m.openid, m.realname,m.nickname,m.avatar, m.mobile, m.weixin,u.username,g.groupname,l.levelname  from ' . tablename('ewei_shop_member_credit_record') . ' log ' . ' left join ' . tablename('users') . ' u on  log.operator=u.uid and log.operator<>0 and log.operator<>log.uid' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=log.openid' . ' left join ' . tablename('ewei_shop_member_group') . ' g on m.groupid=g.id' . ' left join ' . tablename('ewei_shop_member_level') . ' l on m.level =l.id' . (' where 1 ' . $condition . ' and log.uid=0');
				$sql = 'select * from (' . $table2 . ') as main order by createtime desc';
			}
			else {
				if ($type == 'credit2') {
					$table2 = 'select log.id,log.num,log.presentcredit,log.createtime,log.remark,log.credittype,m.id as mid,m.openid, m.realname,m.nickname,m.avatar, m.mobile, m.weixin,u.username,g.groupname,l.levelname  from ' . tablename('ewei_shop_member_credit_record') . ' log ' . ' left join ' . tablename('users') . ' u on  log.operator=u.uid and log.operator<>0 and log.operator<>log.uid' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=log.openid' . ' left join ' . tablename('ewei_shop_member_group') . ' g on m.groupid=g.id' . ' left join ' . tablename('ewei_shop_member_level') . ' l on m.level =l.id' . (' where 1 ' . $condition . ' and log.uid=0');
					$sql = 'select * from (' . $table2 . ') as main order by createtime desc';
				}
			}
		}
		else {
			$table2 = 'select log.id,log.num,log.presentcredit,log.createtime,log.remark,log.credittype,u.username,\'0\' as uid,log.openid  from ' . tablename('ewei_shop_member_credit_record') . ' log ' . ' left join ' . tablename('users') . ' u on  log.operator=u.uid and log.operator<>0 and log.operator<>log.uid' . (' where 1 ' . $condition . ' and log.uid=0');
			$sql = 'select log.id,log.num,log.presentcredit,log.createtime,log.remark,log.credittype,u.username,\'0\' as uid,log.openid  from ' . tablename('ewei_shop_member_credit_record') . ' log ' . ' left join ' . tablename('users') . ' u on  log.operator=u.uid and log.operator<>0 and log.operator<>log.uid' . (' where 1 ' . $condition . ' order by log.createtime desc');
		}

		if (empty($_GPC['export'])) {
			$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}
		else {
			ini_set('memory_limit', '-1');
		}

		$list = pdo_fetchall($sql, $params);
		if ($list && $search_flag == 0) {
			foreach ($list as $key => $val) {
				$member = array();

				if ($val['uid']) {
					$member = pdo_fetch('select * from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid and uid=:uid', array(':uniacid' => $_W['uniacid'], ':uid' => $val['uid']));
				}
				else {
					$member = pdo_fetch('select * from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid and openid=:openid', array(':uniacid' => $_W['uniacid'], ':openid' => $val['openid']));
				}

				$groupname = pdo_fetchcolumn('select groupname from ' . tablename('ewei_shop_member_group') . ' where uniacid=:uniacid and id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $member['groupid']));
				$levelname = pdo_fetchcolumn('select levelname from ' . tablename('ewei_shop_member_level') . ' where uniacid=:uniacid and id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $member['level']));
				$list[$key]['groupname'] = $groupname;
				$list[$key]['levelname'] = $levelname;
				$list[$key]['mid'] = $member['id'];
				$list[$key]['openid'] = $member['openid'];
				$list[$key]['realname'] = $member['realname'];
				$list[$key]['nickname'] = $member['nickname'];
				$list[$key]['avatar'] = $member['avatar'];
				$list[$key]['mobile'] = $member['mobile'];
				$list[$key]['weixin'] = $member['weixin'];
			}
		}

		if ($_GPC['export'] == 1) {
			if ($_GPC['type'] == 1) {
				plog('finance.credit.credit1.export', '导出积分明细');
			}
			else {
				plog('finance.credit.credit2.export', '导出余额明细');
			}

			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['groupname'] = empty($row['groupname']) ? '无分组' : $row['groupname'];
				$row['levelname'] = empty($row['levelname']) ? '普通会员' : $row['levelname'];
				$row['realname'] = str_replace('=', '', $row['realname']);
				$row['nickname'] = str_replace('=', '', $row['nickname']);

				if ($row['credittype'] == 'credit1') {
					$row['credittype'] = '积分';
				}
				else {
					if ($row['credittype'] == 'credit2') {
						$row['credittype'] = '余额';
					}
				}

				if (empty($row['username'])) {
					$row['username'] = '本人';
				}
			}

			unset($row);
			$columns = array();
			$columns[] = array('title' => '类型', 'field' => 'credittype', 'width' => 12);
			$columns[] = array('title' => '昵称', 'field' => 'nickname', 'width' => 12);
			$columns[] = array('title' => '姓名', 'field' => 'realname', 'width' => 12);
			$columns[] = array('title' => '手机号', 'field' => 'mobile', 'width' => 12);
			$columns[] = array('title' => '会员等级', 'field' => 'levelname', 'width' => 12);
			$columns[] = array('title' => '会员分组', 'field' => 'groupname', 'width' => 12);
			$columns[] = array('title' => $type == 'credit1' ? '积分变化' : '余额变化', 'field' => 'num', 'width' => 12);
			$columns[] = array('title' => '时间', 'field' => 'createtime', 'width' => 12);
			$columns[] = array('title' => '备注', 'field' => 'remark', 'width' => 24);
			$columns[] = array('title' => '操作人', 'field' => 'username', 'width' => 12);
			m('excel')->export($list, array('title' => ($type == 'credit1' ? '会员积分明细-' : '会员余额明细') . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}

		if ($type == 'credit1') {
			$allcount = pdo_fetch('select count(*) as ccc from (' . $table2 . ') as main order by createtime desc limit 1', $params);
			$total = $allcount['ccc'];
		}
		else {
			if ($type == 'credit2') {
				$allcount = pdo_fetch('select count(*) as ccc from (' . $table2 . ') as main order by createtime desc limit 1', $params);

				if (empty($search_flag)) {
					$total_sql = 'select count(*) as ccc  from ' . tablename('ewei_shop_member_credit_record') . ' log ' . ' left join ' . tablename('users') . ' u on  log.operator=u.uid and log.operator<>0 and log.operator<>log.uid' . (' where 1 ' . $condition);
					$allcount = pdo_fetch($total_sql, $params);
				}

				$total = $allcount['ccc'];
			}
		}

		$pager = pagination2($total, $pindex, $psize);
		$groups = m('member')->getGroups();
		$levels = m('member')->getLevels();
		include $this->template('finance/credit');
	}

	public function credit1()
	{
		$this->main('credit1');
	}

	public function credit2()
	{
		$this->main('credit2');
	}
}

?>
