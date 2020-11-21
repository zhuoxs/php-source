<?php
 global $_W, $_GPC;
 $dluid=$_GPC['dluid'];//share id
       $cfg = $this->module['config'];

//       $fans=$_W['fans'];
//       if(empty($fans['openid'])){
//         echo '请从微信浏览器中打开！';
//         exit;
//       }
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	echo "请在微信端打开!";
	        	exit;
	        }	        
        }


        $pindex = max(1, intval($_GPC['page']));
	    $psize = 10;
	    $list = pdo_fetchall("select * from ".tablename($this->modulename."_sdorder")." where weid='{$_W['uniacid']}' and openid='{$fans['openid']}' order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_sdorder')." where weid='{$_W['uniacid']}' ");
		$pager = pagination($total, $pindex, $psize);

        //var_dump($list);
        //exit;
        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
       


       include $this->template ( 'user/sdmy' );