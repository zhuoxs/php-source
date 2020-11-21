<?php
global $_W, $_GPC;
     $cfg=$this->module['config'];

     $weid = $_W['uniacid'];
     

   
     $type=$_GPC['type'];
     if($type==1){
        pdo_update($this->modulename . "_share", array('cqtype' =>1), array('weid' =>$weid));
        message('批量设置查券成功!', $this->createWebUrl('share'), 'success');
     }else{
        pdo_update($this->modulename . "_share", array('cqtype' =>0), array('weid' =>$weid));
        message('批量【取消】查券成功!',$this->createWebUrl('share'),'success');
     }

     ?>