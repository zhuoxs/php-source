<?php
 global $_W, $_GPC;
         $uid=$_GPC['uid'];
         $scene_id=$_GPC['scene_id'];//上级
         $from_user=$_GPC['from_user'];//当前用户openid
         //echo '<pre>';
         //print_r($_GPC);
         //exit;
       //位置开始
         $ip = $this->getIp();
         $settings=$this->module['config'];
         $ip=$this->GetIpLookup($ip);
         $province=$ip['province'];//省
         $city=$ip['city'];//市
         $district=$ip['district'];//县
         //echo '<pre>';
         //print_r($settings);
         //exit;
         //print_r (explode(",",$settings['city']));
       //exit;

       include $this->template('fwdiqu');
?>