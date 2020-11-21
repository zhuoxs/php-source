<?php
global $_W, $_GPC;
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		if (!strpos($userAgent, 'MicroMessenger')) {
			message('请使用微信浏览器打开！');
		}else{
			load()->model('mc');
			//$info = mc_oauth_userinfo();
			$fans = $_W['fans'];
			//$mc = mc_fetch($fans['uid'],array('nickname','avatar'));
			$fans['avatar'] = $fans['tag']['avatar'];
			$fans['nickname'] =$fans['tag']['nickname'];
		}
        
		$pid = $_GPC['pid'];
        $weid = $_GPC['i'];
		$poster = pdo_fetch ( 'select * from ' . tablename ( $this->modulename . "_poster" ) . " where weid='{$weid}'" );
 
		$credit = 0;
		$creditname = '积分';
		$credittype = 'credit2';
		if ($poster['credit']){
			$creditname = '余额';
			$credittype = 'credit2';
		}
		if ($fans){
			$mc = mc_credit_fetch($fans['uid'],array($credittype));
			$credit = $mc[$credittype];
		}
		$fans1 = pdo_fetchall("select s.openid from ".tablename($this->modulename."_share")." s left join ".tablename('mc_mapping_fans')." f on s.openid=f.uid where s.weid='{$weid}' and s.helpid='{$fans['uid']}' and f.follow=1 and s.openid<>''",array(),'openid');
        if ($fans1){
			$count2 = pdo_fetchcolumn("select count(*) from ".tablename($this->modulename."_share")." s  join ".tablename('mc_mapping_fans')." f on s.openid=f.uid where s.weid='{$weid}' and s.helpid in (".implode(',',array_keys($fans1)).") and f.follow=1");
		}    
        if (empty($count2)){ $count2 = 0;}
		$count = count($fans1);
        $sumcount=$count;
		$cfg=$this->module['config']; 
		$records = pdo_fetchall('select * from '.tablename('mc_credits_record')." where uid='{$fans['uid']}' and credittype='credit2' order by createtime desc limit 20");
        $mbstyle='style2';
		include $this->template ('tixian/txrecords' );