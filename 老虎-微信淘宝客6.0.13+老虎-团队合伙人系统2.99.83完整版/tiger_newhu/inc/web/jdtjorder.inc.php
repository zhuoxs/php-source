<?php
global $_W, $_GPC;

$order=$_GPC['order'];
$dj=$_GPC['dj'];
$name=$_GPC['name'];
$uid=$_GPC['uid'];
$op=$_GPC['op'];

				if($op=="pljs"){//更新订单状态
							if(!$_GPC['id']){
									 message('请选择订单', referer(), 'error');
							}
								foreach ($_GPC['id'] as $id){
										$row = pdo_fetch("SELECT * FROM " . tablename($this->modulename.'_jdtjorder') . " WHERE id = :id", array(':id' => $id));
          
										if (empty($row)){
												continue;
										}
										if ($row['sh']==2){
												continue;
										}
										$tkrow = pdo_fetch("SELECT id,orderId,validCode FROM " . tablename($this->modulename.'_jdorder') . " WHERE orderId = :orderId", array(':orderId' => $row['orderid']));
																		// echo "<pre>";
																		// print_r($tkrow);		
																			//	exit;
										 if($tkrow['validCode']==17 || $tkrow['validCode']==18){													 
											 $aupres=pdo_update($this->modulename."_jdtjorder",array('sh'=>2), array('id' => $id));
											 if($aupres){
											 	  if($row['jltype']==1){//余额
													   $credit2_zg=$row['jl'];
														 if($row['type']==0){//自购
															 $this->mc_jl($row['uid'],1,4,$credit2_zg,'自购订单奖励'.$row['orderid'],$row['orderid']);
														 }elseif($row['type']==1){//1级
															 $this->mc_jl($row['uid'],1,4,$credit2_zg,'一级订单奖励'.$row['orderid'],$row['orderid']);
														 }elseif($row['type']==2){//2级
															 $this->mc_jl($row['uid'],1,4,$credit2_zg,'二级订单奖励'.$row['orderid'],$row['orderid']);
														 }
													}else{//积分																
														if($row['type']==0){//自购
																$credit1_zg=$row['jl'];
																if(!empty($credit1_zg)){
																	$this->mc_jl($row['uid'],0,4,$credit1_zg,'自购订单奖励积分'.$row['orderid'],$row['orderid']);
																}  				 
														}elseif($row['type']==1){//1级
																if(!empty($credit1_zg)){
																	$this->mc_jl($row['uid'],0,4,$credit1_zg,'一级订单奖励积分'.$row['orderid'],$row['orderid']);
																}  				 													 
														}elseif($row['type']==2){//2级
																if(!empty($credit1_zg)){
																	$this->mc_jl($row['uid'],0,4,$credit1_zg,'二级订单奖励积分'.$row['orderid'],$row['orderid']);
																}  														 
														}
													}
											 }
										 }
										
								}
								message('批量审核成功', referer(), 'success');
				}


        if (!empty($order)){
          $where .= " and (orderid like '%{$order}%')";
        }


        if($dj==1){
          $where .= " and (type = 0) ";
        }elseif($dj==2){
          $where .= " and (type = 1) ";
        }elseif($dj==3){   
            $where .= " and (type = 3) ";       
        }

        if (!empty($name)){
          $where .= " and (nickname like '%{$name}%' or openid='{$name}')";
        }
        if (!empty($uid)){
          $whereuid .= " and uid={$uid}";
        }
        //echo $where;

$page=$_GPC['page'];

 $cfg = $this->module['config'];
        $pindex = max(1, intval($page));
		$psize = 20;
		$list = pdo_fetchall("select * from ".tablename($this->modulename."_jdtjorder")." where weid='{$_W['uniacid']}' {$where} {$whereuid} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_jdtjorder')." where weid='{$_W['uniacid']}' {$where} {$whereuid}");
		$pager = pagination($total, $pindex, $psize);
        include $this->template ( 'jdtjorder' );