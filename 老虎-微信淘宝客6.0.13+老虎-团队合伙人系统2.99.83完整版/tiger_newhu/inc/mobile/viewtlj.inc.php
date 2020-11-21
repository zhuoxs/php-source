<?php
global $_W;
        global $_GPC;
				$cfg = $this->module['config'];
        $itemid=$_GPC['itemid'];
				$yj=$_GPC['yj'];
				$pid=$_GPC['pid'];
				$pic=$_GPC['pic'];
				$title=$_GPC['title'];
				
				$yjprice=intval($cfg['tljfl']*$yj/100);
				if($yjprice<1){
					$yjprice=1;
				}
	
				if($yjprice>5){
					die(json_encode(array("err"=>1,'message'=>'该商品暂不支持淘礼金活动！')));  
				}
				
				
				
			
				      $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
				      include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
				      
				      $res=tlj($cfg,$pid,$itemid,$tksign['sign'],$yjprice);
							
							if($res['result']['success']=="false"){
								 die(json_encode(array("err"=>1,'message'=>$res['result']['msg_info'],'kl'=>'失败'))); 
							}else{
								 $taokouling=$this->tkl($res['result']['model']['send_url'],$pic,$cfg['tljtitle']);
// 								 $msg.="口令：".$taokouling."<br>";
// 								 $ddwz=$this->dwzw($res['result']['model']['send_url']);
// 								 $msg.="短网址：".$ddwz;
								 die(json_encode(array("err"=>0,'message'=>'','kl'=>$taokouling))); 

							}
	

