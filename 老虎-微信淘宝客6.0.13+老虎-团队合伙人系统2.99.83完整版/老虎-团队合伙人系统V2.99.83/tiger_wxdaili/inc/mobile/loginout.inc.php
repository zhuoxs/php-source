<?php
global $_W, $_GPC;

  session_unset();
		session_destroy();
        $url=$this->createMobileurl('dllogin');
        ddmessage('退出登录成功',$url);

        function ddmessage($msg,$url){
           echo "<div style='font-size:35px;' >".$msg."</a></div>";
           //sleep(3); 
           header("Refresh:2;url=".$url."");
        }
?>