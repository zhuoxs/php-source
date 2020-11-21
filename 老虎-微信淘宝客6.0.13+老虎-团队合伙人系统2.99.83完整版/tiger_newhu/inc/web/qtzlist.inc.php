<?php
global $_W;
        global $_GPC;
        load ()->func ( 'tpl' );
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $news= pdo_fetch("SELECT * FROM " . tablename($this->modulename."_qtzlist") . " WHERE weid = :weid" , array(':weid' => $_W['uniacid']));
        //print_r($hgoods);
        //exit;
        if ($operation == 'post'){
			
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_qtzlist") . " WHERE id = :id" , array(':id' => $id));
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
                    'picurl' => $_GPC['picurl'], 
                    'cate' => $_GPC['cate'], 
                    'cateid' => $_GPC['cateid'], 
                    'createtime' => TIMESTAMP,
                    );
               
                if (!empty($id)){
                    pdo_update($this->modulename."_qtzlist", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_qtzlist", $data);
                }
                message('更新成功！', $this -> createWebUrl('qtzlist', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_qtzlist") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，内容' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_qtzlist", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
//             if (checksubmit()){
//                 if (!empty($_GPC['displayorder'])){
//                     foreach ($_GPC['displayorder'] as $id => $displayorder){
//                         pdo_update($this->modulename."_qtzlist", array('displayorder' => $displayorder), array('id' => $id));
//                     }
//                     message('排序更新成功！', referer(), 'success');
//                 }
//             }
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_qtzlist") . " WHERE weid = '{$_W['uniacid']}'  ORDER by id desc");
           
        }
        include $this -> template('qtzlist');