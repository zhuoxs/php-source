<?php
 load()->model('mc');
		global $_W, $_GPC;
		$pid = $_GPC['pid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("select * from ".tablename($this->modulename."_record")." where pid='{$pid}' LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		load()->model('mc');
		foreach ($list as $key => $value) {
			$mc = mc_fetch($value['openid']);
			$list[$key]['nickname'] = $mc['nickname'];
			$list[$key]['avatar'] = $mc['avatar'];
		}
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_record')." where pid='{$pid}'");
		$pager = pagination($total, $pindex, $psize);
		include $this->template ( 'record' );