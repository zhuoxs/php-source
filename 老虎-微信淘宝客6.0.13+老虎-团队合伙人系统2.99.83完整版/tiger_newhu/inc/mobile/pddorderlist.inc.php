<?php
 global $_W, $_GPC;
        $cfg = $this->module['config'];
        load()->model('mc');
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();  
            if(empty($fans['openid'])){
                echo '请从微信客户端打开！';
                exit;
             }
        }

        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        $uid=$share['id'];
        $op=$_GPC['op'];
        $orderid=$_GPC['orderid'];
        $dluid=$_GPC['dluid'];//share id
        if($op=='qb'){//全部
        	if(!empty($orderid)){
        		$ddorwehre=" and orderid='{$orderid}'";
        	}
            $order = pdo_fetchall("select * from ".tablename($this->modulename."_pddtjorder")." where weid='{$_W['uniacid']}' and openid='{$fans['openid']}' {$ddorwehre}  order by id desc");
//            echo "<pre>";
//            print_r($order);
//            exit;
            foreach($order as $k=>$v){
                if(empty($uid)){
                  continue;
                }
                
                $tkorder = pdo_fetch("select * from ".tablename($this->modulename."_pddorder")." where weid='{$_W['uniacid']}' and order_sn='{$v['orderid']}'");
//              echo "<pre>";
//              print_r($tkorder);
                
                 
                 if(!empty($tkorder)){
 
                      if($v['sh']==0 || $v['sh']==3 and $tkorder['order_status_desc']=="已成团"){
                          pdo_update ( $this->modulename . "_pddtjorder", array('sh'=>3,'yongjin'=>$tkorder['promotion_amount']), array ('id' => $v['id']));
                       }
                       if($tkorder['order_status_desc']=="已成团" || $tkorder['order_status_desc']=="确认收货" and $v['sh']==3){
                         //echo $v['orderid'];
                         pdo_update ( $this->modulename . "_pddtjorder", array('sh'=>1,'yongjin'=>$tkorder['promotion_amount']), array ('id' => $v['id']));
                       }
                       if($tkorder['order_status_desc']=="未支付" || $tkorder['order_status_desc']=="审核失败" || $tkorder['order_status_desc']=='非多多进宝商品'){
                         pdo_update ( $this->modulename . "_pddtjorder", array('sh'=>4,'yongjin'=>$tkorder['promotion_amount']), array ('id' => $v['id']));
                       }

                        if($tkorder['order_status_desc']=="已结算"){
                            if($v['sh']==2){
                              continue;
                            }
                            //echo $v['sh'];
                            if($v['sh']<>2){
                                
                               $jstime=$tkorder['order_receive_time']+86400*$cfg['yongjinjs'];//阿里妈妈结算时间+可结算天数
                               if($jstime<time()){//如果达到结算时间，就自动结算                                   
                                   if($cfg['fxtype']==1){//积分
                                       if($v['type']==0){//自购
                                         $credit1_zg=$v['jl'];
                                         if(!empty($credit1_zg)){
                                             if($v['sh']<>2){
                                             //$zgdd = pdo_fetch("select * from ".tablename("mc_credits_record")." where uniacid='{$_W['uniacid']}' and uid='{$uid}' and remark='自购订单返积分:{$v['orderid']}'"); 
                                             if(empty($zgdd)){
                                             	 $this->mc_jl($uid,0,4,$credit1_zg,'自购订单返积分'.$v['orderid'],$v['orderid']);
                                             }
                                              
                                             }
                                           pdo_update ( $this->modulename . "_pddtjorder", array('sh'=>2,'yongjin'=>$tkorder['promotion_amount']), array ('id' => $v['id']));
                                         }
                                       }elseif($v['type']==1){//一级返
                                         $credit1_zg=$v['jl'];
                                         if(!empty($credit1_zg)){
                                           if($v['sh']<>2){
                                           	//$yjdd = pdo_fetch("select * from ".tablename("mc_credits_record")." where uniacid='{$_W['uniacid']}' and uid='{$uid}' and remark='一级订单返积分:{$v['orderid']}'"); 
                                           	if(empty($yjdd)){
                                           		$this->mc_jl($uid,0,4,$credit1_zg,'一级订单返积分'.$v['orderid'],$v['orderid']);
                                           	}
                                               
                                           }
                                           pdo_update ( $this->modulename . "_pddtjorder", array('sh'=>2,'yongjin'=>$tkorder['promotion_amount']), array ('id' => $v['id']));
                                         }
                                       }elseif($v['type']==2){//二级返
                                         $credit1_zg=$v['jl'];
                                         if(!empty($credit1_zg)){
                                             if($v['sh']<>2){
                                             	//$rjdd = pdo_fetch("select * from ".tablename("mc_credits_record")." where uniacid='{$_W['uniacid']}' and uid='{$uid}' and remark='二级订单返积分:{$v['orderid']}'"); 
                                             	if(empty($rjdd)){
                                             		$this->mc_jl($uid,0,4,$credit1_zg,'二级订单返积分'.$v['orderid'],$v['orderid']);
                                             	}   
                                             }
                                           pdo_update ( $this->modulename . "_pddtjorder", array('sh'=>2,'yongjin'=>$tkorder['promotion_amount']), array ('id' => $v['id']));
                                         }
                                       }                                   
                                   }elseif($cfg['fxtype']==2){//余额

                                       
                                       if($v['type']==0){//自购
                                           //$credit1_zg=$tkorder['xgyg']*$cfg['zgf']/100;  
                                           $credit1_zg=$v['jl'];
                                           if(!empty($credit1_zg)){
                                               if($v['sh']<>2){
                                               	//$zgyrdd = pdo_fetch("select * from ".tablename("mc_credits_record")." where uniacid='{$_W['uniacid']}' and uid='{$uid}' and remark='自购订单返余额:{$v['orderid']}'"); 
                                               	if(empty($zgyrdd)){
                                               		$this->mc_jl($uid,1,4,$credit1_zg,'自购订单返余额'.$v['orderid'],$v['orderid']);
                                               	}
                                                 
                                               }                                
                                               pdo_update ( $this->modulename . "_pddtjorder", array('sh'=>2,'yongjin'=>$tkorder['promotion_amount']), array ('id' => $v['id']));
                                            }                                         
                                       }elseif($v['type']==1){//一级返
                                           //$credit1_zg=$tkorder['xgyg']*$cfg['yjf']/100;  
                                           $credit1_zg=$v['jl'];
                                           if(!empty($credit1_zg)){
                                               if($v['sh']<>2){
                                               	//$yjyrdd = pdo_fetch("select * from ".tablename("mc_credits_record")." where uniacid='{$_W['uniacid']}' and uid='{$uid}' and remark='一级订单返余额:{$v['orderid']}'"); 
                                               	if(empty($yjyrdd)){
                                               		$this->mc_jl($uid,1,4,$credit1_zg,'一级订单返余额'.$v['orderid'],$v['orderid']);
                                               	}
                                                 
                                               }
                                               pdo_update ( $this->modulename . "_pddtjorder", array('sh'=>2,'yongjin'=>$tkorder['promotion_amount']), array ('id' => $v['id']));
                                           } 
                                          
                                       
                                       }elseif($v['type']==2){//二级返
                                          // $credit1_zg=$tkorder['xgyg']*$cfg['ejf']/100;  
                                           $credit1_zg=$v['jl'];
                                           if(!empty($credit1_zg)){
                                               if($v['sh']<>2){
                                               	//$rjyrdd = pdo_fetch("select * from ".tablename("mc_credits_record")." where uniacid='{$_W['uniacid']}' and uid='{$uid}' and remark='一级订单返余额:{$v['orderid']}'"); 
                                               	if(empty($rjyrdd)){
                                               		$this->mc_jl($uid,1,4,$credit1_zg,'二级订单返余额'.$v['orderid'],$v['orderid']);
                                               	}
                                                 
                                               }
                                               pdo_update ( $this->modulename . "_pddtjorder", array('sh'=>2,'yongjin'=>$tkorder['promotion_amount']), array ('id' => $v['id']));
                                           }
                                       }

                                     
                                   }
                                 
                               }
                            }
                          
                        }
                   
                 }
            
            }



        }elseif($op=='df'){//已成团
            $order = pdo_fetchall("select * from ".tablename($this->modulename."_pddtjorder")." where weid='{$_W['uniacid']}' and openid='{$fans['openid']}' and sh=1 order by id desc");
        }elseif($op=='yf'){//已收货
            $order = pdo_fetchall("select * from ".tablename($this->modulename."_pddtjorder")." where weid='{$_W['uniacid']}' and openid='{$fans['openid']}' and sh=2  order by id desc");
        }
        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
//exit;
        include $this->template ( 'user/pddorderlist' ); 