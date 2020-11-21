<?php
 global $_W,$_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        
        if($operation=='cj'){
        	include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/pdd.php"; 
			$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$_W['uniacid']}'");
			$owner_name=$pddset['ddjbbuid'];
			$num=$_GPC['num'];
			$pidlist=pddtgw($owner_name,$num);
			$datalist=$pidlist['p_id_generate_response']['p_id_list'];//p_id
			foreach($datalist as $k=>$v){
				$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_pddpid") . " weid='{$_W['uniacid']}' and pid='{$v['p_id']}'");
				if(empty($item)){
					$data=array(
						'weid'=>$_W['uniacid'],
						'pid'=>$v['p_id'],
						'createtime'=>time(),
						'type'=>0,
					);
					pdo_insert($this->modulename."_pddpid", $data);					
				}
			}
			message('PID创建成功！', $this -> createWebUrl('pddpidlist', array('op' => 'display')), 'success');
			
			
			
//			echo "<pre>";
//			echo "1111";
//			print_r($datalist);
//			exit;
        }
        
        
        
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_pddpid") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，PID不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                $data = array(
                    'weid' => $_W['weid'], 
                    'type' => $_GPC['type'], //状态1 已分配
                    'nickname' => $_GPC['nickname'], //分配昵称
                    'uid'=>$_GPC['uid'],//分配会员ID'
                    'pid'=>$_GPC['pid'],//PID
                    'tgwname' => $_GPC['tgwname'], //推广位名称
                    'fptime' => $_GPC['tgwname'], //分配时间
                    'createtime' => TIMESTAMP,);               
                if (!empty($id)){
                    pdo_update($this->modulename."_pddpid", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_pddpid", $data);
                }
                message('PID更新成功！', $this -> createWebUrl('pddpidlist', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_pddpid") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，PID' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_pddpid", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            $condition = '';          
            $pindex = max(1, intval($_GPC['page']));
		    $psize =50; 
            $list=pdo_fetchall("select * from ".tablename($this->modulename."_pddpid")." where weid='{$_W['uniacid']}' order by id desc limit " . ($pindex - 1) * $psize . ",{$psize}");
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->modulename."_pddpid")." where weid='{$_W['uniacid']}' order by id desc");
			$pager = pagination($total, $pindex, $psize); 
           
        }
        include $this -> template('pddpidlist');
?>