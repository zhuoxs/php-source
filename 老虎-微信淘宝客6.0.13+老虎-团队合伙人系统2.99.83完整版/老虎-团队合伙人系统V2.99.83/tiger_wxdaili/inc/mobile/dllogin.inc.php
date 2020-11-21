<?php
global $_W, $_GPC;

       if(!empty($_SESSION["pcuser"])){
           $url=$this->createMobileurl('main');
           $this->ddmessage(' ): 已经登录 请稍后……',$url);
           exit;
        }
       

       
         if (checksubmit('submit')){
            $username=trim($_GPC['pcuser']);
            //$password=md5(trim($_GPC['pcpasswords']));
            $password=trim($_GPC['pcpasswords']);

            $set= pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_share") . " WHERE pcuser='{$username}' and weid='{$_W['uniacid']}' ");

            if($username==$set['pcuser'] && $password==$set['pcpasswords']){
                $_SESSION["pcuser"]=$set['pcuser'];
                $url=$this->createMobileurl('main');
                ddmessage(' ): 登录成功 请稍后……',$url);
              }else{
                 echo '登录失败';
              }
            //print_r($_GPC);   
            exit;             
         }

        include $this->template ( '/dl/dllogin' );


        function ddmessage($msg,$url){
           echo "<div style='font-size:35px;' >".$msg."</a></div>";
           //sleep(3); 
           header("Refresh:2;url=".$url."");
        }
?>