<?php
 global $_W, $_GPC;
        $pid = $_GPC['pid'];
        $weid =$_W['uniacid'];
        $cfg=$this->module['config']; 
		$poster = pdo_fetch ( 'select * from ' . tablename ( $this->modulename . "_poster" ) . " where weid='{$weid}'" );
        $type=$_GPC['type'];
        $id=$_GPC['id'];
        //if($type==2){
          $img=$_W['siteroot'] .'addons/tiger_newhu/qrcode/mposter'.$id.'.jpg';
        //}else{
        //  $img=$_W['siteroot'] .'addons/tiger_newhu/qrcode/iposter'.$id.'.jpg';
        //}
        $mbstyle='style2';
        include $this->template (  $mbstyle.'/hbshare' );
    
?>