<?php
 global $_W;
        global $_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename("tiger_app_tuanzhangset") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，团长不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['title'])){
                    message('团长名称必须填写！');
                }
                $data = array(
                    'weid' => $_W['weid'], 
                    'title' => $_GPC['title'], 
					'px' => $_GPC['px'], 
					'sjtype' => $_GPC['sjtype'], 
					'jl' => $_GPC['jl'], 
					'rmb' => $_GPC['rmb'], 
					'fsm' => $_GPC['fsm'], 
					'ordermsum' => $_GPC['ordermsum'], 
                    'createtime' => TIMESTAMP,);               
                if (!empty($id)){
                    pdo_update("tiger_app_tuanzhangset", $data, array('id' => $id));
                }else{
                    pdo_insert("tiger_app_tuanzhangset", $data);
                }
                message('团长更新成功！', $this -> createWebUrl('tuanzhangset', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename("tiger_app_tuanzhangset") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，团长' . $id . '不存在或是已经被删除！');
            }
            pdo_delete("tiger_app_tuanzhangset", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename("tiger_app_tuanzhangset") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY id desc");
        }
        include $this -> template('tuanzhangset');
?>