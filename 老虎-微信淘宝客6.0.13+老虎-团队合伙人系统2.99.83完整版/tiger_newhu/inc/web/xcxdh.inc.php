<?php
global $_W;
        global $_GPC;
        $cfg = $this->module['config'];
        if($cfg['mmtype']==2){//云商品库
        	include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
        	$fzlist=getclass($_W,$cfg['ptpid'],'');//全部分类
        }else{
        	$fzlist = pdo_fetchall("select * from ".tablename("tiger_newhu_fztype")." where weid='{$_W['uniacid']}'  order by px desc");
        }
        
        
        
        
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_xcxdh") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，广告不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['title'])){
                    message('请输入广告名称！');
                }
                $data = array(
                    'weid' => $_W['uniacid'], 
                    'title' => $_GPC['title'], 
                    'ftitle' => $_GPC['ftitle'], 
                    'fztype' => $_GPC['fztype'], //1 首页  2 会员中心
                    'url' => $_GPC['url'], 
                    'pic' => $_GPC['pic'], 
                    'hd' => $_GPC['hd'], 
                    'kfkey' => $_GPC['kfkey'], 
                    'xcxpage'=>$_GPC['xcxpage'],
                    'fqcat' => $_GPC['fqcat'], //分类ID
                    'type' => $_GPC['type'], //1 H5链接  2APP分类     
                    'appid' => $_GPC['appid'],              
                    'createtime' => TIMESTAMP,);               
                if (!empty($id)){
                    pdo_update($this->modulename."_xcxdh", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_xcxdh", $data);
                }
                message('图标更新成功！', $this -> createWebUrl('xcxdh', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_xcxdh") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，图标/广告' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_xcxdh", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_xcxdh") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY id desc");           
        }
        include $this -> template('xcxdh');