<?php


//新增评价功能 18.02.22

		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$pinglun_t = $_GPC['pinglun_t'];
		$openid = $_GPC['openid'];
		$data = array(
			'aid' => $id,
			'text' => $pinglun_t,
			'openid' => $openid,
			'uniacid' => $uniacid,
			'createtime' => time()
			);
		$result = pdo_insert('sudu8_page_comment',$data);
		if($result == 1){
			return $this->result(0, 'success', array('result' => 1));
		}else{
			return $this->result(0, 'success', array('result' => 2));
		}
