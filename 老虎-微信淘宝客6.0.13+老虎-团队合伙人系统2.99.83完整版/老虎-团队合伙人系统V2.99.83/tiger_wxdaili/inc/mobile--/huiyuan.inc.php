 <?php
 global $_W, $_GPC;
        $cfg = $this->module['config'];
        load()->model('mc');         
         $fans=mc_oauth_userinfo();
         if(empty($fans['openid'])){
          echo '请从微信客户端打开！';
            exit;
         }
        $uid=mc_openid2uid($fans['openid']);
        $openid=$fans['openid'];
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        if($share['dltype']<>1){
              $url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('dlreg'));
              header("location:".$url);
              exit;
        }
        $tgwarr=explode('|',$share['tgwid']);
        $dd=$_GPC['dd'];

        $day=date('Y-m-d');
        $day=strtotime($day);//今天0点时间戳    
        $day3=strtotime(date("Y-m-d",strtotime("-2 day")));//3天
        $day7=strtotime(date("Y-m-d",strtotime("-6 day")));//7天时间
         //统计订单
        $where='';
        if(!empty($share['tgwid'])){
           $where .="and (";
           foreach($tgwarr as $k=>$v){
               $where .=" tgwid=".$v." or ";
           }
           $where .="tgwid=".$tgwarr[0].")";
        }else{
          $where .=" and tgwid=111111";
        }

        



        if($dd==1){
            $dlwhere.=" and addtime>{$day}";   
            $qbdd = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' {$dlwhere} {$where}");
            $sxdd = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' {$dlwhere} {$where} and orderzt='订单失效'");
        }
        if($dd==3){             
            $dlwhere.=" and addtime>{$day3}"; 
            $qbdd = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' {$dlwhere} {$where}");
            $sxdd = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' {$dlwhere} {$where} and orderzt='订单失效'");
        }
        if($dd==7){            
            $dlwhere.=" and addtime>{$day7}"; 
            $qbdd = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' {$dlwhere} {$where}");
            $sxdd = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' {$dlwhere} {$where} and orderzt='订单失效'");
            
        }
        if($dd=='qb' or $dd==''){
            $qbdd = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' {$dlwhere} {$where}");
            $sxdd = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and orderzt='订单失效' {$where}");
        }
         //统计订单结束
        if($cfg['fytype']==1){
          $fytype="sum(fkprice)";
        }else{
          $fytype="sum(xgyg)";
        }
        $sum = pdo_fetchcolumn("SELECT {$fytype} FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and addtime>{$day} {$where}");//今天 
        $daysum=number_format($sum*$share['dlbl']/100,2);

        $day1=strtotime(date("Y-m-d",strtotime("-1 day")));//昨天时间
        $sum1 = pdo_fetchcolumn("SELECT {$fytype} FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and addtime>{$day1} and addtime<{$day} {$where}");//昨天
        $daysum1=number_format($sum1*$share['dlbl']/100,2);

        $msum=strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y"))));//本月开始
        $sum2 = pdo_fetchcolumn("SELECT {$fytype} FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' and addtime>{$msum} {$where}");//本月
        $daysum2=number_format(($sum2*$share['dlbl'])/100,2);

        $sum3 = pdo_fetchcolumn("SELECT {$fytype} FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}' {$where}");//累计
        $daysum3=number_format($sum3*$share['dlbl']/100,2);




        include $this->template ( 'huiyuan' );    
        ?>