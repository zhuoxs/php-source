<?php
 global $_W, $_GPC;
        $op=$_GPC['op'];
        $dtime=time();

        //echo date('Y-m-d H:i:s','1478653147');
        //exit;
        if(empty($_W['uniacid'])){
           message ('操作错误，uniacid必需填写');
        }

        if($op=='xjdq'){//下架到期优惠券
            //pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tbgoods") . " WHERE weid = '{$_W['uniacid']}' and  num_iid='{$v['GoodsID']}' ORDER BY px desc");  
           // $ree=pdo_query("UPDATE ".tablename($this->modulename."_newtbgoods")." SET  WHERE weid = '{$_W['uniacid']}' and couponendtime<>'' and couponendtime<{$dtime}");
           	$ree=pdo_query("DELETE  FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and couponendtime<>'' and couponendtime<{$dtime}");  
            if($ree){
              message ('下架成功！');
            }else{
              message ('暂无到期优惠券');
            }
        }elseif($op=='qkdq'){//清空到期优惠券
            $ree=pdo_query("DELETE  FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and couponendtime<>'' and couponendtime<{$dtime}");  
            if($ree){
              message ('清空成功');
            }else{
              message ('暂无到期优惠券');
            }
        
        }elseif($op=='xjw'){//下架无优惠券
            //$ree=pdo_query("UPDATE ".tablename($this->modulename."_newtbgoods")." WHERE weid = '{$_W['uniacid']}' and couponendtime=''");
            $ree=pdo_query("DELETE  FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and couponendtime=''");
            if($ree){
              message ('下架成功！');
            }else{
              message ('暂无到期优惠券');
            }

        }elseif($op=='qkw'){//清空无优惠券
            $ree=pdo_query("DELETE  FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and couponendtime=''");
            $ree=pdo_query("DELETE  FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and couponendtime=0");
            //$ree=pdo_delete($this->modulename."_tbgoods",array('weid'=>$_W['uniacid'],'coupons_end'=>''));
            if($ree){
              message ('清空成功');
            }else{
              message ('暂无到期优惠券');
            }

        }elseif($op=='qk'){//清空所有数据
            //$ree=pdo_query("DELETE  FROM " . tablename($this->modulename."_tbgoods") . " WHERE weid = '{$_W['uniacid']}'");  
            $ree=pdo_delete($this->modulename."_newtbgoods",array('weid'=>$_W['uniacid']));
            if($ree){
              message ('所有商品删除成功');
            }else{
              message ('暂无没有商品');
            }

        }elseif($op=='qktkl'){//清空所有数据
            $ree=pdo_query("UPDATE ".tablename($this->modulename."_newtbgoods")." SET taokouling='' WHERE weid = '{$_W['uniacid']}'");
            if($ree){
              message ('清除淘口令成功！');
            }else{
              message ('暂无淘口令可清除');
            }

        }elseif($op=='qfksp'){//清空所有数据
            $ree=pdo_query("DELETE  FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and qf=1");  
            if($ree){
              message ('删除群发库商品成功！');
            }else{
              message ('暂无群发库商品');
            }

        }elseif($op=='ycq'){//清空所有数据
        	$where=" and couponurl like '%shop%'";
            $ree=pdo_query("DELETE  FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' {$where}");  
            
             if($ree){
              message ('清空成功');
            }else{
              message ('暂无隐藏优惠券');
            }

        }
