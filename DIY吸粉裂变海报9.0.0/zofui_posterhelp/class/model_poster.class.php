<?php 

/*生成卡券*/
class model_poster
{
	static $acccount;
	// type 1card 2other

	static function getPoster($user){
		global $_W;
		$name = $user['id'].'.jpg';
		$dir = '/addons/zofui_posterhelp/poster/'.$_W['uniacid'].'/'.$user['actid'].'/';

		$img = IA_ROOT.$dir.$name;
		$url = trim($_W['siteroot'],'/').$dir.$name;

		// 判断过期没
		$isdown = 1;
		if( $user['id'] > 0 ) {
			$qr = pdo_get('zofui_posterhelp_qrcode',array('actid'=>$user['actid'],'openid'=>$user['openid'],'uniacid'=>$_W['uniacid']));
			if( empty( $qr ) ||  $qr['expire'] <= time() ) $isdown = 0;
		}
		
		if( file_exists( $img ) && $isdown == 1 ){
			return array('dir'=>$img,'url'=>$url);
		}

		if( !is_dir( IA_ROOT.$dir ) ) @mkdir( IA_ROOT.$dir,0755,true );
		$poster = pdo_get('zofui_posterhelp_poster',array('uniacid'=>$_W['uniacid'],'actid'=>$user['actid'],'type'=>1));
		if( empty( $poster['params'] ) ) return false;

		$params = iunserializer( $poster['params'] );

		$bg = parse_url($poster['bgimg']);
		$bgdir = IA_ROOT.$bg['path'];

		if( file_exists( $bgdir ) ) $poster['bgimg'] = $bgdir;

		$res = self::createCard( $img,$poster['bgimg'] , $params,$user);

		if( $res ){
			return array('dir'=>$img,'url'=>$url);
		}
		return false;
		
	}
	
