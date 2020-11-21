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
			$c = pdo_fetchall('select openid from '.tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and helpid='{$cid}'",array(),'openid');
            //print_r($c);
            $fid=implode(',',array_keys($c));
            if(!$fid){
               $fid='999999999';
            }
            //exit;
			$where = " and weid='{$_W['uniacid']}' and helpid in (".$fid.")";
		}
		if (!empty($name)) $where .= " and (nickname like '%{$name}%' or openid = '{$name}') ";
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$credit = pdo_fetchcolumn('select credit from '.tablename($this->modulename."_poster")." where id='{$pid}'");
		$credit = $credit?'credit2':'credit1';
		$list = pdo_fetchall("select *,(select credit1 from ".tablename('mc_members')." where uid=s.openid ) as surplus,(select followtime from "
					.tablename('mc_mapping_fans')." where uid=s.openid and follow='1') as follow from "
					.tablename($this->modulename."_share")." s where openid<>'' and weid='{$_W['uniacid']}' and status={$status} {$where} order by createtime desc LIMIT " 
                    . ($pindex - 1) * $psize . ",{$psize}");
                  //echo '<pre>';
                  //print_r($list);
                  //exit;
               
		load()->model('mc');
		foreach ($list as $key => $value) {
			$mc = mc_fetch($value['openid']);
			$list[$key]['nickname'] = $mc['nickname'];
			$list[$key]['avatar'] = $mc['avatar'];
			if (empty($value['province'])){
				$list[$key]['province'] = $mc['resideprovince'];
				$list[$key]['city'] = $mc['residecity'];
				pdo_update($this->modulename."_share",array('province'=>$mc['resideprovince'],'city'=>$mc['residecity']),array('id'=>$value['id']));
			}
			
			$c = pdo_fetchall('select openid from '.tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and openid<>'' and helpid='{$value['openid']}'",array(),'openid');
            
			$list[$key]['l1'] = count($c);

			if ($c){
				$list[$key]['l2'] = pdo_fetchcolumn('select count(id) from '.tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and openid<>'' and helpid in (".implode(',',array_keys($c)).")");
			}else $list[$key]['l2'] = 0;
		}
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_share')." where weid='{$_W['uniacid']}' and openid<>'' and status={$status} {$where}");
		$pager = pagination($total, $pindex, $psize);
		$type = pdo_fetchcolumn("select type from ".tablename($this->modulename."_poster")." where weid='{$weid}' " );
        
		include $this->template ( 'share' );