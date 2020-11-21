<?php

if (!defined('ES_PATH')) {
	exit('Access Denied');
}

class RegisterController extends Controller
{
	public function index()
	{
		global $_W;
		global $_GPC;
		$setting = $_W['setting'];

		if (empty($setting['register']['open'])) {
			header('location: ' . './');
			exit();
		}

		$basicset = $this->basicset();
		$title = '注册帐户';
		include $this->template('register/index');
	}

	public function check()
	{
		global $_W;
		global $_GPC;
		$setting = $_W['setting'];
		$data['content'] = array('username' => trim($_GPC['username']), 'password' => trim($_GPC['password']), 'nickname' => trim($_GPC['nickname']), 'realname' => trim($_GPC['realname']), 'qq' => intval($_GPC['qq']));

		if (!preg_match(REGULAR_USERNAME, $data['content']['username'])) {
			$data['msg'] = '必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。';
			$data['name'] = 'username';
			echo json_encode($data);
			exit();
		}

		load()->model('user');

		if (user_check(array('username' => $data['content']['username']))) {
			$data['msg'] = '非常抱歉，此用户名已经被注册，你需要更换注册名称！';
			$data['name'] = 'username';
			echo json_encode($data);
			exit();
		}

		if (istrlen($data['content']['password']) < 8) {
			$data['msg'] = '必须输入密码，且密码长度不得低于8位。';
			$data['name'] = 'password';
			echo json_encode($data);
			exit();
		}

		$member['username'] = $_GPC['username'];
		$member['password'] = $_GPC['password'];
		$member['status'] = !empty($setting['register']['verify']) ? 1 : 2;
		$member['remark'] = '';
		$member['groupid'] = intval($setting['register']['groupid']);

		if (empty($member['groupid'])) {
			$member['groupid'] = pdo_fetchcolumn('SELECT id FROM ' . tablename('users_group') . ' ORDER BY id ASC LIMIT 1');
			$member['groupid'] = intval($member['groupid']);
		}

		$group = pdo_fetch('SELECT * FROM ' . tablename('users_group') . ' WHERE id = :id', array(':id' => $member['groupid']));
		$timelimit = intval($group['timelimit']);
		$timeadd = 0;

		if (0 < $timelimit) {
			$timeadd = strtotime($timelimit . ' days');
		}

		$member['starttime'] = TIMESTAMP;
		$member['endtime'] = $timeadd;
		$uid = user_register($member);
		$profile = array();

		if (0 < $uid) {
			unset($member['password']);
			$member['uid'] = $uid;

			if (!empty($profile)) {
				$profile['uid'] = $uid;
				$profile['createtime'] = TIMESTAMP;
				pdo_insert('users_profile', $profile);
			}

			pdo_update('users_invitation', array('inviteuid' => $uid), array('id' => $invite['id']));
			$data['msg'] = '注册成功' . (!empty($setting['register']['verify']) ? '，請等待管理员审核！' : '，请重新登录！');
			$data['name'] = 'success';
		}

		$data['msg'] = 'true';
		echo json_encode($data);
	}

	public function register()
	{
		global $_W;
		global $_GPC;
		$setting = $_W['setting'];

		if (empty($setting['register']['open'])) {
			$this->message('本站暂未开启注册功能，请联系管理员！');
		}

		load()->model('user');
		$member = array();
		$member['username'] = trim($_GPC['username']);

		if (!preg_match(REGULAR_USERNAME, $member['username'])) {
			$this->message('必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
		}

		if (user_check(array('username' => $member['username']))) {
			$this->message('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
		}

		$member['password'] = $_GPC['password'];

		if (istrlen($member['password']) < 8) {
			$this->message('必须输入密码，且密码长度不得低于8位。');
		}

		$member['nickname'] = $_GPC['nickname'];
		$member['realname'] = $_GPC['realname'];
		$member['qq'] = $_GPC['qq'];
		$member['status'] = !empty($setting['register']['verify']) ? 1 : 2;
		$member['remark'] = '';
		$member['groupid'] = intval($setting['register']['groupid']);

		if (empty($member['groupid'])) {
			$member['groupid'] = pdo_fetchcolumn('SELECT id FROM ' . tablename('users_group') . ' ORDER BY id ASC LIMIT 1');
			$member['groupid'] = intval($member['groupid']);
		}

		$group = pdo_fetch('SELECT * FROM ' . tablename('users_group') . ' WHERE id = :id', array(':id' => $member['groupid']));
		$timelimit = intval($group['timelimit']);
		$timeadd = 0;

		if (0 < $timelimit) {
			$timeadd = strtotime($timelimit . ' days');
		}

		$member['starttime'] = TIMESTAMP;
		$member['endtime'] = $timeadd;
		$uid = user_register($member);
		$profile = array();

		if (0 < $uid) {
			unset($member['password']);
			$member['uid'] = $uid;

			if (!empty($profile)) {
				$profile['uid'] = $uid;
				$profile['createtime'] = TIMESTAMP;
				pdo_insert('users_profile', $profile);
			}

			pdo_update('users_invitation', array('inviteuid' => $uid), array('id' => $invite['id']));
			$this->message('注册成功' . (!empty($setting['register']['verify']) ? '，請等待管理员审核！' : '，请重新登录！'), url('register/login'));
		}

		$this->message('增加用户失败，请稍候重试或联系网站管理员解决！');
	}
}

?>