	static function createCard($dir,$bg,$params,$user){
		global $_W;
		
		if( !is_array( $params ) ) return false;
		
		$bgimg = $bg;
		@ini_set('memory_limit', '100M');
		$set = Util::getModuleConfig();
		foreach ($params as  $v) {
			$img = $txt = $headimg = '';
			switch ($v['name']) {
				case 'qrcode':
					if( $user['id'] > 0 && $_W['account']['level'] == 4 ){

						$ticket = self::getMyQrcode($user);
						if( $ticket || $ticket['status'] ){
							$img = self::saveImage('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket,$user['id'].'qrcode');
						}

					}else{
						if( empty($set['helptype']) ){
							$img = IA_ROOT.'/attachment/qrcode_'.$_W['acid'].'.jpg';
						}else{
							$imgarr = self::geturlQrcode($user['id']);
							if( $imgarr['status'] ){
								$img = $imgarr['img'];
							}

						}
					}
					$bgimg = self::doImage($bgimg,$v['params'],$img);
					if( $ticket  ){
						@unlink( $img );
					}
					if( $imgarr['img']  ){
						@unlink( $imgarr['img'] );
					}
					break;
				case 'headimg':
					if( !empty( $user['headimgurl'] ) ){
						$headimg = self::saveImage($user['headimgurl'],$user['id'].'head');
					}
					$img = empty( $headimg ) ? './../addons/zofui_posterhelp/public/images/default_head.jpg' : $headimg;
					$bgimg = self::doImage($bgimg,$v['params'],$img);
					if( $user['id'] > 0 ) @unlink( $headimg );
					break;
				case 'nick':
					$txt = empty( $user['nickname'] ) ? '会员昵称' : $user['nickname'];
					$bgimg = self::doTxt($bgimg,$v['params'],$txt);
					break;
				case 'code':
					$txt = empty( $user['code'] ) ? '邀请码' : $set['head'].$user['code'];
					$bgimg = self::doTxt($bgimg,$v['params'],$txt);

					break;								
				default:
					break;
			}
		}

		$res = imagejpeg($bgimg, $dir);
		imagedestroy($bgimg);
		return $res;
	}

	// 删除
	static function deletePoster($actid){
		global $_W;
		$dir = IA_ROOT.'/addons/zofui_posterhelp/poster/'.$_W['uniacid'].'/'.$actid.'/';

		if( is_dir( $dir ) ){	
			Util::rmdirs( $dir );
		}
	}

	// 生成专属二维码
	static function geturlQrcode($uid){
		global $_W;
		
		$name = $uid.'qr.jpg';
		$dir = '/addons/zofui_posterhelp/qrcode/'.$_W['uniacid'].'/';

		if( !is_dir($dir) ){
			@mkdir( IA_ROOT.$dir,0755,true );
		}

		$img = IA_ROOT.$dir.$name;

		$url = Util::createModuleUrl('guanzhu',array('uid'=>$uid));

		$res = QRcode::png($url,$img,'L', 4.5, 2);
		if( file_exists($img) ){
			return array('status'=>true,'img'=>$img);
		}else{
			return array('status'=>false);
		}
		
	}


	// 生成专属二维码
	static function getMyQrcode($user){
		global $_W;
		if( $_W['account']['level'] != 4 ) return false;
		$name = $user['id'].'.jpg';
		$dir = '/addons/zofui_posterhelp/qrcode/'.$_W['uniacid'].'/'.$user['actid'].'/';
		$img = IA_ROOT.$dir.$name;
		$url = trim($_W['siteroot'],'/').$dir.$name;

		$qr = pdo_get('zofui_posterhelp_qrcode',array('actid'=>$user['actid'],'openid'=>$user['openid'],'uniacid'=>$_W['uniacid']));
		$qrcode = pdo_get('qrcode',array('id'=>$qr['qrcodeid']));
		
		if( !empty( $qrcode ) && $qr['expire'] > time() ){
			return $qrcode['ticket'];
		}

		if( !empty( $qr ) ) pdo_delete('zofui_posterhelp_qrcode',array('id'=>$qr['id']));
		if( !empty( $qrcode ) ) pdo_delete('qrcode',array('id'=>$qrcode['id']));

		$bindkey = pdo_get('zofui_posterhelp_act',array('id'=>$user['actid']),array('postkey'));

		$newqr = self::createQr(1,'',$user['id'],$bindkey['postkey']);
		if( $newqr['status'] ){
			$indata = array(
				'uniacid' => $_W['uniacid'],
				'openid' => $user['openid'],
				'actid' => $user['actid'],
				'qrcodeid' => $newqr['data']['id'],
				'sence' => $newqr['data']['qrcid'],
				'expire' => $newqr['data']['createtime'] + $newqr['data']['expire'],
			);
			pdo_insert('zofui_posterhelp_qrcode',$indata);
			return $newqr['data']['ticket'];
		}else{
			return false;
		}
	}

	// 生成带参数的二维码 1临时 2永久
	static function createQr($type,$scene_str = '',$uid,$bindkey=''){
		global $_W;
		$acid = intval($_W['acid']);
		if( !self::$acccount ){
			self::$acccount = WeAccount::create($acid);
		}
		

		if ($type == 1) {

			$sql = "LOCK TABLES ".tablename('qrcode').' WRITE,'.tablename('core_cache').' WRITE ';
			pdo_query($sql);

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

		if( !is_error($result) ) {
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $acid,
				'qrcid' => $barcode['action_info']['scene']['scene_id'],
				'scene_str' => $barcode['action_info']['scene']['scene_str'],
				'keyword' => $bindkey,
				'name' => '海报助力模块二维码',
				'model' => $type,
				'ticket' => $result['ticket'],
				'url' => $result['url'],
				'expire' => $result['expire_seconds'],
				'createtime' => TIMESTAMP,
				'status' => '1',
				'type' => 'scene',
			);
			$ires = pdo_insert('qrcode', $insert);
			Util::unlock();

			$insert['id'] = pdo_insertid();
			Util::deleteCache('addqlock','all');
			if( $ires ) return array('status'=>true,'data'=>$insert);
		} else {
			Util::unlock();
			return array('status'=>false,'data'=>"公众平台返回接口错误. <br />错误代码为: {$result['errorcode']} <br />错误信息为: {$result['message']}");
		}

		
		return array('status'=>false,'data'=>'生成二维码失败');
	}


	// 图片
	static function doImage($bg,$data,$img){
		if( !is_array( $data ) ) return false;
		if( is_string( $bg ) ) $bg = self::imagecreates($bg);
		$img = self::imagecreates($img);
		$w = @imagesx($img);
		$h = @imagesy($img);

		//@imagecopyresized($bg, $img, $data['left']*2.4, $data['top']*2.4, 0, 0, $data['width']*2.2, $data['height']*2.2, $w, $h);
		@imagecopyresized($bg, $img, $data['left']*2.09, $data['top']*2.09, 0, 0, $data['width']*2.09, $data['height']*2.09, $w, $h);
		@imagedestroy($img);
		return $bg;

	}

	static function saveImage($url,$tag = '') {
				
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		ob_start ();
		curl_exec ( $ch );
		$return_content = ob_get_contents ();
		ob_end_clean ();
		$return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		$filename = IA_ROOT."/addons/zofui_posterhelp/poster/temp{$tag}.jpg";
		$fp= @fopen($filename,"a");

		fwrite($fp,$return_content);
		return $filename;
	}

	// 文字
	static function doTxt($bg,$data,$txt){
		if( !is_array( $data ) ) return false;

		$font = IA_ROOT.'/addons/zofui_posterhelp/public/css/msyhbd3.ttf';//字体文件
		if( is_string( $bg ) ) $bg = self::imagecreates($bg);
		$colors = self::hex2rgb($data['color']);

		$color = imagecolorallocate($bg, $colors['red'], $colors['green'], $colors['blue']);
		
		imagettftext($bg, $data['fontsize']*1.6, 0, $data['left']*2.1, ($data['top'] + $data['fontsize'])*2.1, $color, $font, $txt);

		return $bg;
	}

	static function hex2rgb($color) {
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}
		if (strlen($color) == 6) {
			list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
		} elseif (strlen($color) == 3) {
			list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
		} else {
			return $color;
		}
		$r = hexdec($r);
		$g = hexdec($g);
		$b = hexdec($b);
		return array('red' => $r, 'green' => $g, 'blue' => $b);
	}

