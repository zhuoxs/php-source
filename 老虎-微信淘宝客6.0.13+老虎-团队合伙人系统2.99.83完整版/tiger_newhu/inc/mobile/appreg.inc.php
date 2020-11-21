<?php
global $_W, $_GPC;
     $cfg=$this->module['config'];
     $fans = mc_oauth_userinfo();
     
     $unionid=$fans['unionid'];
     $openid=$fans['openid'];
     
     $share = pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and unionid='{$unionid}'");
     if(empty($share)){
     	$share = pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        if(!empty($share)){
            if(empty($share['unionid'])){
              pdo_update("tiger_newhu_share", array('unionid'=>$unionid), array('from_user' => $openid));  
            }
        }        
     }

     if(empty($share)){
          mc_init_fans_info($openid);
          $mc=mc_fetch($fans['openid']);
          $mcid=$mc['uid'];
          $sharedata=array(
                'openid'=>$mcid,
                'nickname'=>$fans['nickname'],
                'avatar'=>$fans['avatar'],
                'updatetime'=>time(),
                'createtime'=>time(),
                'parentid'=>0,
                'weid'=>$_W['uniacid'],
                'from_user'=>$openid,
                'follow'=>1
            );
          if(!empty($mcid)){
            pdo_insert($this->modulename."_share",$sharedata);
            $uid = pdo_insertid();
            $share = pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and id='{$uid}'");
          }          
     }
     
     
     if($_W['isajax']){
     	$tel=$_GPC['phone'];
     	$pcuser=$_GPC['phone'];
     	$pcpasswords=$_GPC['password'];
        if(empty($pcpasswords)){
          exit(json_encode(array('error' =>0, 'data' => '密码必须填写！')));
        }
     	$data=array(
     		'pcuser'=>$pcuser,
     		'pcpasswords'=>$pcpasswords,
     	);
     	pdo_update("tiger_newhu_share", $data, array('unionid' => $unionid));     	
     	exit(json_encode(array('error' =>1, 'data' => '请下载')));
     }
     
     

     include $this->template ( 'user/appreg' );
//   Array
//(
//  [subscribe] => 1
//  [openid] => oEujHwVd9QkK9FZHgyOYlbKM1tT0
//  [nickname] => 胡跃结
//  [sex] => 1
//  [language] => zh_CN
//  [city] => 金华
//  [province] => 浙江
//  [country] => 中国
//  [headimgurl] => http://wx.qlogo.cn/mmopen/ajNVdqHZLLCr6iatQiaU5cJXg7r7Xqqx8rwhs8p0egJ6kpPImDg9L8ACSLhPhCCHE3u3eLUQl2rFegBgkL7YtDxA/132
//  [subscribe_time] => 1484803878
//  [unionid] => oQIJFt1iZEnG7gyslZbtohD2RJN4
//  [remark] => 
//  [groupid] => 0
//  [tagid_list] => Array
//      (
//      )
//
//  [avatar] => http://wx.qlogo.cn/mmopen/ajNVdqHZLLCr6iatQiaU5cJXg7r7Xqqx8rwhs8p0egJ6kpPImDg9L8ACSLhPhCCHE3u3eLUQl2rFegBgkL7YtDxA/132
//)
     ?>