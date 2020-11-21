<?php
  global $_W, $_GPC;
        $cfg = $this->module['config'];
         load()->model('mc');
        $id=$_GPC['id'];
        $type=$_GPC['type'];
        $op=$_GPC['op'];
        $page=$_GPC['page'];

        $order = pdo_fetch("select * from ".tablename($this->modulename."_mdorder")." where weid='{$_W['uniacid']}' and id='{$id}' order by id desc");
        //echo '<pre>';
        //print_r($order);
        //exit;



        if($order['sh']==2){
          message ( '该订单已经审核过了，不能重复提交', $this->createWebUrl ( 'mdorder',array('page'=>$page) ),'error' );
        }
        $tkorder = pdo_fetch("select * from ".tablename($this->modulename."_tkorder")." where weid='{$_W['uniacid']}' and orderid='{$order['orderid']}' order by id desc");

        if($op=='df'){
            if(empty($tkorder)){
               message ( '该订单在淘客订单库里面没有找到！', $this->createWebUrl ( 'miandanorder' ,array('page'=>$page)),'error' );
            }else{
               if($tkorder['type']==1){
                  message ( '该订单已被领取奖励！', $this->createWebUrl ( 'miandanorder',array('page'=>$page) ),'error' );
               }
            }

            if (pdo_update ( $this->modulename . "_order", array('sh'=>1), array ('id' => $id)) === false){
              message ( '审核失败！', $this->createWebUrl ( 'miandanorder',array('page'=>$page) ),'error' );
            }else{
               message ( '成功设置待返状态！', $this->createWebUrl ( 'miandanorder',array('page'=>$page) ) );
            }
        }elseif($op=='yf'){



            if(empty($order['sh'])){
               message ( '订单为【待返状态】，才能进行审核！', $this->createWebUrl ( 'miandanorder',array('page'=>$page) ),'error');
            }else{
                if(empty($tkorder)){
                   message ( '该订单在淘客订单库里面没有找到！', $this->createWebUrl ( 'miandanorder',array('page'=>$page) ),'error' );
                }else{
                   if($tkorder['orderzt']<>'订单结算'){
                      message ( '淘客订单未结算，订单状态为：'.$tkorder['orderzt'], $this->createWebUrl ( 'miandanorder',array('page'=>$page) ),'error' );
                   }

                    if($tkorder['type']<>1){
                       pdo_update ( $this->modulename . "_tkorder", array('type'=>1), array ('orderid' => $order['orderid']));
                    }                   
                }

                if (pdo_update ( $this->modulename . "_mdorder", array('sh'=>2), array ('id' => $id,'type'=>$type)) === false){
                   message ( '审核失败！', $this->createWebUrl ( 'miandanorder',array('page'=>$page) ),'error' );
                }else{                  
                   $member=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$order['openid']}' order by id desc");//当前粉丝信息
					$credit2_zg=$tkorder['fkprice'];
				   $this->mc_jl($member['id'],1,4,$credit2_zg,'免单全额奖励'.$order['orderid'],$order['orderid']);
				
                   //奖励结束         
                   message ( '审核成功，奖励已存入粉丝会员帐号！', $this->createWebUrl ( 'miandanorder' ,array('page'=>$page)) );
                }
            }


                  
        }elseif($op=='delete'){
            if (pdo_delete($this->modulename."_mdorder",array('id'=>$id)) === false){
				message ( '删除失败！', $this->createWebUrl ( 'miandanorder',array('page'=>$page) ),'error' );
			}else{
               message ( '删除成功！', $this->createWebUrl ( 'miandanorder' ,array('page'=>$page)) );
            }        
        }elseif($op=='up'){//更新订单金额
          $data=array(
                'yongjin'=>$tkorder['xgyg'],//佣金
                'createtime'=>TIMESTAMP
            );
          $str=pdo_update($this->modulename . "_mdorder",$data, array ('id' => $id,'type'=>$type));
          if ($str === false){
             message ( '更新失败！', $this->createWebUrl ( 'miandanorder',array('page'=>$page) ),'error' );
          }else{
              message ( '更新成功！', $this->createWebUrl ( 'miandanorder' ,array('page'=>$page)) );
          }

        }