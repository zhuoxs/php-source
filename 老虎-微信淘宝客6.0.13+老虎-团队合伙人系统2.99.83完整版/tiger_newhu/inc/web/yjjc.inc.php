<?php
 global $_W, $_GPC;
        $cfg = $this->module['config'];
        $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
        include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
        $num_iid=$_GPC['key'];
        if(empty($num_iid)){
           $msg='请输入商品ID';
        }
        if($_GPC['jx']==1){
					$kl=$_GPC['kl'];
					
					$data=$this->tkljx($kl);
					echo "<pre>";
					print_r($data);
					exit;
				}
        if($_GPC['op']=='seach'){
           $ck = pdo_fetch("SELECT * FROM ".tablename($this->modulename . '_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
           $myck=$ck['data'];
           $turl="https://item.taobao.com/item.htm?id=".$num_iid;
           $res=hqyongjin($turl,$ck,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W,1,$num_iid);
           //$res=hqyongjin($turl,$ck,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W); 
//           echo '<pre>';
//           print_r($res);
			
        }     
        
                    
       
       
       include $this->template ( 'yjjc' );  
?>