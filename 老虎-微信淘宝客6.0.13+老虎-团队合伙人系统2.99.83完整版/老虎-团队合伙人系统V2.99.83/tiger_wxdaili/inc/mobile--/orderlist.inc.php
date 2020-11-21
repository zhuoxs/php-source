 <?php
 global $_W, $_GPC;
               
         $id=$_GPC['id'];//share id
         $dd=$_GPC['dd'];
         $zt=$_GPC['zt'];
         $cfg = $this->module['config'];
         load()->model('mc');
         $fans=mc_oauth_userinfo();
         $openid=$fans['openid'];
         if(empty($fans['openid'])){
            echo '请从微信客户端打开！';
            exit;
         }
         if(!empty($id)){
           $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$id}'");
         }else{
           
           $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
         }
         
        // {"error":0,"message":""}
         include $this->template ( 'orderlist' );    
         ?>