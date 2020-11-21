 <?php
 global $_W, $_GPC;
         $cfg = $this->module['config'];
         load()->model('mc');
         $fans=mc_oauth_userinfo();
         if(empty($fans['openid'])){
            echo '请从微信客户端打开！';
            exit;
         }
         $openid=$fans['openid'];
         $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
         $emw="http://pan.baidu.com/share/qrcode?w=150&h=150&url=".$share['url'];

         include $this->template ( 'fx' );  
         ?>  