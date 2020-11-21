<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $pindex = max(1, intval($_GPC['page']));
        
        $type=$_GPC['type'];
        if($type==1){
        	$txlog="tiger_wxdaili_txlog";
        }else{
        	$txlog="tiger_newhu_txlog";
        }
        
        
        
        
        $psize = 20;
        $id=$_GPC['id'];
        $key=$_GPC['key'];
        $op=$_GPC['op'];
        $row = pdo_fetch("SELECT * FROM " . tablename($txlog)." where weid='{$_W['uniacid']}' and id='{$id}'");
        if($op=="zfbpost"){
            //$dmch_billno=date('YmdHis') . random(6);//订单号
            pdo_update($txlog, array('dmch_billno'=>$dmch_billno,'addtime'=>time(),'sh'=>1), array('id' => $id));
            message('支付宝审核成功', referer(), 'success'); 
        }elseif($op=="post"){
            $dmch_billno=random(10). date('Ymd') . random(3);//订单号
            if($_GPC['txtype']==1){
               $msg=$this->post_txhb($cfg,$row['openid'],$row['credit2']*100,$desc,$dmch_billno);//现金红包
            }elseif($_GPC['txtype']==2){
               $msg=$this->post_qyfk($cfg,$row['openid'],$row['credit2']*100,$desc,$dmch_billno);//企业零钱付款
            }
            if($msg['message']=='success'){
                 pdo_update($txlog, array('dmch_billno'=>$dmch_billno,'addtime'=>time(),'sh'=>1), array('id' => $id));
                 message('发送成功', referer(), 'success');                  
            }else{
                 message('发送失败，错误代码：'.$msg['message'], referer(), 'success');
            }          
        }
        if (!empty($key)){
          $where .= " and  (nickname like '%{$key}%' or openid = '{$key}' or uid='{$key}') ";
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;  
        $list = pdo_fetchall("SELECT * FROM " . tablename($txlog) . " s WHERE weid = '{$_W['uniacid']}' {$where} ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($txlog)." where weid='{$_W['uniacid']}' {$where}");
        $pager = pagination($total, $pindex, $psize);
        include $this->template ( 'dltxsh' );  
?>