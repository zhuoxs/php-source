<?php
  global $_W, $_GPC;
      $weid=$_W['uniacid'];
      $uid=$_GPC['uid'];
      load()->model('mc');
      load()->model('account');
      $cfg=$this->module['config']; 
      if(empty($_GPC['tiger_newhu_openid'.$weid])){
            $callback = urlencode($_W['siteroot'] .'app'.str_replace("./","/",$this->createMobileurl('oauthkd',array('weid'=>$weid,'uid'=>$uid))));
            $forward = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$cfg['appid']."&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
            //$forward=  "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$cfg['appid']."&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
            header('location:'.$forward);
            exit();
      }else{
        $openid=$_GPC['tiger_newhu_openid'.$weid];
      }
      $fans=pdo_fetch('select * from '.tablename('mc_mapping_fans').' where uniacid=:uniacid and uid=:uid order by fanid desc limit 1',array(':uniacid'=>$_W['uniacid'],':uid'=>$_GPC['uid']));//当前粉丝信息

      

      $member=pdo_fetch('select * from '.tablename('tiger_newhu_member').' where weid=:weid and openid=:openid order by id desc limit 1',array(':weid'=>$_W['uniacid'],':openid'=>$openid));//借权的当前粉丝信息
      //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($member),FILE_APPEND);
      //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($openid),FILE_APPEND);
      //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($fans),FILE_APPEND);


      if(!empty($member)){
         $data = array('from_user'=>$fans['openid']);
         pdo_update('tiger_newhu_member', $data, array('weid' =>$weid,'openid' =>$openid));//更新借权表的真实openid的from_user表
         $share=pdo_fetch('select * from '.tablename('tiger_newhu_share').' where weid=:weid and from_user=:from_user order by id asc limit 1',array(':weid'=>$_W['uniacid'],':from_user'=>$fans['openid']));//查找分享表当前用户有没有
         
         if(!empty($share)){
             $data = array('jqfrom_user'=>$openid,'nickname'=>$member['nickname'],'avatar'=>$member['headimgurl']);
             pdo_update('tiger_newhu_share', $data, array('weid' =>$weid,'from_user' =>$fans['openid']));//更新当前分享表数据
             $this->sendtext('亲，您已经领取过奖励了，不能重复领取，快去生成海报赚取奖励吧！',$fans['openid']); 
             include $this -> template('kending');//推广记录里面有了，就退出
             exit;
         }else{
           if(empty($fans['uid'])){
             include $this -> template('kending');
             exit;
           }
           pdo_insert($this->modulename."_share",
					array(
							'openid'=>$fans['uid'],
							'nickname'=>$member['nickname'],
							'avatar'=>$member['headimgurl'],
							'createtime'=>time(),
							'parentid'=>$member['helpid'],
                            'helpid'=>$member['helpid'],
							'weid'=>$_W['uniacid'],
                            'from_user'=>$fans['openid'],
                            'jqfrom_user'=>$openid,
                            'follow'=>1
					));
         }
         /*
           查找积分奖励情况
           ims_mc_credits_record 表
           uid用户ID
           uniacid公众号ID
           credittype  credit1 credit2
           remark 关注送积分
         */
         $credit1=pdo_fetch('select * from '.tablename('mc_credits_record').' where uniacid=:uniacid and uid=:uid and credittype=:credittype and remark=:remark',array(':uniacid'=>$_W['uniacid'],':uid'=>$fans['uid'],':credittype'=>'credit1',':remark'=>'关注送积分'));
         $credit2=pdo_fetch('select * from '.tablename('mc_credits_record').' where uniacid=:uniacid and uid=:uid and credittype=:credittype and remark=:remark',array(':uniacid'=>$_W['uniacid'],':uid'=>$fans['uid'],':credittype'=>'credit2',':remark'=>'关注送余额'));
         if(empty($credit1) || empty($credit1)){
            $share=pdo_fetch('select * from '.tablename('tiger_newhu_share').' where weid=:weid and from_user=:from_user order by id asc limit 1',array(':weid'=>$_W['uniacid'],':from_user'=>$fans['openid']));//重新查找当前粉丝分享表信息
            $poster = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_poster')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
            if($poster['score']>0 || $poster['scorehb']>0){
              $info1=str_replace('#昵称#',$share['nickname'], $poster['ftips']);
              $info1=str_replace('#积分#',$poster['score'], $info1);
              $info1=str_replace('#元#',$poster['scorehb'], $info1);
              if(!empty($poster['score'])){mc_credit_update($share['openid'],'credit1',$poster['score'],array($share['openid'],'关注送积分'));}
              if(!empty($poster['scorehb'])){mc_credit_update($share['openid'],'credit2',$poster['scorehb'],array($share['openid'],'关注送余额'));}
              $this->sendtext($info1,$fans['openid']);
                
                if($share['helpid']>0){
                   if($poster['cscore']>0 || $poster['cscorehb']>0){
                      $hmember = pdo_fetch('select * from '.tablename($this->modulename."_share")." where openid='{$share['helpid']}'");
                      if($hmember['status']==1){
                        include $this -> template('kending');
                        exit;
                      }
                      //if($share['helpid']==$hmember['openid']){
                       //  include $this -> template('kending');
                      //   exit;
                      //}
                      $info2=str_replace('#昵称#',$share['nickname'], $poster['utips']);
                      $info2=str_replace('#积分#',$poster['cscore'], $info2);
                      $info2=str_replace('#元#',$poster['cscorehb'], $info2);
                      if(!empty($poster['cscore'])){mc_credit_update($hmember['openid'],'credit1',$poster['cscore'],array($hmember['openid'],'2级推广奖励'));}
                      if(!empty($poster['cscorehb'])){mc_credit_update($hmember['openid'],'credit2',$poster['cscorehb'],array($hmember['openid'],'2级推广奖励'));} 
                      $this->sendtext($info2,$hmember['from_user']);
                   }
                   if($poster['pscore']>0 || $poster['pscorehb']>0){
                      $fmember=pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_share')." WHERE weid = :weid and openid=:openid", array(':weid' => $_W['uniacid'],':openid'=>$hmember['helpid']));
                      if($fmember['status']==1){
                        include $this -> template('kending');
                        exit;
                      }
                        //if(!empty($fmember)){
                            $info3=str_replace('#昵称#',$share['nickname'], $poster['utips2']);
                            $info3=str_replace('#积分#',$poster['pscore'], $info3);
                            $info3=str_replace('#元#',$poster['pscorehb'], $info3);
                            if($poster['pscore']){mc_credit_update($fmember['openid'],'credit1',$poster['pscore'],array($fmember['openid'],'3级推广奖励'));}
                            if($poster['pscorehb']){mc_credit_update($fmember['openid'],'credit2',$poster['pscorehb'],array($fmember['openid'],'3级推广奖励'));}        
                            $this->sendtext($info3,$fmember['from_user']);   
                       // }
                    }
                }
                
            }
            include $this -> template('kending');
            exit;

         }else{
           $this->sendtext('尊敬的粉丝：\n\n您已经领取过奖励了，不能重复领取，快去生成海报赚取奖励吧！',$fans['openid']);
           include $this -> template('kending');
           exit;
         }
         
      }

      $this->sendtext('尊敬的粉丝：\n\n您不能领取奖励哦，只有通过扫海报进来的，才能领取奖励！快去生成海报赚取奖励吧！',$fans['openid']);
      include $this -> template('kending');
?>