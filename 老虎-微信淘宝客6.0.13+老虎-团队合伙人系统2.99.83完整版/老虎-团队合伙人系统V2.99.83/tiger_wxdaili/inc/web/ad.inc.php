<?php
 global $_W;
        global $_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_ad") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，广告不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['title'])){
                    message('请输入广告名称！');
                }
                $data = array(
                    'weid' => $_W['weid'], 
                    'title' => $_GPC['title'], 
                    'url' => $_GPC['url'], 
                    'type'=>$_GPC['type'],
                    'pic' => $_GPC['pic'], 
                    'createtime' => TIMESTAMP,);               
                if (!empty($id)){
                    pdo_update($this->modulename."_ad", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_ad", $data);
                }
                message('广告更新成功！', $this -> createWebUrl('ad', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_ad") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，广告' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_ad", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_ad") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY id desc");
           
        }
        include $this -> template('ad');
?>