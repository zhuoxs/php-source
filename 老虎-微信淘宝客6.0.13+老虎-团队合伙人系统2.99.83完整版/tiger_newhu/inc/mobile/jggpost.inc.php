<?php
global $_W, $_GPC;
$uid=$_GPC['uid'];
$cfg=$this->module['config'];
$ddcjxz = unserialize($cfg['ddcjxz']);
$ddcjjl = unserialize($cfg['ddcjjl']);
foreach ($ddcjxz as $key => $value) {
    if (empty($value)) continue;
    $tplist[] = array('ddcjxz'=>$value,'ddcjjl'=>$ddcjjl[$key]);
}

	if ($_W['isajax']){
//		$order = pdo_fetch("select * from ".tablename($this->modulename."_order")." where weid='{$_W['uniacid']}' and sh<>2 and sh<>4 and uid='{$uid}' order by id desc");
		if($cfg['dztypelx']==1){//直接到帐号
        	$order = pdo_fetch("select * from ".tablename($this->modulename."_order")." where weid='{$_W['uniacid']}' and sh<>2 and sh<>4 and type=0 and uid='{$uid}'");
        }else{
        	$order = pdo_fetch("select * from ".tablename($this->modulename."_order")." where weid='{$_W['uniacid']}'  and sh<>2 and sh<>4 and cjdd<>1 and type=0 and uid='{$uid}'");
        }	
		if(empty($order)){
			$data=array(
					'msg'=>'暂无抽奖机会，购物获得更多抽奖机会！',
					'error'=>1,
			);
			exit(json_encode($data));
		}else{
			$sjyongjin=$order['yongjin'];
			if(empty($tplist)){
				$data=array(
						'msg'=>'管理员暂没设置抽奖规则！',
						'error'=>1,
				);
				exit(json_encode($data));
			}
			
			function dbddjl($sjyongjin,$tplist){
				foreach($tplist as $k=>$v){
					if($v['ddcjxz']<$sjyongjin){	
						$retarr=array(
							'ddcjxz'=>$v['ddcjxz'],
							'ddcjjl'=>$v['ddcjjl'],
						);	
						return $retarr;
						break;
					}
				}
				return '';
			}
			
			$jlyj=dbddjl($sjyongjin,$tplist);
			if($cfg['dztypelx']==1){//直接到帐号
				if($cfg['cjlxtype']==1){//余额
					$jltype=1;
					$resup=pdo_update($this->modulename . "_order",array('sh'=>2,'cjdd'=>1,'jltype'=>$jltype,'jl'=>$jlyj['ddcjjl']), array ('id'=>$order['id'],'uid' =>$uid,'weid'=>$_W['uniacid'],'itemid'=>$order['itemid']));
					$this->mc_jl($uid,1,4,$jlyj['ddcjjl'],'抽奖奖励余额'.$v['orderid'],$v['orderid']);
					if($resup!='false'){
						$sj=rand(0,7);
						if(empty($cfg['yetype'])){
							$jftype="余额";
						}else{
							$jftype=$cfg['yetype'];
						}
						
						$data=array(
							'prize'=>"恭喜你抽中".$jlyj['ddcjjl'].$jftype,
							'giftid'=>6,
							'stoped'=>$sj
						);
						exit(json_encode($data));
					}else{
						$data=array(
							'prize'=>'服务器维护中！',
							'giftid'=>6,
							'stoped'=>$sj
						);
						exit(json_encode($data));
					}
				}else{//积分
					$jltype=0;
					$resup=pdo_update($this->modulename . "_order",array('sh'=>2,'cjdd'=>1,'jltype'=>$jltype,'jl'=>$jlyj['ddcjjl']), array ('id'=>$order['id'],'uid' =>$uid,'weid'=>$_W['uniacid'],'itemid'=>$order['itemid']));
					$this->mc_jl($uid,0,4,$jlyj['ddcjjl'],'抽奖奖励积分'.$v['orderid'],$v['orderid']);
					    $sj=rand(0,7);
						if(empty($cfg['hztype'])){
							$jftype="积分";
						}else{
							$jftype=$cfg['hztype'];
						}					
						$data=array(
							'prize'=>"恭喜你抽中".$jlyj['ddcjjl'].$jftype,
							'giftid'=>6,
							'stoped'=>$sj
						);
						exit(json_encode($data));
				}
				
			}else{//修改状态
				if($cfg['cjlxtype']==1){//余额
					$jltype=1;
					$resup=pdo_update($this->modulename . "_order",array('cjdd'=>1,'jltype'=>$jltype,'jl'=>$jlyj['ddcjjl']), array ('id'=>$order['id'],'uid' =>$uid,'weid'=>$_W['uniacid'],'itemid'=>$order['itemid']));
					if($resup!='false'){
						$sj=rand(0,7);
						if(empty($cfg['yetype'])){
							$jftype="余额";
						}else{
							$jftype=$cfg['yetype'];
						}
						
						$data=array(
							'prize'=>"恭喜你抽中".$jlyj['ddcjjl'].$jftype.'，订单确认收货后，将自动到帐！',
							'giftid'=>6,
							'stoped'=>$sj
						);
						exit(json_encode($data));
					}else{
						$data=array(
							'prize'=>'服务器维护中！',
							'giftid'=>6,
							'stoped'=>$sj
						);
						exit(json_encode($data));
					}
				}else{//积分
					$jltype=0;
					$resup=pdo_update($this->modulename . "_order",array('cjdd'=>1,'jltype'=>$jltype,'jl'=>$jlyj['ddcjjl']), array ('id'=>$order['id'],'weid'=>$_W['uniacid']));
					if($resup!='false'){
					    $sj=rand(0,7);
						if(empty($cfg['hztype'])){
							$jftype="积分";
						}else{
							$jftype=$cfg['hztype'];
						}					
						$data=array(
							'prize'=>"恭喜你抽中".$jlyj['ddcjjl'].$jftype.'，订单确认收货后，将自动到帐！',
							'giftid'=>6,
							'stoped'=>$sj
						);
						exit(json_encode($data));
					}else{
						$data=array(
							'prize'=>'服务器维护中！',
							'giftid'=>6,
							'stoped'=>$sj
						);
						exit(json_encode($data));
					}
				}
				
			}

			
			
			
		}
	

		
}






?>