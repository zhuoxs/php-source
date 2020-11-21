<?php 
	global $_W,$_GPC;
	$_GPC['do'] = 'key';
	$_GPC['op'] = empty($_GPC['op'])? 'qrcode' : $_GPC['op'];
	
	$index = pdo_get('zofui_posterhelp_key',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['id'],'type'=>1));
	$prize = pdo_get('zofui_posterhelp_key',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['id'],'type'=>2));
	$poster = pdo_get('zofui_posterhelp_key',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['id'],'type'=>3));
	$getprize = pdo_get('zofui_posterhelp_key',array('uniacid'=>$_W['uniacid'],'actid'=>$_GPC['id'],'type'=>4));

	// 创建新活动
	if( checkSubmit('create') ){
		$_GPC = Util::trimWithArray($_GPC);
		
		$resstr = '';
		foreach ($_GPC['word'] as $k => $v) {
			
			$data = array();
			if( $k == 0 ){
				$rulename = '生成海报关键词'.$_GPC['id'];
				$datatype = 3;
				$kk = 1111;
				$keydata = $poster;

			}elseif( $k == 1 ){
				$rulename = '主页入口关键词'.$_GPC['id'];
				$datatype = 1;
				$kk = 0;
				$keydata = $index;

			}elseif( $k == 2 ){
				$rulename = '奖品入口关键词'.$_GPC['id'];
				$datatype = 2;
				$kk = 1;
				$keydata = $prize;

			}elseif( $k == 3 ){
				$rulename = '兑换奖品入口关键词'.$_GPC['id'];
				$datatype = 4;
				$kk = 2;
				$keydata = $getprize;

			}

			if( empty( $v ) ) continue;

			$sql = 'SELECT `id` FROM ' . tablename('zofui_posterhelp_key') . " WHERE `uniacid` = :uniacid  AND `word` = :word AND `actid` != :actid ";
			$result = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':word' => $v,':actid'=>$_GPC['id']));
			if( !empty( $result ) ) message( $rulename.'已被其他活动使用请换一个' );

		    $pid = WebCommon::doRule($rulename,$v,1);
		    $data = array(
		       	'uniacid' => $_W['uniacid'],
		        'actid' => $_GPC['id'],
		        'word' => $v,
		        'pid' => $pid,
		        'type' => $datatype,
		        'title' => $_GPC['title'][$kk],
		        'thumb' => $_GPC['thumb'][$kk],
		        'desc' => $_GPC['desc'][$kk],
		    );
		    

			if( empty($keydata) ){
	        	$res = pdo_insert('zofui_posterhelp_key', $data);
			}else{
				$res = pdo_update('zofui_posterhelp_key',$data,array('id'=>$keydata['id'],'uniacid'=>$_W['uniacid']));
			}
			
		}

		/*if( $_W['account']['level'] == 3 ){
			//$helpkey = pdo_get('rule_keyword',array('uniacid'=>$_W['uniacid'],'module'=>MODULE,'content'=>'[0-9]','type'=>3));
			// 助力关键字 level = 3
			$rid = WebCommon::doRule('处理帮助关键字','[0-9]',3);
		}*/

		message('操作成功','referer','success');
	}
 	


	
	
	include $this->template('web/key');