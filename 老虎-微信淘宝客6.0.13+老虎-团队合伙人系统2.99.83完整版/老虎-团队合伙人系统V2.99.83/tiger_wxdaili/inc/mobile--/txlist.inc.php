 <?php global $_W, $_GPC;
          $cfg = $this->module['config'];
          load()->model('mc');
          $fans=mc_oauth_userinfo();
          if(empty($fans['openid'])){
            echo '请从微信客户端打开！';
            exit;
          }
         $openid=$fans['openid'];
         $zt=$_GPC['zt'];
         if($zt==1){
           $where=" and sh<>1";
         }elseif($zt==2){
           $where=" and sh=1";
         }
         $txlist=pdo_fetchall("select * from ".tablename($this->modulename."_txlog")." where weid='{$_W['uniacid']}' {$where} and openid='{$openid}' order by id desc limit 100");


        include $this->template ( 'txlist' ); 
        ?>