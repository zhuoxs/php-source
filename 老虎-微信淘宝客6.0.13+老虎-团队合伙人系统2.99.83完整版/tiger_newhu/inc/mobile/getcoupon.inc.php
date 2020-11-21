<?php
 global $_W, $_GPC;
        
            $cfg = $this->module['config'];
            $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
            $id=$_GPC['id'];
            $pid=$_GPC['pid'];
            $openid=$_GPC['openid'];
            $dluid=$_GPC['dluid'];
            $weid=$_W['uniacid'];
            if(!empty($cfg['gyspsj'])){
              $weid=$cfg['gyspsj'];
            }

            $fans=$this->islogin();
            if(empty($fans['tkuid'])){
                $fans = mc_oauth_userinfo();        
            }

                     
             if(!empty($dluid)){
                $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
              }else{
                //$fans=mc_oauth_userinfo();
                $openid=$fans['openid'];
                $zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
              }
                if($zxshare['dltype']==1){
                    if(!empty($zxshare['dlptpid'])){
                      $cfg['ptpid']=$zxshare['dlptpid'];
                      $cfg['qqpid']=$zxshare['dlqqpid'];
                    }
                }else{
                   if(!empty($zxshare['helpid'])){//查询有没有上级
                         $sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and openid='{$zxshare['helpid']}'");
                    }
                }

                

                if(!empty($sjshare['dlptpid'])){
                    if(!empty($sjshare['dlptpid'])){
                      $cfg['ptpid']=$sjshare['dlptpid'];
                      $cfg['qqpid']=$sjshare['dlqqpid'];
                    }                    
                }else{
                   if($share['dlptpid']){
                       if(!empty($share['dlptpid'])){
                         $cfg['ptpid']=$share['dlptpid'];
                         $cfg['qqpid']=$share['dlqqpid'];
                       }
                    }
                }


                
            
            include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 

            if(empty($id) || $id=='undefined' || $id=='null'){//联盟产品

                $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
                $myck=$ck['data'];
                $turl="https://item.taobao.com/item.htm?id=".$_GPC['num_iid'];
                if(!empty($pid) and $pid!=='undefined'){
                   $cfg['ptpid']=$pid;
                   $views['pid']=$pid;
                   $pidSplit=explode('_',$cfg['ptpid']);
                   $cfg['siteid']=$pidSplit[2];
                   $cfg['adzoneid']=$pidSplit[3];
                 }else{
                   $pidSplit=explode('_',$cfg['ptpid']);
                   $cfg['siteid']=$pidSplit[2];
                   $cfg['adzoneid']=$pidSplit[3];
                 }
                
                $res=hqyongjin($turl,$ck,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W,1,$_GPC['num_iid']);
                $rhyurl=$res['dclickUrl'];
                
                $num_iid=$_GPC['num_iid'];
                $views['coupons_price']=$_GPC['coupons_price'];
                $views['price']=$_GPC['price'];
                $views['org_price']=$_GPC['org_price'];
                $views['title']=$_GPC['title'];
                $views['pic_url']=$_GPC['pict_url'];
                $views['tk_rate']=$_GPC['tk_rate'];

                if($cfg['tkltype']==1){
                   $views['taokouling']=gettkl($rhyurl,$views['title'],$views['pict_url']);
                }else{
                   $taokouling=$this->tkl($rhyurl,$views['pict_url'],$views['title']);
                  $taokou=$taokouling->model;
                  settype($taokou, 'string');
                  $views['taokouling']=$taokou;  
                }
                  $yongjin=$views['price']*$views['tk_rate']/100;//佣金
                   if($cfg['fxtype']==1){//积分           
                        $flyj=intval($yongjin*$cfg['zgf']/100*$cfg['jfbl']);//自购佣金
                        $flyj=intval($flyj);

                        $lx=$cfg["hztype"];
                    }else{//余额
                        $yongjin=number_format($yongjin, 2, '.', ''); 
                        $flyj=$yongjin*$cfg['zgf']/100;//自购佣金
                        $flyj=number_format($flyj, 2, '.', ''); 
                        $lx=$cfg["yetype"];
                        if($cfg['txtype']==3){
                            $flyj=$flyj*100;
                            $lx='集分宝';            
                        }
                    }
                  if(empty($views['org_price'])){
                      $iosmsg="【商品】".$_GPC['title']."<br/>【优惠券】".$views['coupons_price']."元<br/>【券后价】".$views['price']."元<br>-------------<br/>【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$views['taokouling'];
                      $msga="【商品】".$_GPC['title']."\r\n【优惠券】".$views['coupons_price']."元\r\n【券后价】".$views['price']."元\r\n-------------\r\n【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$views['taokouling'];
                   }else{
                      $iosmsg="【商品】".$_GPC['title']."<br/>【原价】".$views['org_price']."元<br/>【优惠券】".$views['coupons_price']."元<br/>【券后价】".$views['price']."元<br/>-------------<br/>【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$views['taokouling'];
                      $msga="【商品】".$_GPC['title']."\r\n【原价】".$views['org_price']."元\r\n【优惠券】".$views['coupons_price']."元\r\n【券后价】".$views['price']."元\r\n-------------\r\n【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$views['taokouling'];
                   }
            }else{
            
           if(empty($id)){
             $id=$_GPC['commodityID'];
           }
           
           if(!empty($id)){
              $views=pdo_fetch("select * from".tablename($this->modulename."_tbgoods")." where weid='{$weid}' and id='{$id}'");
              $fzlist4 = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$weid}' and type='{$views['type']}' order by px desc limit 4");
              $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
               $myck=$ck['data'];
               $turl="https://item.taobao.com/item.htm?id=".$views['num_iid'];
                

                if(!empty($pid) and $pid!=='undefined'){
                   $cfg['ptpid']=$pid;
                   $views['pid']=$pid;
                   $pidSplit=explode('_',$cfg['ptpid']);
                   $cfg['siteid']=$pidSplit[2];
                   $cfg['adzoneid']=$pidSplit[3];
                 }else{
                   $pidSplit=explode('_',$cfg['ptpid']);
                   $cfg['siteid']=$pidSplit[2];
                   $cfg['adzoneid']=$pidSplit[3];
                 }

                
               

               $res=hqyongjin($turl,$ck,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W,1,$views['num_iid']);
               
               if($cfg['yktype']==1){
                   $erylj=$res['dclickUrl']."&activityId=".$views['quan_id'];
               }else{
                  if($res['qq']==1){
                     $erylj=$this->rhydx($views['quan_id'],$views['num_iid'],$cfg['ptpid']);
                   }else{
                     $erylj=$this->rhy($views['quan_id'],$views['num_iid'],$cfg['ptpid']);//二合一连接
                   }
               }
            }
            

    
              $tjcontent=$views['title'];
               
               if($cfg['tkltype']==1){
                  $views['taokouling']=gettkl($erylj,$tjcontent,$res['pictUrl']);
                }else{
                    $taokouling=$this->tkl($erylj,$res['pictUrl'],$tjcontent);
                    $taokou=$taokouling->model;
                    settype($taokou, 'string');
                    $views['taokouling']=$taokou;
                }
              

           $yongjin=$views['price']*$views['tk_rate']/100;//佣金
           if($cfg['fxtype']==1){//积分           
                $flyj=intval($yongjin*$cfg['zgf']/100*$cfg['jfbl']);//自购佣金
                $flyj=intval($flyj);

                $lx=$cfg["hztype"];
            }else{//余额
                $yongjin=number_format($yongjin, 2, '.', ''); 
                $flyj=$yongjin*$cfg['zgf']/100;//自购佣金
                $flyj=number_format($flyj, 2, '.', ''); 
                $lx=$cfg["yetype"];
                if($cfg['txtype']==3){
                    $flyj=$flyj*100;
                    $lx='集分宝';            
                }
            }

           // file_put_contents(IA_ROOT."/addons/tiger_newhu/log-pid.txt","\n".$pid."--".$cfg['ptpid']."--".$erylj."--".$views['taokouling'],FILE_APPEND);
            
           //
           if(empty($views['org_price'])){
              $iosmsg="【商品】".$tjcontent."<br/>【优惠券】".$views['coupons_price']."元<br/>【券后价】".$views['price']."元<br>-------------<br/>【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$views['taokouling'];
              $msga="【商品】".$tjcontent."\r\n【优惠券】".$views['coupons_price']."元\r\n【券后价】".$views['price']."元\r\n-------------\r\n【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$views['taokouling'];
           }else{
              $iosmsg="【商品】".$tjcontent."<br/>【原价】".$views['org_price']."元<br/>【优惠券】".$views['coupons_price']."元<br/>【券后价】".$views['price']."元<br/>-------------<br/>【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$views['taokouling'];
              $msga="【商品】".$tjcontent."\r\n【原价】".$views['org_price']."元\r\n【优惠券】".$views['coupons_price']."元\r\n【券后价】".$views['price']."元\r\n-------------\r\n【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$views['taokouling'];
           }
      }


           

           //上报日志
            $arr=array(
               'pid'=>$cfg['ptpid'],
               'account'=>"无",
               'mediumType'=>"微信群",
               'mediumName'=>"老虎优惠券".rand(10,1000),
               'itemId'=>$views['num_iid'],
               'originUrl'=>"https://item.taobao.com/item.htm?id=".$views['numid'],
               'tbkUrl'=>$rhyurl,
               'itemTitle'=>$views['title'],
               'itemDescription'=>$views['title'],
               'tbCommand'=>$views['taokouling'],
               'extraInfo'=>"无",
            );
            include IA_ROOT . "/addons/tiger_newhu/inc/sdk/taoapi.php"; 
            $resp=getapi($arr);
            //日志结束


           exit(json_encode(array('code'=>10000,'msg' =>'申请成功','commission'=>$flyj.$lx, 'url' => $msga,'iosmsg'=>$iosmsg))); 
           //{"code":10000,"msg":"申请成功","commission":0.00,"url":"复制框内整段文字，打开【手机淘宝】即可【领取优惠券】并购买￥M96Nhv7VEt￥"}
?>