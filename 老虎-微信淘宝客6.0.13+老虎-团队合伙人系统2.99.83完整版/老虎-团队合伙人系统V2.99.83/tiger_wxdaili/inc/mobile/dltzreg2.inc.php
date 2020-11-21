 <?php
  global $_W, $_GPC;
        $cfg = $this->module['config'];
		$dlcfg=$cfg;
//		echo "<pre>";
//		print_r($_W['account']['name']);
//		exit;

		
		
        load()->model('mc');         
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	 
       	  	  	header("Location: ".$loginurl); 
       	  	  	exit;
	        }
        }

   		$wquid=mc_openid2uid($fans['openid']);
        $helpid=$_GPC['helpid'];
        $member=$this->getmember($fans,$wquid,$helpid);
        $fans['tkuid']=$member['id'];
        
        if(empty($member['dltype'])){
			 echo "<span style='font-size:16px;text-align:center;margin-top:50px;'>只有合伙人才能申请运营商！</span>";
			 exit;
		}
		$appset= pdo_fetch("SELECT * FROM " . tablename("tiger_app_tuanzhangset") . " WHERE weid='{$_W['uniacid']}' order by px desc ");
		if($appset['sjtype']==1){
					$dlfs = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and helpid='{$member['id']}' and dltype=1");//粉丝
				}else{
					$dlfs = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and helpid='{$member['id']}'");//粉丝
				}
				$dlorder = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_tkorder")." where weid='{$_W['uniacid']}' and tgwid='{$member['tgwid']}'");//粉丝


        include $this->template ('dl/dltzreg2'); 
        ?>