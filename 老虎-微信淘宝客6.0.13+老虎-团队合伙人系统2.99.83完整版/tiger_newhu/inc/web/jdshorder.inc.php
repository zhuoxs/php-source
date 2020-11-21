<?php
  global $_W, $_GPC;
        $cfg = $this->module['config'];
        
        $id=$_GPC['id'];
        $uid=$_GPC['uid'];
        $sh=$_GPC['sh'];//0未审核 1待返 2已返 3已审核 4订单失效
        $type=$_GPC['type'];//1一级  2二级 3三级
        $jltype=$_GPC['jltype'];// 0 积分  1余额
        $jl=$_GPC['jl'];//奖励金额或是积分
        $op=$_GPC['op'];
        $page=$_GPC['page'];

        $order = pdo_fetch("select * from ".tablename($this->modulename."_jdtjorder")." where weid='{$_W['uniacid']}' and id='{$id}' order by id desc");
        if($op=="onesh"){
        	if($sh=="4"){
        		message ( '失效订单不能审核奖励！', $this->createWebUrl ( 'jdtjorder',array('page'=>$page) ),'error' );
        	}
        	if($sh=="2"){
        		message ( '已奖励订单不能重复奖励！', $this->createWebUrl ( 'jdtjorder',array('page'=>$page) ),'error' );
        	}
        	if($jltype==1){//余额
        		if($type==0){
        			$this->mc_jl($uid,1,4,$jl,'自购订单奖励'.$order['orderid'],$order['orderid']);
        		}elseif($type==1){
        			$this->mc_jl($uid,1,4,$jl,'二级订单奖励'.$order['orderid'],$order['orderid']);
        		}elseif($type==2){
        			$this->mc_jl($uid,1,4,$jl,'三级订单奖励'.$order['orderid'],$order['orderid']);
        		}  
        	}else{
        		if($type==0){
        			$this->mc_jl($uid,0,4,$jl,'自购订单奖励'.$order['orderid'],$order['orderid']);
        		}elseif($type==1){
        			$this->mc_jl($uid,0,4,$jl,'二级订单奖励'.$order['orderid'],$order['orderid']);
        		}elseif($type==2){
        			$this->mc_jl($uid,0,4,$jl,'三级订单奖励'.$order['orderid'],$order['orderid']);
        		} 
        	}
        	pdo_update ($this->modulename . "_jdtjorder", array('sh'=>2), array ('id' => $id));  	
        	 message ( '审核成功，奖励已存入粉丝会员帐号！', $this->createWebUrl ( 'jdtjorder' ,array('page'=>$page)) );
        	
        }elseif($op=='delete'){
            if (pdo_delete($this->modulename."_jdtjorder",array('id'=>$id)) === false){
							message ( '删除失败！', $this->createWebUrl ( 'jdtjorder',array('page'=>$page) ),'error' );
					  }else{
               message ( '删除成功！', $this->createWebUrl ( 'jdtjorder' ,array('page'=>$page)) );
            }        
        }
