<?php
 global $_W,$_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        
        if($operation=='cj'){
        	include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/jd.php"; 
					$jdset=pdo_fetch("select * from ".tablename('tuike_jd_jdset')." where weid='{$_W['uniacid']}' order by id desc");
					$jdsign=pdo_fetch("select * from ".tablename('tuike_jd_jdsign')." where weid='{$_W['uniacid']}' order by id desc");
					
// 					echo "<pre>";
// 					print_r($jdset);
// 					print_r($jdsign);
// 					exit;
					
					
					for ($x=1; $x<=$_GPC['num']; $x++) {
						$tgwname=rand(1111,9999)."_".time().$x;
						$tgw=gettgw($jdsign['access_token'],$jdset['unionid'],$tgwname,$jdset['jdkey']);
						$tgwid=$tgw['data']['resultList'][$tgwname];//对应代理推广位
						if(empty($tgwid)){
								message('创建失败，用户：'.$v['id'].$tgw['message'], $this -> createWebUrl('jdpidlist', array('op' => 'display')), 'error');
						}
						$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_jdpid") . " weid='{$_W['uniacid']}' and pid='{$tgwid}'");
						if(empty($item)){
							$data=array(
								'weid'=>$_W['uniacid'],
								'pid'=>$tgwid,
								'tgwname'=>$tgwname,
								'createtime'=>time(),
								'type'=>0,
							);
							pdo_insert($this->modulename."_jdpid", $data);					
						}					
					} 		
				
							
					message('PID创建成功！', $this -> createWebUrl('jdpidlist', array('op' => 'display')), 'success');
        }
        
        
        
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_jdpid") . " WHERE id = :id" , array(':id' => $id));
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
                    pdo_update($this->modulename."_jdpid", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_jdpid", $data);
                }
                message('PID更新成功！', $this -> createWebUrl('pddpidlist', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_jdpid") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，PID' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_jdpid", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            $condition = '';          
            $pindex = max(1, intval($_GPC['page']));
		    $psize =50; 
            $list=pdo_fetchall("select * from ".tablename($this->modulename."_jdpid")." where weid='{$_W['uniacid']}' order by id desc limit " . ($pindex - 1) * $psize . ",{$psize}");
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->modulename."_jdpid")." where weid='{$_W['uniacid']}' order by id desc");
			$pager = pagination($total, $pindex, $psize); 
           
        }
        include $this -> template('jdpidlist');
?>