<?php
global $_W, $_GPC;



     $cfg=$this->module['config'];
     $fans = mc_oauth_userinfo();
     $mc=mc_fetch($fans['openid']);
     //$member = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
     $fans=$this->getmember($fans,$mc['uid']);
     include $this->template ( 'user/tx' );
     ?>