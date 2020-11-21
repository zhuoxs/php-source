<?php
global $_W, $_GPC;
        $fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}' and (cid='' || cid is NULL)  order by px desc");
        $op=$_GPC['op'];
        if($op=='dtk'){
            if (checksubmit()){
                $id = $_GPC['id'];
				
				//echo "<pre>";
				//print_r($_GPC);
				//exit;
				
                $dtkcid = $_GPC['dtkcid'];
                $dtkarr = '';
                foreach ($dtkcid as $key => $value) {
                    //if (empty($value)) continue;
                    $dtkarr[] = array('id'=>$id[$key],'dtkcid'=>$value);
                }
				
                foreach($dtkarr as $v){
                    pdo_update($this->modulename."_fztype", array('dtkcid'=>$v['dtkcid']), array('id' => $v['id']));             
                }
				//互力
				foreach ($_GPC['hlcid'] as $key => $value) {
					//if (empty($value)) continue;
					$hlcidarr[] = array('id'=>$id[$key],'hlcid'=>$value);
				}
				foreach($hlcidarr as $v){
					pdo_update($this->modulename."_fztype", array('hlcid'=>$v['hlcid']), array('id' => $v['id']));             
				}
				//轻淘客
				foreach ($_GPC['qtktype'] as $key => $value) {
					//if (empty($value)) continue;
					$qtktypearr[] = array('id'=>$id[$key],'qtktype'=>$value);
				}
				foreach($qtktypearr as $v){
					pdo_update($this->modulename."_fztype", array('qtktype'=>$v['qtktype']), array('id' => $v['id']));             
				}
				//淘客助手
				foreach ($_GPC['tkzstype'] as $key => $value) {
					//if (empty($value)) continue;
					$tkzstypearr[] = array('id'=>$id[$key],'tkzstype'=>$value);
				}
				foreach($tkzstypearr as $v){
					pdo_update($this->modulename."_fztype", array('tkzstype'=>$v['tkzstype']), array('id' => $v['id']));             
				}
				//一手单
				foreach ($_GPC['ysdtype'] as $key => $value) {
					//if (empty($value)) continue;
					$ysdtypearr[] = array('id'=>$id[$key],'ysdtype'=>$value);
				}
				foreach($ysdtypearr as $v){
					pdo_update($this->modulename."_fztype", array('ysdtype'=>$v['ysdtype']), array('id' => $v['id']));             
				}
				//好品推
				foreach ($_GPC['hpttype'] as $key => $value) {
					//if (empty($value)) continue;
					$hpttypearr[] = array('id'=>$id[$key],'hpttype'=>$value);
				}
				foreach($hpttypearr as $v){
					pdo_update($this->modulename."_fztype", array('hpttype'=>$v['hpttype']), array('id' => $v['id']));             
				}
				
				
                message ( '更新成功');            
            }        
        }

		include $this->template ( 'caijiset' );