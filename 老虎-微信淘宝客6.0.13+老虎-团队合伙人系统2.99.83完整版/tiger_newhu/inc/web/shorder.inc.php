<?php
  global $_W, $_GPC;
        $cfg = $this->module['config'];
         load()->model('mc');
        $id=$_GPC['id'];
        $type=$_GPC['type'];
        $op=$_GPC['op'];
        $page=$_GPC['page'];

        $order = pdo_fetch("select * from ".tablename($this->modulename."_order")." where weid='{$_W['uniacid']}' and id='{$id}' order by id desc");
        //echo '<pre>';
        //print_r($order);
        //exit;



        if($order['sh']==2){
          message ( '该订单已经审核过了，不能重复提交', $this->createWebUrl ( 'order',array('page'=>$page) ),'error' );
        }
        $tkorder = pdo_fetch("select * from ".tablename($this->modulename."_tkorder")." where weid='{$_W['uniacid']}' and orderid='{$order['orderid']}' order by id desc");

        if($op=='df'){
            if(empty($tkorder)){
               message ( '该订单在淘客订单库里面没有找到！', $this->createWebUrl ( 'order' ,array('page'=>$page)),'error' );
            }else{
               if($tkorder['type']==1){
                  message ( '该订单已被领取奖励！', $this->createWebUrl ( 'order',array('page'=>$page) ),'error' );
               }
            }

            if (pdo_update ( $this->modulename . "_order", array('sh'=>1), array ('id' => $id)) === false){
              message ( '审核失败！', $this->createWebUrl ( 'order',array('page'=>$page) ),'error' );
            }else{
               message ( '成功设置待返状态！', $this->createWebUrl ( 'order',array('page'=>$page) ) );
            }
        }elseif($op=='yf'){



            if(empty($order['sh'])){
               message ( '订单为【待返状态】，才能进行审核！', $this->createWebUrl ( 'order',array('page'=>$page) ),'error');
            }else{
                if(empty($tkorder)){
                   message ( '该订单在淘客订单库里面没有找到！', $this->createWebUrl ( 'order',array('page'=>$page) ),'error' );
                }else{
                   if($tkorder['orderzt']<>'订单结算'){
                      message ( '淘客订单未结算，订单状态为：'.$tkorder['orderzt'], $this->createWebUrl ( 'order',array('page'=>$page) ),'error' );
                   }
//                   if($tkorder['type']==1){
//                      message ( '该订单已被领取奖励！', $this->createWebUrl ( 'order' ),'error' );
//                    }else{
//                       pdo_update ( $this->modulename . "_tkorder", array('type'=>1), array ('orderid' => $order['orderid']));
//                    }
                    if($tkorder['type']<>1){
                       pdo_update ( $this->modulename . "_tkorder", array('type'=>1), array ('orderid' => $order['orderid']));
                    }                   
                }

                if (pdo_update ( $this->modulename . "_order", array('sh'=>2), array ('id' => $id,'type'=>$type)) === false){
                   message ( '审核失败！', $this->createWebUrl ( 'order',array('page'=>$page) ),'error' );
                }else{                  
                   $uid=mc_openid2uid($order['openid']);
                   $member=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$order['openid']}' order by id desc");//当前粉丝信息
                   //奖励
                   if($cfg['fxtype']==1){//积分
                     
                     //20170619改变规则
                     if($type==0){//自购
                         $credit1_zg=$order['jl'];
                         if(!empty($credit1_zg)){
                               // mc_credit_update($uid,'credit1',$credit1_zg,array($uid,'自购订单返积分:'.$order['orderid']));
                                $this->mc_jl($member['id'],0,4,$credit1_zg,'自购订单奖励积分'.$order['orderid'],$order['orderid']);
                         }                       
                     }elseif($type==1){//一级
                         $credit1_yj=$order['jl'];
                         if(!empty($credit1_yj)){
                           //mc_credit_update($uid,'credit1',$credit1_yj,array($uid,'一级订单返积分:'.$order['orderid']));
                            $this->mc_jl($member['id'],0,4,$credit1_yj,'一级订单奖励积分'.$order['orderid'],$order['orderid']);
                         }                     
                     }elseif($type==2){//二级
                          $credit1_ejf=$order['jl'];
                           if(!empty($credit1_ejf)){
                              //mc_credit_update($uid,'credit1',$credit1_ejf,array($uid,'二级订单返积分:'.$order['orderid']));
                              $this->mc_jl($member['id'],0,4,$credit1_ejf,'二级订单奖励积分'.$order['orderid'],$order['orderid']);
                              
                           }                       
                     }
                     //结束

                     
                   }elseif($cfg['fxtype']==2){//余额
                       $credit2_zg=$order['jl'];
                       //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($credit2_zg),FILE_APPEND);
                       if($type==0){//自购
                             if(!empty($credit2_zg)){
                                  if(!empty($cfg['zgf'])){
                                     pdo_update($this->modulename . "_order",array('price'=>$credit2_zg), array ('id' =>$order['id'],'weid'=>$_W['uniacid']));
                                  }
                               //mc_credit_update($uid,'credit2',$credit2_zg,array($uid,'自购订单返现:'.$order['orderid']));
                               $this->mc_jl($member['id'],1,4,$credit2_zg,'自购订单奖励'.$order['orderid'],$order['orderid']);
                             }
                       }

                       if($type==1){//一级
                           $ejprice=$order['jl'];
                           if(!empty($ejprice)){
                             if(!empty($cfg['yjf'])){
                                 pdo_update ($this->modulename . "_order", array('sh'=>2), array ('id' => $id,'type'=>$type));
                                 //mc_credit_update($uid,'credit2',$ejprice,array($uid,'一级订单返现:'.$order['orderid']));
                                 $this->mc_jl($member['id'],1,4,$ejprice,'一级订单奖励'.$order['orderid'],$order['orderid']);
                             }
                           }
                       }

                       if($type==2){//二级
                           $ejfprice=$order['jl'];
                           if(!empty($ejfprice)){
                              if(!empty($cfg['ejf'])){
                                 pdo_update ($this->modulename . "_order", array('sh'=>2), array ('id' => $id,'type'=>$type));
                                 //mc_credit_update($uid,'credit2',$ejfprice,array($uid,'二级订单返现:'.$order['orderid']));
                                 $this->mc_jl($member['id'],1,4,$ejfprice,'二级订单奖励'.$order['orderid'],$order['orderid']);
                             }
                           }
                       }

                   }
                   //奖励结束         
                   message ( '审核成功，奖励已存入粉丝会员帐号！', $this->createWebUrl ( 'order' ,array('page'=>$page)) );
                }
            }


                  
        }elseif($op=='delete'){
            if (pdo_delete($this->modulename."_order",array('id'=>$id)) === false){
				message ( '删除失败！', $this->createWebUrl ( 'order',array('page'=>$page) ),'error' );
			}else{
               message ( '删除成功！', $this->createWebUrl ( 'order' ,array('page'=>$page)) );
            }        
        }elseif($op=='up'){//更新订单金额
          $data=array(
                'yongjin'=>$tkorder['xgyg'],//佣金
                'createtime'=>TIMESTAMP
            );
          $str=pdo_update($this->modulename . "_order",$data, array ('id' => $id,'type'=>$type));
          if ($str === false){
             message ( '更新失败！', $this->createWebUrl ( 'order',array('page'=>$page) ),'error' );
          }else{
              message ( '更新成功！', $this->createWebUrl ( 'order' ,array('page'=>$page)) );
          }

        }