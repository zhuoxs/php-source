<?php
global $_W,$_GPC;


        load ()->func ( 'tpl' );
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post'){
            $goods_id = intval($_GPC['goods_id']);
            if (!empty($goods_id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this -> table_goods) . " WHERE goods_id = :goods_id" , array(':goods_id' => $goods_id));
                if (empty($item)){
                    message('抱歉，兑换商品不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['title'])){
                    message('请输入兑换商品名称！');
                }
                if (empty($_GPC['cost'])){
                    message('请输入兑换商品需要消耗的积分数量！');
                }
                if (empty($_GPC['price'])){
                    message('请输入商品实际价值！');
                }
                $cost = intval($_GPC['cost']);
                $price = $_GPC['price'];
                $fxprice = $_GPC['fxprice'];
                $vip_require = intval($_GPC['vip_require']);
                $amount = intval($_GPC['amount']);
                $type = intval($_GPC['type']);
                $per_user_limit = intval($_GPC['per_user_limit']);
                $data = array(
                    'weid' => $_W['weid'], 
                    'title' => $_GPC['title'], 
                    'px' => $_GPC['px'], 
										'ordrsum'=> $_GPC['ordrsum'], 
										'ordermsg'=>$_GPC['ordermsg'], 
                    'shtype' => $_GPC['shtype'], 
                    'logo' => $_GPC['logo'], 
                    'starttime' => strtotime($_GPC ['starttime']),
                    'endtime' => strtotime($_GPC ['endtime']),
                    'amount' => $amount, 
                    'cardid'=>$_GPC['cardid'], 
                    'per_user_limit' => intval($per_user_limit), 
                    'vip_require' => $vip_require, 
                    'cost' => $cost, 
                    'day_sum' => $_GPC['day_sum'], 
                    'price' => $price, 
                    'fxprice' => $fxprice, 
                    'taokouling' =>$_GPC['taokouling'], 
                    'type' => $type, 
                    'hot' => $_GPC['hot'], 
                    'hotcolor' => $_GPC['hotcolor'], 
                    'dj_link' => $_GPC['dj_link'], 
                    'appurl' => $_GPC['appurl'], 
                    'wl_link' => $_GPC['wl_link'],
                    'content' => $_GPC['content'], 
                    'createtime' => TIMESTAMP,);
               
                if (!empty($goods_id)){
                    pdo_update($this -> table_goods, $data, array('goods_id' => $goods_id));
                }else{
                    pdo_insert($this -> table_goods, $data);
                }
                message('商品更新成功！', $this -> createWebUrl('goods', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $goods_id = intval($_GPC['goods_id']);
            $row = pdo_fetch("SELECT goods_id FROM " . tablename($this -> table_goods) . " WHERE goods_id = :goods_id", array(':goods_id' => $goods_id));
            if (empty($row)){
                message('抱歉，商品' . $goods_id . '不存在或是已经被删除！');
            }
            pdo_delete($this -> table_goods, array('goods_id' => $goods_id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            if (checksubmit()){
                if (!empty($_GPC['displayorder'])){
                    foreach ($_GPC['displayorder'] as $id => $displayorder){
                        pdo_update($this -> table_goods, array('displayorder' => $displayorder), array('goods_id' => $id));
                    }
                    message('排序更新成功！', referer(), 'success');
                }
            }
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename($this -> table_goods) . " WHERE weid = '{$_W['weid']}'  ORDER BY px ASC");
           
        }
        include $this -> template('goods');