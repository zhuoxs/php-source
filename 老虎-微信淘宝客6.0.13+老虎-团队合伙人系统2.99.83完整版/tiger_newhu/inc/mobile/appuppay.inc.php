<?php
global $_GPC,$_W;
		$uid=$_GPC['uid'];
    $md=md5($uid);
    if($md<>$_GPC['md5']){
			$result = array("errcode" => 1, "errmsg" => '参数错误');
			die(json_encode($result));
		}

		$cfg=$this->module['config'];
        
        if(empty($uid)){
        	$result = array("errcode" => 1, "errmsg" => '用户信息不存在1');
        	die(json_encode($result));
        }
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
       
				//file_put_contents(IA_ROOT."/addons/tiger_newhu/log2--upapp.txt","\n".json_encode($_GPC),FILE_APPEND);
				if($_GPC['up']==1){
					//file_put_contents(IA_ROOT."/addons/tiger_newhu/log1--upapp.txt","\n".json_encode($_GPC),FILE_APPEND);
						$uid=$_GPC['uid'];
						$zfbuid=$_GPC['zfbuid'];
						$pcuser=$_GPC['pcuser'];
						$dlmsg=$_GPC['dlmsg'];
						$weixin=$_GPC['weixin'];
						$tname=$_GPC['tname'];
						$data=array(
							'zfbuid'=>$zfbuid,
							'weixin'=>$weixin,
							'tname'=>$tname,
							'pcuser'=>$pcuser,
							'dlmsg'=>$dlmsg,
							'dltype' =>2,		
						);				
					pdo_update ("tiger_newhu_share",$data, array ('id' =>$uid));	
					
					$order = pdo_fetch("SELECT * FROM " . tablename("tiger_wxdaili_order") . " WHERE  weid = '{$_W['uniacid']}' and orderno ='{$_GPC['orderId']}'");
					$this->jiangli($order['openid'],$order);//插入上级分佣金订单	
					
					pdo_update ("tiger_wxdaili_order",array('paystate'=>1), array('orderno'=>$_GPC['orderId'],'weid'=>$_W['uniacid']));	
					
					
					
					$result = array("error" =>0, "errmsg" => '更新成功');
				}			 
			 
			 die(json_encode($result));
			 
			 
			 
			 
			 
			 
?>