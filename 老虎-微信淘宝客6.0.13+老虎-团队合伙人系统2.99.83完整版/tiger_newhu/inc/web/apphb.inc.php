<?php
 global $_W;
        global $_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename("tiger_app_hb") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，海报不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['pic'])){
                    message('背景图片必须上传！');
                }
                $data = array(
                    'weid' => $_W['uniacid'], 
                    'pic' => $_GPC['pic'], 
                    'createtime' => TIMESTAMP,);               
                if (!empty($id)){
                    pdo_update("tiger_app_hb", $data, array('id' => $id));
                }else{
                    pdo_insert("tiger_app_hb", $data);
                }
                message('海报更新成功！', $this -> createWebUrl('apphb', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename("tiger_app_hb") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，海报' . $id . '不存在或是已经被删除！');
            }
            pdo_delete("tiger_app_hb", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename("tiger_app_hb") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY id desc");
        }
        include $this -> template('apphb');
?>