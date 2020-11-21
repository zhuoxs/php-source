<?php
  
		global $_W, $_GPC;
		$sid = $_GPC['sid'];
		$cid = $_GPC['cid'];
		$pid = $_GPC['pid'];
		$name = $_GPC['name'];
		$uid = $_GPC['uid'];
        $weid=$_W['uniacid'];
		$status = intval($_GPC['status']);

		if (!empty($sid)){
			$where = " and helpid='{$sid}'";
		}elseif (!empty($cid)){
			$c = pdo_fetchall('select id from '.tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and helpid='{$cid}'",array(),'id');
            //print_r($c);
            $fid=implode(',',array_keys($c));
            if(!$fid){
               $fid='999999999';
            }
            //exit;
			$where = " and weid='{$_W['uniacid']}' and helpid in (".$fid.")";
		}
		if (!empty($name)) $where .= " and (nickname like '%{$name}%' or id = '{$name}' or tel = '{$name}') ";
		
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		//$credit = pdo_fetchcolumn('select credit from '.tablename($this->modulename."_poster")." where id='{$pid}'");
		//$credit = $credit?'credit2':'credit1';
		//$list = pdo_fetchall("select *,(select credit1 from ".tablename('mc_members')." where uid=s.openid ) as surplus,(select followtime from "
//					.tablename('mc_mapping_fans')." where uid=s.openid and follow='1') as follow from "
//					.tablename($this->modulename."_share")." s where openid<>'' and weid='{$_W['uniacid']}' and status={$status} {$where} order by createtime desc LIMIT " 
//                    . ($pindex - 1) * $psize . ",{$psize}");
    $list = pdo_fetchall("select * from ".tablename($this->modulename."_share")." s where weid='{$_W['uniacid']}' and status={$status} {$where} order by id desc LIMIT " 
                    . ($pindex - 1) * $psize . ",{$psize}");
                  
               
		load()->model('mc');
		foreach ($list as $key => $value) {
			//$mc = mc_fetch($value['openid']);
			//$list[$key]['nickname'] = $mc['nickname'];
			//$list[$key]['avatar'] = $mc['avatar'];
			if (empty($value['province'])){
			//	$list[$key]['province'] = $mc['resideprovince'];
				//$list[$key]['city'] = $mc['residecity'];
				//pdo_update($this->modulename."_share",array('province'=>$mc['resideprovince'],'city'=>$mc['residecity']),array('id'=>$value['id']));
			}
			
			$c = pdo_fetchall('select id from '.tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and helpid='{$value['id']}'",array(),'id');
            
			$list[$key]['l1'] = count($c);

			if ($c){
				$list[$key]['l2'] = pdo_fetchcolumn('select count(id) from '.tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and helpid in (".implode(',',array_keys($c)).")");
			}else $list[$key]['l2'] = 0;
		}

        
        
       

        $mlist=array();
        foreach($list as $k=>$v){
//           if(!empty($v['helpid'])){
//             $mc=mc_fansinfo($v['helpid']);
//           }else{
//             $mc['nickname']='';
//             $mc['uid']='';
//           }
           //$jf=mc_credit_fetch($v['openid']);
           //$jq=$this->postfansorders($v['fans_id']);
           $tjr = pdo_fetch("select id,nickname from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$v['helpid']}'");

            
           $mlist[$k]['id']=$v['id'];
           $mlist[$k]['from_user']=$v['from_user'];
           $mlist[$k]['sceneid']=$v['sceneid'];
           $mlist[$k]['uid']=$v['id'];
           $mlist[$k]['helpid']=$v['helpid'];
           $mlist[$k]['avatar']=$v['avatar'];
           $mlist[$k]['openid']=$v['from_user'];
           $mlist[$k]['nickname']=$v['nickname'];
           $mlist[$k]['follow']=$v['follow'];
           $mlist[$k]['createtime']=$v['createtime'];
           $mlist[$k]['province']=$v['province'];
           $mlist[$k]['dytype']=$v['dytype'];
           $mlist[$k]['city']=$v['city'];
           $mlist[$k]['tjrname']=$tjr['nickname']; 
           $mlist[$k]['tjrid']=$tjr['id']; 
           $mlist[$k]['sex']=$v['sex'];
           $mlist[$k]['l1']=$v['l1'];
           $mlist[$k]['l2']=$v['l2'];
        }

//      echo "<pre>";
//      print_r($mlist);
//      exit;





		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_share')." where weid='{$_W['uniacid']}' and openid<>'' and status={$status} {$where}");
		$pager = pagination($total, $pindex, $psize);
		$type = pdo_fetchcolumn("select type from ".tablename($this->modulename."_poster")." where weid='{$weid}' " );
        
		include $this->template ( 'share' );