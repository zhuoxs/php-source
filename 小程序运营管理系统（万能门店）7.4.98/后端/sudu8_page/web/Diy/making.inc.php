<?php 

define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page/');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
 $_W['page']['title'] = '一键模板';
    $uniacid = $_W['uniacid'];
    if (checksubmit('submit')) {
    	
        include ROOT_PATH.'making.php';
        $making_tmp = $_GPC['making_tmp'];
        $making = new Making();  
        $return=$making->making_do($uniacid,$making_tmp);  
        if($return == 1){
            message('一键制作成功!', $this->createWebUrl('Diy', array('op'=>'making','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }
    }
return include self::template('web/Diy/making');