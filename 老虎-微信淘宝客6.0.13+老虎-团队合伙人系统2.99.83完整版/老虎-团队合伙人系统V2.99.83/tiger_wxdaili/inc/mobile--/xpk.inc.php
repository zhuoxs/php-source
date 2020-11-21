 <?php
 global $_W, $_GPC;
        $cfg = $this->module['config'];
		$lm=$cfg['dlmmtype'];
		$zt=$_GPC['zt'];
		$weid=$_W['uniacid'];
		$px=$_GPC['px'];
		$type=$_GPC['type'];
		$tm=$_GPC['tm'];
		$price1=$_GPC['price1'];
		$price2=$_GPC['price2'];
		$hd=$_GPC['hd'];
		$page=$_GPC['page'];
		$key=$_GPC['key'];
		$dlyj=$_GPC['dlyj'];
		$dluid=$_GPC['dluid'];
       $fans=$_W['fans'];
        if(empty($fans)){
            $fans=mc_oauth_userinfo();
        }
        $openid=$fans['openid'];
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
        $fs=$this->jcbl($share,$bl);
        $pid=$share['dlptpid'];
         
       if($share['dltype']<>1){
             $url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('dlreg'));
             header("location:".$url);
             exit;
        }
        if($lm==2){//云商品库
        	include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
        	$fzlist=getclass($_W,$cfg['ptpid'],'');//全部分类
        }else{
            if(!empty($cfg['gyspsj'])){
               $weid=$cfg['gyspsj'];
            }

        	$fzlist = pdo_fetchall("select * from ".tablename('tiger_newhu_fztype')." where weid='{$weid}'  order by px desc");
        }

       include $this->template ('xpk');
       ?>