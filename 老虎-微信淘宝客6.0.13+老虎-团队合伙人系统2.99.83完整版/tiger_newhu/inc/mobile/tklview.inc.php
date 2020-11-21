<?php
       global $_W, $_GPC;
	   $cfg = $this->module['config'];
       $itemid=$_GPC['itemid'];
       $itempic=urldecode($_GPC['itempic']);
       $itemtitle=urldecode($_GPC['itemtitle']);
       $itemendprice=$_GPC['itemendprice'];
       $couponmoney=$_GPC['couponmoney'];
       $itemprice=$_GPC['itemprice'];
	   $yaoqingma=$_GPC['yaoqingma'];
	   $yj=$_GPC['yj'];
       $tkl=urldecode($_GPC['tkl']);
       $rhyurl=urldecode($_GPC['rhyurl']);
	   $rhyurlbm=urlencode($rhyurl);
       $pttype=$_GPC['pttype'];

       $userAgent = $_SERVER['HTTP_USER_AGENT'];
	 
		if (!strpos($userAgent, 'MicroMessenger')) {
			//Header("Location:".$rhyurl); 
		}
		if($pttype==2){
			Header("Location:".$rhyurl); 
			
		}
		if($pttype==3){
			Header("Location:".$rhyurl); 
		}

       
		$tbview=$this->gettaogoods($itemid,$cfg);
// 		echo "<pre>";
// 		print_r($tbview['small_images']['string']);
// 		exit;
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
		    $sjlx=1;
		}else{
		   $sjlx=2;
		}


       //echo $tkl;

       include $this->template ( 'tbgoods/style88/tklview' );
?>