<?php
global $_W;
        global $_GPC;
				$cfg = $this->module['config'];
				$page=$_GPC['page'];
				$pindex = max(1, intval($page));
				$psize =50;
				//$list = pdo_fetchall("SELECT id,dlptpid,nickname,from_user,unionid FROM " . tablename($this->modulename."_share") . " WHERE weid = '{$_W['uniacid']}' and dlptpid<>'' and tbkpidtype<>1  ORDER BY id desc");
				$list = pdo_fetchall("select id,dlptpid,nickname,from_user,unionid  from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and dlptpid<>'' and tbkpidtype<>1  order by id desc LIMIT ". ($pindex - 1) * $psize . ",{$psize}");
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_share')." where weid='{$_W['uniacid']}' and dlptpid<>'' and tbkpidtype<>1");
				$pager = pagination($total, $pindex, $psize);
												
				if(empty($cfg['tbuid'])){
					message('抱歉，请先云控授权，填写默认淘宝ID', $this->createWebUrl('szpid', array('op' => 'display','page' =>1)), 'error');
				}
				foreach($list as $k=>$v){
					 $indata=array(
							'weid'=>$_W['uniacid'], 
							'type'=>1,//1已分配
							'nickname'=>$v['nickname'],
							'uid'=>$v['id'],
							'pid'=>$v['dlptpid'],
							'tgwname'=>'',
							'fptime'=>time(),
							'tbuid'=>$cfg['tbuid'],
							'createtime'=>time(),
					 );
					 $ispid = pdo_fetch("SELECT * FROM " . tablename("tiger_wxdaili_tkpid") . " WHERE  weid = '{$_W['uniacid']}' and pid='{$v['dlptpid']}'");
					 if(empty($ispid)){
						 $res=pdo_insert("tiger_wxdaili_tkpid", $indata);
						 if (!empty($res)) {
						 	pdo_update($this->modulename."_share", array('tbkpidtype'=>1,'tbuid'=>$cfg['tbuid']), array('id' =>$v['id']));
						 }
					 }				 
					 
				}
				
				if(!empty($list)){
					message('温馨提示：请不要关闭页面，正在执行！（' . $page.'）', $this->createWebUrl('szpid', array('op' => 'display','page' => $page + 1)), 'error');
				}
				message('原先PID设置成功！', $this->createWebUrl('yunkong', array('op' => 'display')));
				
				echo "<pre>";
				print_r($list);
				exit;

				
			