	static function imagecreates($bg) {

		if( !is_string( $bg ) ) return $bg;
		$bgImg = @imagecreatefromjpeg($bg);
		if (FALSE == $bgImg) {
			$bgImg = @imagecreatefrompng($bg);
		}
		if (FALSE == $bgImg) {
			$bgImg = @imagecreatefromgif($bg);
		}
		
		return $bgImg;
	}


	static function toShortUrl($url){
		global $_W;
		load()->func('communication');
		load()->model('account');
		$longurl = trim($url);
		$token = WeAccount::token(WeAccount::TYPE_WEIXIN);
		$url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token={$token}";
		$send = array();
		$send['action'] = 'long2short';
		$send['long_url'] = $longurl;
		$response = ihttp_request($url, json_encode($send));
		if(is_error($response)) {
			return $longurl;
		}
		$result = @json_decode($response['content'], true);
		if(empty($result)) {
			return $longurl;
		} elseif(!empty($result['errcode'])) {
			return $longurl;
		}
		if(is_error($result)) {
			return $longurl;
		}
		return $result['short_url'];
	}


	static function initIndex($page){
		global $_W;
		
		$params = array(
			'bg'=> POSETERH_URL.'public/images/bg.png',
			'bgcolor'=> '#9a12ff',
			'timeshow'=> 0,
			'timetop'=> 70,
			'othertop'=> 110,
		);
		if( empty( $page['params'] ) ) return $params;

		foreach ($page['params'] as $k => $v) {
			if( !empty( $v ) ) $params[$k] = $v;
		}
		return $params;
	}
	static function initPrize($page){
		global $_W;
		$params = array(
			'bg'=> POSETERH_URL.'public/images/prize_bg.png',
			'bgcolor'=> '#9a12ff',
			'fontshow'=> 0,
			'fonttop'=> 7,
			'prizetop'=> 60,
		);
		if( empty( $page['params'] ) ) return $params;

		foreach ($page['params'] as $k => $v) {
			if( !empty( $v ) ) $params[$k] = $v;
		}
		return $params;
	}

}