<?php
       global $_W, $_GPC;
       $itemid=$_GPC['itemid'];
       $itempic=urldecode($_GPC['itempic']);

       $itemtitle=urldecode($_GPC['itemtitle']);
       $itemendprice=$_GPC['itemendprice'];
       $couponmoney=$_GPC['couponmoney'];
       $itemprice=$_GPC['itemprice'];
       $tkl=urldecode($_GPC['tkl']);
       $rhyurl=urldecode($_GPC['rhyurl']);

       $userAgent = $_SERVER['HTTP_USER_AGENT'];
		if (!strpos($userAgent, 'MicroMessenger')) {
			Header("Location:".$rhyurl); 
		}

       
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
		    $sjlx=1;
		}else{
		   $sjlx=2;
		}


       //echo $tkl;

       include $this->template ( 'xcxbdview' );
?>