<?php
global $_W, $_GPC;
if(empty($_GPC['i'])){
 exit("1");
}
        $ck=$_GPC['ck'];
        $taock=$_GPC['taock'];
        $od=pdo_fetch("select * from ".tablename($this->modulename."_ck")." where weid='{$_W['uniacid']}'");

        
        if(empty($od)){
            $data=array(
                'data'=>$ck,
                'taodata'=>$taock,
                'weid'=>$_W['uniacid'],
                'createtime'=>TIMESTAMP,
            );
           pdo_insert($this->modulename."_ck",$data);
        }else{
            $data=array(
                'data'=>$ck,
                'taodata'=>$taock,
                'createtime'=>TIMESTAMP,
            );
           pdo_update($this->modulename."_ck", $data, array('weid' => $od['weid']));
        }
        exit("2");