<?php
 global $_W, $_GPC;
         $uid=$_GPC['uid'];
       //位置开始
         $ip = $this->getIp();
         $settings=$this->module['config'];
         $ip=$this->GetIpLookup($ip);
         $province=$ip['province'];//省
         $city=$ip['city'];//市
         $district=$ip['district'];//县
         //echo '<pre>';
         //print_r($ip);
         //exit;
         //print_r (explode(",",$settings['city']));
       //exit;

       include $this->template('diqu');
?>