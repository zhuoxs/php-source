<?php
global $_W, $_GPC;
        $fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}'  order by px desc");
        $op=$_GPC['op'];
        if($op=='hl'){
            if (checksubmit()){
                $id = $_GPC['id'];
                $hlcid = $_GPC['hlcid'];
                $dtkarr = '';
                foreach ($hlcid as $key => $value) {
                    if (empty($value)) continue;
                    $dtkarr[] = array('id'=>$id[$key],'hlcid'=>$value);
                }

                foreach($dtkarr as $v){
                    pdo_update($this->modulename."_fztype", array('hlcid'=>$v['hlcid']), array('id' => $v['id']));             
                }
                message ( '更新成功');            
            }        
        }

		include $this->template ( 'hlcaijiset' );