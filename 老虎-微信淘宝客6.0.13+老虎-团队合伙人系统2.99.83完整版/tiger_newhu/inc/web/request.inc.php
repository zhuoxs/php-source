<?php
global $_W, $_GPC;
        load()->model('mc');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display_new';
        if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM " . tablename($this -> table_request) . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，编号为' . $id . '的兑换请求不存在或是已经被删除！');
            }else if ($row['status'] != 'done'){
                message('未兑换商品无法删除。请兑换后删除！', referer(), 'error');
            }
            pdo_delete($this -> table_request, array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'do_goods'){
            $data = array('status' => 'done');
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM " . tablename($this -> table_request) . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，编号为' . $id . '的兑换请求不存在或是已经被删除！');
            }
            //echo '<pre>';
            //print_r($row);
            //exit;

            $cfg=$this->module['config']; 
            $goods_info = pdo_fetch("SELECT * FROM " . tablename($this -> table_goods) . " WHERE goods_id = {$row['goods_id']} AND weid = '{$_W['weid']}'");
            if($goods_info['type']==9){
                $dmch_billno=random(10). date('Ymd') . random(3);//订单号
                if($cfg['txtype']==0){
                  $msg=$this->post_txhb($cfg,$row['from_user'],$row['fxprice']*100,$desc,$dmch_billno);//现金红包
                }elseif($cfg['txtype']==1){
                  $msg=$this->post_qyfk($cfg,$row['from_user'],$row['fxprice']*100,$desc,$dmch_billno);//企业零钱付款
                }
                if($msg['message']=='success'){
                     pdo_update($this -> table_request, $data, array('id' => $id));
                     pdo_insert('tiger_newhu_paylog',array("uniacid"=>$_W["uniacid"],"dwnick"=>$row['realname'],"dopenid"=>$row['openid'],"dtime"=>time(),"dcredit"=>$row['cost'],"dtotal_amount"=>$row['fxprice']*100,"dmch_billno"=>$dmch_billno,"dissuccess"=>1,"dresult"=>''));  
                     message('发送成功', referer(), 'success');                  
                }else{
                      message('发送失败，错误代码：'.$msg['message'], referer(), 'success');
                }
                exit;            
            }

            if($goods_info['type']==5 ||$goods_info['type']==8 ){//审核红包操作
                $dmch_billno=random(10). date('Ymd') . random(3);//订单号
                if($cfg['txtype']==0){
                  $msg=$this->post_txhb($cfg,$row['from_user'],$row['price']*100,$desc,$dmch_billno);//现金红包
                }elseif($cfg['txtype']==1){
                  $msg=$this->post_qyfk($cfg,$row['from_user'],$row['price']*100,$desc,$dmch_billno);//企业零钱付款
                }
                 if($msg['message']=='success'){
                     pdo_update($this -> table_request, $data, array('id' => $id));
                     pdo_insert($this->modulename."_paylog",array("uniacid"=>$_W["uniacid"],"dwnick"=>$row['realname'],"dopenid"=>$row['openid'],"dtime"=>time(),"dcredit"=>$row['cost'],"dtotal_amount"=>$row['price']*100,"dmch_billno"=>$dmch_billno,"dissuccess"=>1,"dresult"=>''));  
                     message('发送成功', referer(), 'success');                  
                }else{
                      message('发送失败，错误代码：'.$msg['message'], referer(), 'success');
                }
                exit;
            }
            
            pdo_update($this -> table_request, $data, array('id' => $id));
            message('审核通过', referer(), 'success');

        }else if ($operation == 'display_new'){            
            if (checksubmit('batchsend')){
                foreach ($_GPC['id'] as $id){
                    $data = array('status' => 'done');
                    $row = pdo_fetch("SELECT id FROM " . tablename($this -> table_request) . " WHERE id = :id", array(':id' => $id));
                    if (empty($row)){
                        continue;
                    }
                    pdo_update($this -> table_request, $data, array('id' => $id));
                }
                message('批量兑换成功!', referer(), 'success');
            }
            $condition = '';
            if (!empty($_GPC['name'])){
                $kw = $_GPC['name'];
                $condition .= "  AND (t1.from_user_realname like '%" . $kw . "%' OR  t1.mobile like '%" . $kw . "%' OR t1.realname like '%" . $kw . "%' OR t1.residedist like '%" . $kw . "%') ";
            }
            $pindex = max(1, intval($_GPC['page']));
		    $psize = 10;
            $sql = "SELECT t1.*,t2.title,t2.fxprice FROM " . tablename($this -> table_request) . "as t1 LEFT JOIN " . tablename($this -> table_goods) . " as t2 " . " ON  t2.goods_id=t1.goods_id AND t2.weid=t1.weid AND t2.weid='{$_W['weid']}' WHERE t1.weid = '{$_W['weid']}'  " . $condition . " ORDER BY t1.createtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}";
            
            $list = pdo_fetchall($sql);
            $ar = pdo_fetchall($sql, array());
            $fanskey = array();
            foreach ($ar as $v){
                $fanskey[$v['from_user']] = 1;
            }
            $total = pdo_fetchcolumn("SELECT t1.*,t2.title,t2.fxprice FROM " . tablename($this -> table_request) . "as t1 LEFT JOIN " . tablename($this -> table_goods) . " as t2 " . " ON  t2.goods_id=t1.goods_id AND t2.weid=t1.weid AND t2.weid='{$_W['weid']}' WHERE t1.weid = '{$_W['weid']}'  " . $condition . " ORDER BY t1.createtime DESC");
		    $pager = pagination($total, $pindex, $psize);
            $fans = mc_fetch(array_keys($fanskey), array('realname', 'mobile', 'residedist', 'alipay'));
            load() -> model('mc');
        }else{
            $condition = '';
            if (!empty($_GPC['name'])){
                $kw = $_GPC['name'];
                $condition .= "  AND (t1.from_user_realname like '%" . $kw . "%' OR  t1.mobile like '%" . $kw . "%' OR t1.realname like '%" . $kw . "%' OR t1.residedist like '%" . $kw . "%') ";
            }
            $pindex = max(1, intval($_GPC['page']));
		    $psize = 10;
            $sql = "SELECT t1.*,t2.title,t2.fxprice FROM " . tablename($this -> table_request) . "as t1 LEFT JOIN " . tablename($this -> table_goods) . " as t2 " . " ON  t2.goods_id=t1.goods_id AND t2.weid=t1.weid AND t2.weid='{$_W['weid']}' WHERE t1.weid = '{$_W['weid']}'  " . $condition . " ORDER BY t1.createtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}";
            
            $list = pdo_fetchall($sql);
            $ar = pdo_fetchall($sql, array());
            $fanskey = array();
            foreach ($ar as $v){
                $fanskey[$v['from_user']] = 1;
            }
            $total = pdo_fetchcolumn("SELECT t1.*,t2.title,t2.fxprice FROM " . tablename($this -> table_request) . "as t1 LEFT JOIN " . tablename($this -> table_goods) . " as t2 " . " ON  t2.goods_id=t1.goods_id AND t2.weid=t1.weid AND t2.weid='{$_W['weid']}' WHERE t1.weid = '{$_W['weid']}'  " . $condition . " ORDER BY t1.createtime DESC");
		    $pager = pagination($total, $pindex, $psize);
            $fans = mc_fetch(array_keys($fanskey), array('realname', 'mobile', 'residedist', 'alipay'));
            
        }
        include $this -> template('request');