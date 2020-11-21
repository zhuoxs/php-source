<?php
global $_W,$_GPC;

        load ()->func ( 'tpl' );
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_qun") . " WHERE id = :id" , array(':id' => $id));
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
                    'keyw' => $_GPC['keyw'], 
                    'picurl' => $_GPC['picurl'], 
                    'type' => $_GPC['type'], 
                    'xzrs' => $_GPC['xzrs'], 
                    'qtype' => $_GPC['qtype'], 
                    'createtime' => TIMESTAMP,
                    );
               
                if (!empty($id)){
                    pdo_update($this->modulename."_qun", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_qun", $data);
                }
                message('更新成功！', $this -> createWebUrl('qungl', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_qun") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，内容' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_qun", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            if (checksubmit()){
                if (!empty($_GPC['displayorder'])){
                    foreach ($_GPC['displayorder'] as $id => $displayorder){
                        pdo_update($this->modulename."_qun", array('displayorder' => $displayorder), array('id' => $id));
                    }
                    message('排序更新成功！', referer(), 'success');
                }
            }
            $condition = '';
            $pindex = max(1, intval($_GPC['page']));
		    $psize = 20;  
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_qun") . " WHERE weid = '{$_W['uniacid']}' ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            foreach($list as $k=>$v){
                $list[$k]['px']=$v['px'];
                $list[$k]['title']=$v['title'];
                $list[$k]['keyw']=$v['keyw'];
                $list[$k]['xzrs']=$v['xzrs'];
                $list[$k]['tjsum']=$this->tjsum($v['id'],$_W['uniacid']);
                $list[$k]['qtype']=$v['qtype'];
                $list[$k]['type']=$v['type'];
                $list[$k]['id']=$v['id'];              
            }
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_qun')." where weid='{$_W['uniacid']}'");
            $pager = pagination($total, $pindex, $psize);    
           
        }
        include $this -> template('qungl');
?>