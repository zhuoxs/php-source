<?php
  global $_W, $_GPC;
       $url=urldecode($_GPC['link']);

       $cfg = $this->module['config'];
       
       $qd=$_GPC['qd'];

//    if(is_weixin()){
//				 echo "这是微信内部浏览器";
//			}else{
//			   echo "这是微信外部浏览器";
//			}
//     
      function is_weixin(){ 
				if (strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {				
				        return true;
				}
				return false;				
			}
			

			include $this->template ('openview');
?>