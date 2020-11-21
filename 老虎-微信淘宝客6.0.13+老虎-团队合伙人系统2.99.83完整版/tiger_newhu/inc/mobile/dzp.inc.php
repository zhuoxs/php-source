<?php
  global $_W, $_GPC;
      $weid=$_W['uniacid'];
      $uid=$_GPC['uid'];
      $cfg=$this->module['config']; 
      
      
    include $this -> template('dzp');
?>