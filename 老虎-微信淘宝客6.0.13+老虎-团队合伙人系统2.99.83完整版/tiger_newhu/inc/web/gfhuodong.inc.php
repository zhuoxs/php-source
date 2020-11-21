<?php
global $_W;
        global $_GPC;
        load ()->func ( 'tpl' );
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $news= pdo_fetch("SELECT * FROM " . tablename($this->modulename."_gfhuodong") . " WHERE weid = :weid" , array(':weid' => $_W['uniacid']));
        //print_r($hgoods);
        //exit;
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_gfhuodong") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['title'])){
                    message('请输入名称！');
                }
                $data = array(
                    'weid' => $_W['weid'], 
                    'title' => $_GPC['title'], 
                    'px' => $_GPC['px'], 
                    'type' => $_GPC['type'], 
                    'picurl' => $_GPC['picurl'], 
                    'turl' => $_GPC['turl'], 
                    'kouling' => $_GPC['kouling'], 
                    'createtime' => TIMESTAMP,
                    );
               
                if (!empty($id)){
                    pdo_update($this->modulename."_gfhuodong", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_gfhuodong", $data);
                }
                message('更新成功！', $this -> createWebUrl('gfhuodong', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_gfhuodong") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，内容' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_gfhuodong", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            if (checksubmit()){
                if (!empty($_GPC['displayorder'])){
                    foreach ($_GPC['displayorder'] as $id => $displayorder){
                        pdo_update($this->modulename."_fztype", array('displayorder' => $displayorder), array('id' => $id));
                    }
                    message('排序更新成功！', referer(), 'success');
                }
            }
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_gfhuodong") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY px ASC");
           
        }
        include $this -> template('gfhuodong');