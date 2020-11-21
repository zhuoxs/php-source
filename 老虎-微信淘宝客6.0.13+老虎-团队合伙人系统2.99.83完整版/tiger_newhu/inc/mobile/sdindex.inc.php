<?php
 global $_W, $_GPC;
 $dluid=$_GPC['dluid'];//share id
       $cfg = $this->module['config'];

//       $fans=$_W['fans'];
////       if(empty($fans['openid'])){
////         echo '请从微信浏览器中打开！';
////         exit;
////       }
//print_r($_SESSION);
//      exit;
       $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
         	  	  	 header("Location: ".$loginurl); 
         	  	  	 exit;
	        }	        
        }
        



        $pindex = max(1, intval($_GPC['page']));
	    $psize = 10;
	    $list = pdo_fetchall("select * from ".tablename($this->modulename."_sdorder")." where weid='{$_W['uniacid']}' and status=1 order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_sdorder')." where weid='{$_W['uniacid']}' ");
		$pager = pagination($total, $pindex, $psize);

        //var_dump($list);
        //exit;
        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
       


       include $this->template ( 'user/sdindex' );