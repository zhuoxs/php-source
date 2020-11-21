<?php
		global $_GPC, $_W;
		checklogin();
		load()->func('file');
		$rid = $_GPC['rid'];
		$goods = pdo_getall('n1ce_mission_goods',array('uniacid'=>$_W['uniacid'],'rid'=>$rid));
		if (checksubmit()){
			if($_GPC['type'] == '1'){
				$data = array(
				'uniacid' => $_W['uniacid'],
				'prizesum' => $_GPC['prize_sum'],
				'type' => $_GPC['type'],
				'min_money' => $_GPC['min_money'],
				'max_money' => $_GPC['max_money'],
				'rid' => $_GPC['rid'],
				'time' => time()
				);
			}
			if($_GPC['type'] == '2'){
				$data = array(
				'uniacid' => $_W['uniacid'],
				'prizesum' => $_GPC['cprize_sum'],
				'type' => $_GPC['type'],
				'cardid' => $_GPC['cardid'],
				'rid' => $_GPC['rid'],
				'time' => time()
				);
			}
			if($_GPC['type'] == '3'){
				$data = array(
				'uniacid' => $_W['uniacid'],
				'lable' => $_GPC['lable'],
				'prizesum' => $_GPC['uprize_sum'],
				'type' => $_GPC['type'],
				'url' => $_GPC['url'],
				'rid' => $_GPC['rid'],
				'time' => time()
				);
			}
			if($_GPC['type'] == '4'){
				$data = array(
				'uniacid' => $_W['uniacid'],
				'prizesum' => $_GPC['jprize_sum'],
				'type' => $_GPC['type'],
				'credit' => $_GPC['credit'],
				'rid' => $_GPC['rid'],
				'time' => time()
				);
			}
			if($_GPC['type'] == '5'){
				$data = array(
				'uniacid' => $_W['uniacid'],
				'prizesum' => $_GPC['myuprize_sum'],
				'type' => $_GPC['type'],
				'url' => $_GPC['myurl'],
				'rid' => $_GPC['rid'],
				'time' => time()
				);
			}
			if($_GPC['type'] == '6'){
				$data = array(
				'uniacid' => $_W['uniacid'],
				'lable' => $_GPC['cj_lable'],
				'prizesum' => $_GPC['cjprize_sum'],
				'type' => $_GPC['type'],
				'url' => $_GPC['cj_url'],
				'rid' => $_GPC['rid'],
				'time' => time()
				);
			}
			if($_GPC['type'] == '7'){
				$data = array(
					'uniacid' => $_W['uniacid'],
					'prizesum' => $_GPC['codeprize_sum'],
					'type' => $_GPC['type'],
					'url' => $_GPC['code_url'],
					'rid' => $_GPC['rid'],
					'time' => time()
				);
			}
			if($_GPC['type'] == '8'){
				if(empty($_GPC['gid'])){
					message('未选择商品,请先前往实物库添加',$this->createWebUrl('goods'),'error');
				}
				$goods = pdo_get('n1ce_mission_goods',array('id'=>$_GPC['gid']),array('quality'));
				$data = array(
					'uniacid' => $_W['uniacid'],
					'prizesum' => $goods['quality'],
					'type' => $_GPC['type'],
					'gid' => $_GPC['gid'],
					'rid' => $_GPC['rid'],
					'time' => time()
				);
			}
			$data['miss_num'] = $_GPC['miss_num'];
			$data['prize_name'] = $_GPC['prize_name'];
			if($_GPC['type'] == '7'){
				pdo_insert('n1ce_mission_prize', $data );
				$codeid = pdo_insertid();
				//记录插入的id,插入失败可以删去
				
				$dir_url = IA_ROOT . '/attachment/images/' . $_W['uniacid'] . '/n1ce_mission/';
				mkdirs($dir_url);
				if ($_FILES["csvfile"]["name"]) {
					$extNameAry = explode(".", $_FILES["csvfile"]["name"]);
					$extName = $extNameAry[count($extNameAry) - 1];
					if ($extName != 'csv') {
						pdo_delete('n1ce_mission_prize',array('id'=>$codeid));
						message('只能是导入csv格式的文件！', $this->createWebUrl('prize',array('rid' => $_GPC['rid'])), 'error');
					}
					$filename = date("YmdHis") . "." . $extName;
					move_uploaded_file($_FILES["csvfile"]["tmp_name"], $dir_url . "/" . $filename);
					$file = fopen($dir_url . "/" . $filename, 'r');
					while ($data = fgetcsv($file)) {
						$goods_list[] = $data;
					}
					foreach ($goods_list as $row) {
						
						$temp = array(
							'uniacid' => $_W['uniacid'],
							'rid' => $_GPC['rid'],
							'codeid' => $codeid,
							'code' => $row[0],
							'status' => 1,
						);
						pdo_insert('n1ce_mission_code',$temp);
					}
					fclose($file);
				}	
			}else{
				pdo_insert('n1ce_mission_prize', $data );
			}
			message('添加成功',$this->createWebUrl('prize',array('rid' => $rid)),'success');
		}
		include $this->template('prizeadd');