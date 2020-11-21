 <?php
global $_W, $_GPC;
         $helpid=$_GPC['id'];
         $cfg = $this->module['config'];
         load()->model('mc');         
         $fans=mc_oauth_userinfo();
         if(empty($fans['openid'])){
            echo '请从微信客户端打开！';
            exit;
         }
         $share=pdo_fetchall("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and helpid='{$helpid}' limit 100");

         

         $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
         $hshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and from_user='{$fans['openid']}'");
         if($hshare['dltype']<>1){
              $url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl("dlreg",array('dluid'=>$dluid)));
              header("location:".$url);
              exit;
         }
          // 本月起始时间:
         $bbegin_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
         $bend_time = strtotime(date("Y-m-d H:i:s", mktime ( 23, 59, 59, date ( "m" ), date ( "t" ),date( "Y" ))));
          foreach($share as $k=>$v){              
                 //本月本人佣金 订单结算
                 $byygyj=$this->bryj($v,$bbegin_time,'',3,$bl,$cfg);//代理本月预估总佣金
                 $fkze=$this->jyze($v,$bbegin_time,'',1,$bl);//本月付款总金额
                 $list[$k]['nickname']=$v['nickname'];                 
                 $list[$k]['fkze']=number_format($fkze, 2, '.', '');
                 $list[$k]['fkyj']=number_format($byygyj, 2, '.', '');
                 $list[$k]['byygyj']=number_format($byygyj, 2, '.', '');
                 $list[$k]['id']=$v['id'];
          }
          //echo "<pre>";
          //print_r($list);
          //exit;

          

        include $this->template ( 'fans2' );  
        ?>