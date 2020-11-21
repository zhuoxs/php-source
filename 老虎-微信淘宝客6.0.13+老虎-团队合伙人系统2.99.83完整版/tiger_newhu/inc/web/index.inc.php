<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $weid=$_W['uniacid'];
        if(!empty($cfg['gyspsj'])){
          $weid=$cfg['gyspsj'];
        }
        $goods = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename($this->modulename.'_newtbgoods')." where weid='{$weid}'");

        $fans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename($this->modulename.'_share')." where weid='{$_W['uniacid']}'");
        $qgfans = pdo_fetchcolumn("SELECT COUNT(fanid) FROM " . tablename('mc_mapping_fans')." where uniacid='{$_W['uniacid']}' and unfollowtime<>0 ");//取关
        $sdsum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename($this->modulename.'_sdorder')." where weid='{$_W['uniacid']}'");//晒单数

		include $this->template ( 'index' );
?>