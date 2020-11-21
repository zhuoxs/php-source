<?php
global $_W,$_GPC;

        load ()->func ( 'tpl' );
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
			$item=pdo_fetch("SELECT * FROM " . tablename($this->modulename."_xcxsend") . " WHERE id = :id", array(':id' => $id));
            if (checksubmit('submit')){
            	 $arr=strstr($_GPC['picurl'],"http");
	             if($arr==false){
	             	$picurl=$_W['attachurl'].$_GPC['picurl'];
	             }else{
	             	$picurl=$_GPC['picurl'];
	             }
                $data = array(
                    'weid' => $_W['weid'], 
                    'kfkey' => $_GPC['kfkey'], 
                    'type' => $_GPC['type'], 
                    'title' => $_GPC['title'], 
                    'content' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC['content']),ENT_QUOTES), 
                    'url' => $_GPC['url'], 
                    'picurl' => $picurl,                 
                    'createtime' => TIMESTAMP,);

                if (!empty($id)){
                    pdo_update($this->modulename."_xcxsend", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_xcxsend", $data);
                }
                message('更新成功！', $this -> createWebUrl('xcxsend', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_xcxsend") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，信息' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_xcxsend", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            if (checksubmit()){
                if (!empty($_GPC['displayorder'])){
                    foreach ($_GPC['displayorder'] as $id => $displayorder){
                        pdo_update($this->modulename."_xcxsend", array('displayorder' => $displayorder), array('id' => $id));
                    }
                    message('排序更新成功！', referer(), 'success');
                }
            }
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_xcxsend") . " where weid = '{$_W['uniacid']}'  order by id desc");
            

        }
        include $this -> template('xcxsend');