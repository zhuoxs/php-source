<?php
global $_W,$_GPC;
session_start();
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$fan = mc_oauth_userinfo();

if ($op=="display") {
    $user = pdo_get($this->table_user, array('openid'=>$fan['openid'],'uniacid'=>$_W['uniacid'],'recycle'=>0));
    if (!empty($user)) {
        $url = $this->createMobileUrl("home");
        Header("Location:".$url); 
        die;
    }

}elseif ($op=="post") {
    $realname = trim($_GPC['realname']);
    $par = array('uniacid'=>$_W['uniacid'],'recycle'=>0,'realname'=>$realname);

    $mobile = trim($_GPC['mobile']);
	if ($param['loginmobile']==1) {
        $par['mobile'] = $mobile;
    }elseif ($param['loginmobile']==2) {
        if ($_SESSION["mobilecode".$mobile] != trim($_GPC['code'])) {
            message("验证码不正确！", referer(), 'error');
        }
        $par['mobile'] = $mobile;
    }

    $idnumber = strtoupper(trim($_GPC['idnumber']));
    if ($param['loginidnumber']==1) {
        $idnumber = strtoupper(trim($_GPC['idnumber']));
        $par['idnumber'] = $idnumber;
    }

    if (empty($mobile) && empty($idnumber)) {
        message("绑定登录时，手机号和身份证号不能同时为空！", referer(), 'error');
    }
	
	$user = pdo_get($this->table_user, $par);
	if (empty($user)) {
		message("该姓名、身份证号和手机号对应的党员信息不存在！", $this->createMobileUrl("login"), 'error');
	}
	if (!empty($user['openid'])) {
		message("该姓名手机号已绑定过昵称为[".$user['nickname']."]的个人微信号，请先解除绑定！", referer(), 'error');
	}
	$data = array(
		'openid'     => $fan['openid'],
        'nickname'   => $fan['nickname'],
        'headimgurl' => $fan['headimgurl'],
		);
	if (empty($user['headpic'])) {
		$data['headpic'] = $fan['headimgurl'];
	}
	pdo_update($this->table_user, $data, array('id'=>$user['id']));
	message("绑定微信登录成功！", $this->createMobileUrl("home"), 'success');

}elseif ($op == 'getmobilecode') {
	
    $ret = array('ret'=>'error', 'msg'=>'error'); 
    $mobile = trim($_GPC['mobile']);
    $code = random(4, true);
    $_SESSION["mobilecode".$mobile] = $code;
    $content = '您的短信验证码为:'.$code.' 您正在使用'.$_W['account']['name'].'相关功能, 需要你进行身份确认';
    load()->model('cloud');
    $result = cloud_sms_send($mobile, $content); 
    if (is_error($result)) {
        $ret['msg'] = '短信验证码发送失败，错误：'.$result['message']; // 短信发送错误返回错误码和错误信息
    } else {
        $ret['msg'] = 'success';
        $ret['ret'] = 'success';
    }
    exit(json_encode($ret));

}elseif ($op=="untie") {
    $user = pdo_get($this->table_user, array('openid'=>$fan['openid'],'uniacid'=>$_W['uniacid'],'recycle'=>0));
    if (empty($user)) {
        message("解绑用户信息不存在，请重试！", referer(), 'error');
    }
    $data = array(
        'openid'     => "",
        'nickname'   => "",
        'headimgurl' => ""
        );
    pdo_update($this->table_user, $data, array('id'=>$user['id']));
    message("成功解绑当前微信号！", $this->createMobileUrl("home"), 'success');
}


	
include $this->template('login');
?>