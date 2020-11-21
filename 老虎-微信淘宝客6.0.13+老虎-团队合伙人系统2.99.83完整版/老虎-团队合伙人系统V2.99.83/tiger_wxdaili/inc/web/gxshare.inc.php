  <?php global $_W, $_GPC;
        pdo_delete("tiger_newhu_share", array('weid'=>$_W['uniacid'],'openid' =>0));
        $ree=pdo_query("DELETE  FROM " . tablename("tiger_newhu_share") . " WHERE weid = '{$_W['uniacid']}' and openid=''");
        $ree=pdo_query("DELETE  FROM " . tablename("tiger_newhu_share") . " WHERE weid = '{$_W['uniacid']}' and openid=0");
        if($ree){
          message ('更新成功!');
        }else{
          message ('数据检测正确!不用更新');
        }
        ?>