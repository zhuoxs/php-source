<?php
global $_W,$_GPC;
        $op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $id = intval($_GPC['id']);
        $cfg=$this->module['config']; 
        $row = pdo_fetch("SELECT * FROM " . tablename($this->modulename.'_txlog')." where weid='{$_W['uniacid']}' and id='{$id}'");
        if($op=="display"){

            $pindex = max(1, intval($_GPC['page']));
		    $psize = 20;  
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_txlog") . " s WHERE weid = '{$_W['uniacid']}' ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_txlog')." where weid='{$_W['uniacid']}'");
		    $pager = pagination($total, $pindex, $psize);   
		    $data = array();
		    foreach ($list as $k=>$value) {
				$share = pdo_fetch('select * from '.tablename($this->modulename."_share")."  where weid='{$_W['uniacid']}' and id='{$value['uid']}'");
				$data[$k]['tname'] = $share['tname'];
	            $data[$k]['nickname'] = $value['nickname'];
	            $data[$k]['openid'] = $value['openid'];
	            $data[$k]['zfbuid'] = $value['zfbuid'];
	            $data[$k]['credit2'] = $value['credit2'];
	            $data[$k]['sh'] = $value['sh'];
	            $data[$k]['addtime'] = $value['addtime'];
	            $data[$k]['createtime'] = $value['createtime'];
	            $data[$k]['id'] = $value['id'];
	        }
	       
        }elseif($op=="delete"){
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_txlog") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_txlog", array('id' => $id));
            message('删除成功！', referer(), 'success');        
        }elseif($op=="post"){
            $dmch_billno=random(10). date('Ymd') . random(3);//订单号
            if($cfg['txtype']==0){
               $msg=$this->post_txhb($cfg,$row['openid'],$row['credit2']*100,$desc,$dmch_billno);//现金红包
            }elseif($cfg['txtype']==1){
               $msg=$this->post_qyfk($cfg,$row['openid'],$row['credit2']*100,$desc,$dmch_billno);//企业零钱付款
            }
            if($msg['message']=='success'){
                 pdo_update($this->modulename."_txlog", array('dmch_billno'=>$dmch_billno,'addtime'=>time(),'sh'=>1), array('id' => $id));
                 message('发送成功', referer(), 'success');                  
            }else{
                 message('发送失败，错误代码：'.$msg['message'], referer(), 'success');
            }          
        }elseif($op=="zfbpost"){
            $dmch_billno=random(10). date('Ymd') . random(3);//订单号
            pdo_update($this->modulename."_txlog", array('dmch_billno'=>$dmch_billno,'addtime'=>time(),'sh'=>1), array('id' => $id));
            message('支付宝（集分宝）审核成功', referer(), 'success'); 
          
        }elseif($op=="seach"){

            $key=$_GPC['key'];
            if (!empty($key)){
              $where .= " and  (nickname like '%{$key}%' or openid = '{$key}') ";
            }
            $pindex = max(1, intval($_GPC['page']));
		    $psize = 20;  
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_txlog") . " s WHERE weid = '{$_W['uniacid']}' {$where} ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_txlog')." where weid='{$_W['uniacid']}' {$where}");
		    $pager = pagination($total, $pindex, $psize);   
		    $data = array();
		    foreach ($list as $k=>$value) {
				$share = pdo_fetch('select * from '.tablename($this->modulename."_share")."  where weid='{$_W['uniacid']}' and id='{$value['uid']}'");
				$data[$k]['tname'] = $share['tname'];
	            $data[$k]['nickname'] = $value['nickname'];
	            $data[$k]['openid'] = $value['openid'];
	            $data[$k]['zfbuid'] = $value['zfbuid'];
	            $data[$k]['credit2'] = $value['credit2'];
	            $data[$k]['sh'] = $value['sh'];
	            $data[$k]['addtime'] = $value['addtime'];
	            $data[$k]['createtime'] = $value['createtime'];
	            $data[$k]['id'] = $value['id'];
	        }
	        
	        
          
        }


        include $this->template ('txsh');