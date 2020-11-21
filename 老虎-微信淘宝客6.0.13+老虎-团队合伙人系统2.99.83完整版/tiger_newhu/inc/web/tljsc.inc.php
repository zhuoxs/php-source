<?php
global $_W;
        global $_GPC;
        $itemid=$_GPC['itemid'];
				$cfg = $this->module['config'];
				
				
				
				if($_GPC['op']=='seach'){
				      $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
				      include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
				      
							
							$cfg['tljtitle']=$_GPC['name1'];
							$cfg['tljsx']=$_GPC['user_total_win_num_limit'];
							$cfg['tljsum']=$_GPC['total_num'];
							$price=$_GPC['per_face'];
							
				      $res=tlj($cfg,$cfg['ptpid'],$itemid,$tksign['sign'],$price);
							
							if($res['result']['success']==false){
								 $err=$res['result']['msg_info'];
							}else{
								 $msg="你的推广长链接是:".$res['result']['model']['send_url']."<br>";								 
								 $taokouling=$this->tkl($res['result']['model']['send_url'],tomedia($cfg['logo']),$cfg['tljtitle']);
								 $msg.="口令：".$taokouling."<br>";
								 $ddwz=$this->dwzw($res['result']['model']['send_url']);
								 $msg.="短网址：".$ddwz;

							}
	
							
				}  
				
				
				include $this->template ( 'tljsc' );  
