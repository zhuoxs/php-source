<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }	        
        }
        
//      echo "<pre>";
//      print_r($fans);
//      exit;


		//$fans = $_W['fans'];
        $dluid=$_GPC['dluid'];//share id
        $mc=mc_fetch($fans['openid']);
//        echo "<pre>";
//        print_r($mc);
//       // credit2
//        exit;


        $fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=0  order by px desc");
        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
        $member = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");

        if($member['dltype']==1){
           $contfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename($this->modulename.'_share')." where weid='{$_W['uniacid']}' and helpid='{$member['id']}'");//下级粉丝
           $contorder = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename($this->modulename.'_tkorder')." where weid='{$_W['uniacid']}' and tgwid='{$member['tgwid']}'");//我的订单
        }


        $fxordercont = pdo_fetchcolumn("SELECT SUM(num) FROM " . tablename("mc_credits_record")." where uniacid='{$_W['uniacid']}' and uid='{$mc['uid']}' and credittype='credit2' and num>0");//累计收益
        $dfyn = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename($this->modulename.'_order')." where weid='{$_W['uniacid']}' and openid='{$fans['openid']}' and sh=1");//累计收益

        if(empty($member['unionid'])){
           $updata=array(
               'unionid'=>$fans['unionid'],
               'nickname'=>$fans['nickname'],
               'avatar'=>$fans['avatar']
           );
          $aa=pdo_update($this->modulename."_share", $updata, array('id' => $member['id']));
          //echo $aa;
        }
   

        if(empty($member)){
           if(!empty($fans['uid'])){

              



               pdo_insert($this->modulename."_share",
					array(
							'openid'=>$mc['uid'],
							'nickname'=>$fans['nickname'],
							'avatar'=>$fans['avatar'],
                            'unionid'=>$fans['unionid'],
							'pid'=>'',
                            'updatetime'=>time(),
							'createtime'=>time(),
							'parentid'=>0,
							'weid'=>$_W['uniacid'],
							'score'=>'',
							'cscore'=>'',
							'pscore'=>'',
                            'from_user'=>$fans['openid'],
                            'follow'=>1
					));
			   $member['id'] = pdo_insertid();

           }
			$member = pdo_fetch('select * from '.tablename($this->modulename."_share")." where id='{$member['id']}'");
       }
        //print_r($member);


       include $this->template ( 'user/member' );
