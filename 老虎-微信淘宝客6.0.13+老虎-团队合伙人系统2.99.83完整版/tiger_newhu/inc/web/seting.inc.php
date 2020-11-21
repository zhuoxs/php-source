<?php
	global $_W, $_GPC;
		if($_GPC['op']=='delete'){
			$id=$_GPC['id'];
			pdo_delete($this->modulename."_tksign", array('id' => $id));
						message('删除成功！', referer(), 'success');
		}
?>