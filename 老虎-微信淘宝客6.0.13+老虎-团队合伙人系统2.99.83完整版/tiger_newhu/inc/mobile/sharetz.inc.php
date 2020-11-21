<?php
 global $_W, $_GPC;
 $dluid=$_GPC['dluid'];//share id
      $weid=intval($_GPC['weid']);
      $uid=intval($_GPC['uid']);
      $reply=pdo_fetch('select * from '.tablename('tiger_newhu_poster').' where weid=:weid order by id asc limit 1',array(':weid'=>$_W['uniacid']));
      // echo '<pre>';
     // print_r($reply);
     // EXIT;
      load()->model('account');
      $cfg=$this->module['config'];  
       //关注跳转借权使用登录授权
       if(empty($_GPC['tiger_newhu_openid'.$weid])){
                $callback = urlencode($_W['siteroot'] .'app'.str_replace("./","/",$this->createMobileurl('oauth',array('weid'=>$weid,'uid'=>$uid,'dw'=>'sharetz'))));
                $forward = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$cfg['appid']."&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
                //$forward = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$cfg['appid']."&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=1#wechat_redirect";               
                header('location:'.$forward);
                exit();
        }else{
           $openid=$_GPC['tiger_newhu_openid'.$weid];
           if(intval($reply['tztype'])==1){
                 $settings=$this->module['config'];
                 $ips = $this->getIp();
                 $ip=$this->GetIpLookup($ips);
                 $province=$ip['province'];//省
                 $city=$ip['city'];//市
                 $district=$ip['district'];//县
                 include $this -> template('sharetz');      
           }else{
              header("location:".$reply['tzurl']);
           }

          
        }