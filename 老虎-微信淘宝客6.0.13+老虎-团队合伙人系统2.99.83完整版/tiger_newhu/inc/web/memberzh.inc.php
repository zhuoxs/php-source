<?php
  
		global $_W, $_GPC;
	    $weid=$_W['uniacid'];
		$page=intval($_GPC['page']);


        //转换后 老上级ID parentid (用的是微擎表用户ID)     新上级helpid（数据表本身的ID）

        $pindex = max(1,$page);
        $psize = 50;  

        $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_share") . " WHERE weid = '{$_W['weid']}' and helpid<>0  ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_share')." where weid='{$_W['uniacid']}' and helpid<>0");
        $pager = pagination($total, $pindex, $psize);  
        $pagesum=ceil($total/$psize);  //总页数
        

        foreach($list as $k=>$v){
            //echo "<pre>原：";
            //print_r($v);

           
            //echo "上级：";
            //print_r($sj);

            
            if(empty($v['parentid'])){
              $sj = pdo_fetch("SELECT id,nickname,openid,parentid,helpid FROM " . tablename($this->modulename."_share") . " WHERE weid = '{$_W['uniacid']}' and  openid='{$v['helpid']}'");
              $data=array(
                    'parentid'=>$v['helpid'],
                    'helpid'=>$sj['id'],
               );
              pdo_update($this->modulename."_share", $data, array('weid'=>$_W['uniacid'],'id' => $v['id']));//更新数据
            }
            
            
        }

            //$go = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_share") . " WHERE weid = '{$_W['uniacid']}' and  id='{$v['id']}'");
            //echo "修改后：";
            //print_r($go);
            //exit;


            if($page<=$pagesum){
                message('温馨提示：请不要关闭页面，数据优化正在进行中！（' . $page . '/' . $pagesum . '）', $this->createWebUrl('memberzh', array('op' => 'qcljcp','page' => $page + 1)), 'success');
            } elseif ($page == $pagesum) {
                //step6.最后一页 | 修改任务状态
               message('温馨提示：数据优化已完成！（' . $page . '/总会员：' . $total . '）', $this->createWebUrl('memberzh'), 'success');
            } else {
                //已结束
                //pdo_update('healer_tplmsg_bulk', array('status' => 2), array('uniacid' => $_W['uniacid'], 'id' => $bulk['id']));
                message('温馨提示：数据优化已完成！', $this->createWebUrl('share'), 'success');
            }

        message('温馨提示：数据优化已完成！', $this->createWebUrl('share'), 'success');