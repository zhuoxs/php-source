<?php
global $_W, $_GPC;
     $cfg=$this->module['config'];
   
     $type=$cfg['type'];
     if($type==1){
        pdo_update($this->modulename."_share", array('cqtype'=>1), array('weid' => $_W['uniacid']));
         message('批量设置查券成功');
     }else{
        pdo_update($this->modulename."_share", array('cqtype'=>0), array('weid' => $_W['uniacid']));
        message('批量设置取消查券成功');
     }
     ?>