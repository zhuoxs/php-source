<?php
global $_W,$_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_news") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，新闻不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['title'])){
                    message('请输入新闻名称！');
                }
                $data = array(
                    'weid' => $_W['uniacid'], 
                    'title' => $_GPC['title'], 
                    'pttype' => $_GPC['pttype'], 
                    'url' => $_GPC['url'], 
                    'px' => $_GPC['px'], //分类ID
                    'type' => $_GPC['type'], //1 H5链接  2APP分类
                    'content' => $_GPC['content'], 
                    'createtime' => TIMESTAMP,
                    );      
                         
                if (!empty($id)){
                    pdo_update($this->modulename."_news", $data, array('id' => $id));
                }else{
                    $inse=pdo_insert($this->modulename."_news", $data);

                }
                message('新闻更新成功！', $this -> createWebUrl('news', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_news") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，新闻' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_news", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_news") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY id desc");
           
        }
        include $this -> template('news');
        ?>