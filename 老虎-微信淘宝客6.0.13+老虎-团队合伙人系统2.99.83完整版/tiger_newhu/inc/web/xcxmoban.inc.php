<?php
global $_W,$_GPC;
        load ()->func ( 'tpl' );
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_xcxmobanmsg") . " WHERE id = :id" , array(':id' => $id));
                $zjvalue = unserialize($item['zjvalue']);
                $zjcolor = unserialize($item['zjcolor']);
                foreach ($zjvalue as $key => $value) {
                    if (empty($value)) continue;
                    $tplist[] = array('zjvalue'=>$value,'zjcolor'=>$zjcolor[$key]);
                }

                if (empty($item)){
                    message('抱歉，兑换商品不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['title'])){
                    message('请输入模版名称！');
                }
                if (empty($_GPC['mbid'])){
                    message('请输入模版ID');
                }
                $data = array(
                    'weid' => $_W['weid'], 
                    'title' => $_GPC['title'], 
                    'mbid' => $_GPC['mbid'], 
                    'first' => $_GPC['first'], 
                    'firstcolor' => $_GPC['firstcolor'], 
                    'zjvalue' => serialize($_GPC['zjvalue']),
                    'zjcolor' => serialize($_GPC['zjcolor']),
                    'remark' => $_GPC['remark'],
                    'remarkcolor' => $_GPC['remarkcolor'],
                    'turl' => $_GPC['turl'],
                    'emphasis_keyword'=>$_GPC['emphasis_keyword'],
                    'createtime' => TIMESTAMP,);

                if (!empty($id)){
                    pdo_update($this->modulename."_xcxmobanmsg", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_xcxmobanmsg", $data);
                }
                message('模版消息更新成功！', $this -> createWebUrl('xcxmoban', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_xcxmobanmsg") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，模版' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_xcxmobanmsg", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            if (checksubmit()){
                if (!empty($_GPC['displayorder'])){
                    foreach ($_GPC['displayorder'] as $id => $displayorder){
                        pdo_update($this->modulename."_xcxmobanmsg", array('displayorder' => $displayorder), array('id' => $id));
                    }
                    message('排序更新成功！', referer(), 'success');
                }
            }
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_xcxmobanmsg") . " where weid = '{$_W['uniacid']}'  order by id desc");
            

        }
        include $this -> template('xcxmoban');