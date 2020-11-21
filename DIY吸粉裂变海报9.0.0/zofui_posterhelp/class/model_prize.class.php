<?php 


class model_prize
{	

	static $acccount;

	// 生成带参数的二维码 1临时 2永久
	static function createQr($type,$scene_str = ''){
		global $_W;
		$acid = intval($_W['acid']);
		if( !self::$acccount ){
			self::$acccount = WeAccount::create($acid);
		}

		if ($type == 1) {
			$qrcid = pdo_fetchcolumn("SELECT qrcid FROM ".tablename('qrcode')." WHERE acid = :acid AND model = '1' AND type = 'scene' ORDER BY qrcid DESC LIMIT 1", array(':acid' => $acid));
			$barcode['action_info']['scene']['scene_id'] = !empty($qrcid) ? ($qrcid + 1) : 1001;
			$barcode['expire_seconds'] = 2592000;
			$barcode['action_name'] = 'QR_SCENE';
			$result = self::$acccount->barCodeCreateDisposable($barcode);
			
		} else if ($type == 2) {
			$is_exist = pdo_fetchcolumn('SELECT id FROM ' . tablename('qrcode') . ' WHERE uniacid = :uniacid AND acid = :acid AND scene_str = :scene_str AND model = 2', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid'], ':scene_str' => $scene_str));
			if(!empty($is_exist)) {
				return false;
			}
			$barcode['action_info']['scene']['scene_str'] = $scene_str;
			$barcode['action_name'] = 'QR_LIMIT_STR_SCENE';
			$result = self::$acccount->barCodeCreateFixed($barcode);
		} else {
			return false;
		}

		if( is_error($result) ) {
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $acid,
				'qrcid' => $barcode['action_info']['scene']['scene_id'],
				'scene_str' => $barcode['action_info']['scene']['scene_str'],
				'keyword' => '关注领卡券关键字',
				'name' => '关注领卡券二维码',
				'model' => $type,
				'ticket' => $result['ticket'],
				'url' => $result['url'],
				'expire' => $result['expire_seconds'],
				'createtime' => TIMESTAMP,
				'status' => '1',
				'type' => 'scene',
			);
			$ires = pdo_insert('qrcode', $insert);
			$insert['id'] = pdo_insertid();
			if( $ires ) return array('status'=>true,'data'=>$insert);
		} else {
			return array('status'=>false,'data'=>"公众平台返回接口错误. <br />错误代码为: {$result['errorcode']} <br />错误信息为: {$result['message']}");
		}

		return array('status'=>false,'data'=>'生成二维码失败');
	}


	// 获取奖品对应的二维码
	static function downQrcode($prize){
		global $_W;
		if( !is_array( $prize ) ) return false;

		$img = self::returnImgName($prize);
		if( !file_exists( $img ) ){
			$qrcode = pdo_get('qrcode',array('id'=>$prize['qrid']));
			$res = self::saveImage('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$qrcode['ticket'],$img);
			if( !$res ) return false;
		}
		return array('url'=>str_replace(IA_ROOT, $_W['siteroot'], $img),'file'=>$img);
	}

	// 保存二维码
	static function saveImage($url,$file) {
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		ob_start ();
		curl_exec ( $ch );
		$return_content = ob_get_contents ();
		ob_end_clean ();
		$return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		$fp= @fopen($file,"a");

		return fwrite($fp,$return_content);
	}

	


	// 查询prize表
	static function getAllPrize($actid){
		global $_W;
		$id = intval( $actid );
		if( $id <= 0 ) return false;
		$cache = Util::getCache('allprize',$id,$id);
		
		if(empty($cache)){
			
			$data = Util::getAllDataInSingleTable('zofui_posterhelp_prize',array('actid'=>$id,'uniacid'=>$_W['uniacid']),1,9999,'`number` DESC');
			$cache = $data[0];
			
			Util::setCache('allprize',$id,$cache,$id);
		}
		return $cache;  //需删除缓存
		
	}


	// 查询兑奖记录
	static function getGetedList($where,$page,$num,$order,$iscache,$pager,$select,$str=''){
		global $_W;
		
		$data = Util::structWhereStringOfAnd($where,'a');
		$commonstr = tablename('zofui_posterhelp_geted') ."  AS a LEFT JOIN ".tablename('zofui_posterhelp_user')." AS b ON a.`openid` = b.`openid` AND a.uniacid = b.uniacid AND a.actid = b.actid LEFT JOIN ".tablename('zofui_posterhelp_prize')." AS c ON a.`prizeid` = c.`id` AND a.uniacid = c.uniacid AND a.actid = c.actid WHERE ".$data[0];
		
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$res = Util::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$iscache,$pager,$str);
		return $res;
		
	}	

	// 查询我的奖品
	static function getMyPrize($where,$page,$num,$order,$iscache,$pager,$select,$str=''){
		global $_W;		
		$data = Util::structWhereStringOfAnd($where,'a');
		$commonstr = tablename('zofui_posterhelp_geted') ."  AS a LEFT JOIN ".tablename('zofui_posterhelp_prize')." AS b ON a.`prizeid` = b.`id` AND a.uniacid = b.uniacid AND a.`actid` = b.`actid` WHERE ".$data[0];
		
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$res = Util::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$iscache,$pager,$str);
		return $res;
	}


}