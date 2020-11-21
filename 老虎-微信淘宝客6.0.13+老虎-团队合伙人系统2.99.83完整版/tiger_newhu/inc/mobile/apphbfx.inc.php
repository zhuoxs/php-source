<?php
		global $_W, $_GPC;
		$cfg=$this->module['config'];
		$hid=$_GPC['hid'];//上级UID
		$yq=$_GPC['yq'];//上级UID
		
		
		$fans = mc_oauth_userinfo();
		$mc=mc_fetch($fans['openid']);
		$member=$this->getmember($fans,$mc['uid'],$hid,1);
		include $this -> template('user/apphbfx');
