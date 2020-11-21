<?php
global $_W,$_GPC;
$dluid=$_GPC['dluid'];//share id
		$receiver = trim($_GPC['mobile']);
		if($receiver == ''){
			//exit('请输入手机号');
            die(json_encode(array('success'=>false,'info'=>"请输入手机号")));
		//} elseif(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/", $receiver)){
        } elseif(preg_match("/(^1[3|4|5|7|8][0-9]{9}$)/", $receiver)){
			$receiver_type = 'mobile';
		} else {
			//exit('您输入的手机号格式错误');
            die(json_encode(array('success'=>false,'info'=>"您输入的手机号格式错误")));
		}
		$sql = 'DELETE FROM ' . tablename('uni_verifycode') . ' WHERE `createtime`<' . (TIMESTAMP - 1800);
		pdo_query($sql);

		$sql = 'SELECT * FROM ' . tablename('uni_verifycode') . ' WHERE `receiver`=:receiver AND `uniacid`=:uniacid';
		$pars = array();
		$pars[':receiver'] = $receiver;
		$pars[':uniacid'] = $_W['uniacid'];
		$row = pdo_fetch($sql, $pars);
		$record = array();
		if(!empty($row)) {
			if($row['total'] >= 3) {
				//exit('您的操作过于频繁,请稍后再试');
                die(json_encode(array('success'=>false,'info'=>"您的操作过于频繁,请稍后再试")));
			}
			$code = $row['verifycode'];
			$record['total'] = $row['total'] + 1;
		} else {
			$code = random(6, true); 
			$record['uniacid'] = $_W['uniacid'];
			$record['receiver'] = $receiver;
			$record['verifycode'] = $code;
			$record['total'] = 1;
			$record['createtime'] = TIMESTAMP;
		}
		if(!empty($row)) {
			pdo_update('uni_verifycode', $record, array('id' => $row['id']));
		} else {
			pdo_insert('uni_verifycode', $record);
		}
		$config = $this->module['config'];
		if ($config['smstype'] == 'dayu') {
			$content = json_encode(array('code'=>$code,'product'=>$_W['account']['name']));
		}else{
			//$content = "【{$_W['account']['name']}】您的注册短信验证码是{$code} ，有效期10分钟。如非本人操作，请忽略本短信。";
            $content=urlencode("#code#={$code}");
		}
		$result = $this->SendSMS($receiver, $content);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($result),FILE_APPEND);
		if ($result == 0) {
			//$this->recode_count();
			die(json_encode(array('success'=>true,'info'=>"短信发送成功")));
		}else{
			//exit("短信接口故障，请稍后再试！错误信息:".$result);
            die(json_encode(array('success'=>false,'info'=>"短信接口故障，请稍后再试！错误信息:".$result)));
		}