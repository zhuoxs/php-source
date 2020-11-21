<?php
global $_W, $_GPC;
		$do = 'mposter';
		if ('delete' == $_GPC['op'] && $_GPC['id']){
		 //$rid = pdo_fetchcolumn('select rid from '.tablename($this->modulename."_poster")." where id='{$_GPC['id']}'");
           $poster = pdo_fetch('select * from '.tablename($this->modulename."_poster")." where id='{$_GPC['id']}'");
			if (pdo_delete($this->modulename."_poster",array('id'=>$_GPC['id'])) === false){
				message ( '删除海报失败！' );
			}else{
				$shares = pdo_fetchall('select id from '.tablename($this->modulename."_member")." where weid='{$_W['uniacid']}'");
				foreach ($shares as $value) {
					@unlink(str_replace('#sid#',$value['id'],"../addons/tiger_newhu/qrcode/mposter#sid#.jpg"));
				}
                $r=pdo_delete('rule',array('id'=>$poster['rid']));
                pdo_delete('rule_keyword',array('rid'=>$poster['rid']));
				pdo_delete($this->modulename."_member",array('weid'=>$_W['uniacid']));
				pdo_delete('qrcode',array('keyword'=>$poster['kword'],'uniacid'=>$_W['uniacid']));
				message ( '删除海报成功！', $this->createWebUrl ( 'mposter' ) );
			}
		}

        $haibao=pdo_fetch ( 'select * from ' . tablename ($this->modulename . "_poster" ) . " where weid='{$_W['uniacid']}' limit 1" );
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("select * from ".tablename($this->modulename."_poster")." p where weid='{$_W['uniacid']}' LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_poster')." where weid='{$_W['uniacid']}'");
		$pager = pagination($total, $pindex, $psize);
        //echo '<pre>';
        //print_r($list);
        //echo $list['0']['id'];
        //exit;
		include $this->template ( 'mlist' );