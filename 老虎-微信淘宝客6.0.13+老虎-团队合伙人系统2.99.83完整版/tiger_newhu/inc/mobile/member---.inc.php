<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $fans = mc_oauth_userinfo();

        //echo "<pre>";
        //print_r($fans);
        
        
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