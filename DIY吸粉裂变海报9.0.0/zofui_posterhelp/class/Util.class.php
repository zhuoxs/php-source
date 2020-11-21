<?php 
	
class Util 
{	


	static function lock($tablename,$type='WRITE'){
		global $_W;
		$sql = "LOCK TABLE ".tablename($tablename).' '.$type;
		$res = pdo_query($sql);
		return $res;
	}

	static function unlock(){
		global $_W;
		$sql = "UNLOCK TABLES";
		$res = pdo_query($sql);
		return $res;
	}	

	//获取区域
	static function getarea($ip = ''){
		$res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);  
		if(empty($res)){ return false; }
		$jsonMatches = array();  
		preg_match('#\{.+?\}#', $res, $jsonMatches);  
		if(!isset($jsonMatches[0])){ return false; }  
		$json = json_decode($jsonMatches[0], true);  
		if(isset($json['ret']) && $json['ret'] == 1){  
			$json['ip'] = $ip;  
			unset($json['ret']);  
		}else{  
			return false;  
		}  
		return $json;
	}

	static function echoResult($status,$str,$arr='') {
		global $_W;
		$uid = empty( $_W['openid'] ) ? 0 : $_W['openid'] ;
		$res = array('status'=>$status,'res'=>$str,'obj'=>$arr);
		echo json_encode($res);
		self::deleteCache('ing',$uid);
		exit;
	}	
	
	//获取客户端IP
	static function getClientIp() {
		$ip = "";
		if (!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		if (!empty($_SERVER["REMOTE_ADDR"])){
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		return $ip;
	}

	static function formatDistance($dis){
		$dis = intval( $dis );
		switch ($dis) {
			case $dis <= 0:
				return '0m';
				break;
			case $dis < 2000:
				return $dis.'m';
				break;			
			default:
				return sprintf('%.2f',$dis/1000).'km';
				break;
		}
	}

	//注册jssdk，因为微擎自带的方法内没有加openAddress，所以重新写一个。
	static function register_jssdk($debug = false){
		global $_W;
		if (defined('HEADER')) {
			echo '';
			return;
		}
		
		$sysinfo = array(
			'uniacid' 	=> $_W['uniacid'],
			'acid' 		=> $_W['acid'],
			'siteroot' 	=> $_W['siteroot'],
			'siteurl' 	=> $_W['siteurl'],
			'attachurl' => $_W['attachurl'],
			'cookie' 	=> array('pre'=>$_W['config']['cookie']['pre'])
		);
		if (!empty($_W['acid'])) {
			$sysinfo['acid'] = $_W['acid'];
		}
		if (!empty($_W['openid'])) {
			$sysinfo['openid'] = $_W['openid'];
		}
		if (defined('MODULE_URL')) {
			$sysinfo['MODULE_URL'] = MODULE_URL;
		}
		$sysinfo = json_encode($sysinfo);
		$jssdkconfig = json_encode($_W['account']['jssdkconfig']);
		$debug = $debug ? 'true' : 'false';
		
		$script = <<<EOF
	<script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
	<script type="text/javascript">
		window.sysinfo = window.sysinfo || $sysinfo || {};
		
		// jssdk config 对象
		jssdkconfig = $jssdkconfig || {};
		
		// 是否启用调试
		jssdkconfig.debug = $debug;
		
		jssdkconfig.jsApiList = [
			'checkJsApi',
			'onMenuShareTimeline',
			'onMenuShareAppMessage',
			'onMenuShareQQ',
			'onMenuShareWeibo',
			'hideMenuItems',
			'showMenuItems',
			'hideAllNonBaseMenuItem',
			'showAllNonBaseMenuItem',
			'translateVoice',
			'startRecord',
			'stopRecord',
			'onRecordEnd',
			'playVoice',
			'pauseVoice',
			'stopVoice',
			'uploadVoice',
			'downloadVoice',
			'chooseImage',
			'previewImage',
			'uploadImage',
			'downloadImage',
			'getNetworkType',
			'openLocation',
			'getLocation',
			'hideOptionMenu',
			'showOptionMenu',
			'closeWindow',
			'scanQRCode',
			'chooseWXPay',
			'openProductSpecificView',
			'addCard',
			'chooseCard',
			'openCard',
			'openAddress'
		];
		
		wx.config(jssdkconfig);
		
	</script>
EOF;
		echo $script;
	}	


	//微信端上传图片 传入微信端下载的图片
	static function uploadImageInWeixin($resp){
		global $_W;
		$setting = $_W['setting']['upload']['image'];
		$setting['folder'] = "images/{$_W['uniacid']}".'/'.date('Y/m/');	
		
		load()->func('file');
		if (is_error($resp)) {
			$result['message'] = '提取文件失败, 错误信息: '.$resp['message'];
			return json_encode($result);
		}
		if (intval($resp['code']) != 200) {
			$result['message'] = '提取文件失败: 未找到该资源文件.';
			return json_encode($result);
		}
		$ext = '';
		
		switch ($resp['headers']['Content-Type']){
			case 'application/x-jpg':
			case 'image/jpeg':
				$ext = 'jpg';
				break;
			case 'image/png':
				$ext = 'png';
				break;
			case 'image/gif':
				$ext = 'gif';
				break;
			default:
				$result['message'] = '提取资源失败, 资源文件类型错误.';
				return json_encode($result);
				break;
		}
		
		if (intval($resp['headers']['Content-Length']) > $setting['limit'] * 1024) {
			$result['message'] = '上传的媒体文件过大('.sizecount($size).' > '.sizecount($setting['limit'] * 1024);
			return json_encode($result);
		}
		$originname = pathinfo($url, PATHINFO_BASENAME);
		$filename = file_random_name(ATTACHMENT_ROOT .'/'. $setting['folder'], $ext);
		$pathname = $setting['folder'] . $filename;
		$fullname = ATTACHMENT_ROOT . '/' . $pathname;
		if(!is_dir(ATTACHMENT_ROOT.$setting['folder'])){
			mkdirs(ATTACHMENT_ROOT.$setting['folder']);
		}
		if (file_put_contents($fullname, $resp['content']) == false) {
			$result['message'] = '提取失败.';
			return json_encode($result);
		}
		$info = array(
			'name' => $originname,
			'ext' => $ext,
			'filename' => $pathname,
			'attachment' => $pathname,
			'url' => tomedia($pathname),
			'is_image' => $type == 'image' ? 1 : 0,
			'filesize' => filesize($fullname),
		);		
		return json_encode($info);
	}	



	//查询模块config
	static function getModuleConfig(){
		$modulelist = uni_modules(false);
		return $modulelist['zofui_posterhelp']['config'];
	}
		
	static function checkSubmit($name){
		global $_GPC;
		
		if($_GPC['mytoken'] == $_SESSION['mytoken'] && isset($_GPC[$name]) && !empty($_GPC['mytoken'])){
			unset($_SESSION['mytoken']);
			return true;
		}
		return false;
	}
	
	static function getRandom(){
		return time() . rand(10000,99999);
	}
	
	static function getRand($arg1,$arg2){
		$min = min($arg1,$arg2);
		$max = max($arg1,$arg2);
		return rand($min,$max);
	}
	
	
	//格式化时间,多久之前
	static function formatTime($time){
		$difftime = time() - $time;
		
		if($difftime < 60){
			return $difftime . '秒前';
		}
		if($difftime < 120){
			return '1分钟前';	
		}
		if($difftime < 3600){
			return  intval($difftime/60).'分钟前';			
		}		
		if($difftime < 3600*24){
			return  intval($difftime/60/60).'小时前';			
		}
		if($difftime < 3600*24*2){
			return  '昨天';			
		}
		return  intval($difftime/60/60/24).'天前';
	}
	
	//剩余时间
	static function lastTime($time,$secondflag = true){
		$diff = $time - time();
		if($diff <= 0) return '0天0时0分';
		$day = intval($diff/24/3600);
		$hour = intval( ($diff%(24*3600))/3600 );
		$minutes = intval( ($diff%(24*3600))%3600/60 );
		$second = $diff%60;
		if($secondflag){
			return $day. '天' . $hour . '时' .$minutes. '分' .$second. '秒';
		}else{
			return $day. '天' . $hour . '时' .$minutes. '分';
		}
	}	
	
	
	
	
	//删除数据库
	static function deleteData($id,$tablename){
		global $_W;
		if($id == '') return false;
		$id = intval($id);
		$datainfo = self::getSingelDataInSingleTable($tablename,array('id'=>$id));
		if (empty($datainfo)) message('数据不存在或是已经被删除！');
		
		$res = pdo_delete($tablename, array('id' => $id,'uniacid' => $_W['uniacid']), 'AND');
		return $res;
	}		
		
	//插入数据
	static function inserData($tablename,$data){
		global $_W;
		if($data == '') return false;
		$data = $data;
		$data['uniacid'] = $_W['uniacid'];
		$res = pdo_insert($tablename,$data);
		return $res;
	}
	
	//根据条件查询数据条数
	static function countDataNumber($tablename,$where,$str = ''){
		global $_W;
		$data = self::structWhereStringOfAnd($where);
		return pdo_fetchcolumn(" SELECT COUNT(*) FROM " . tablename($tablename) . " WHERE $data[0] ".$str,$data[1]);
	}
	
	//更新单条数据，对数据进行加减，更新。需传入id
	static function addOrMinusOrUpdateData($tablename,$countarray,$id,$type='addorminus'){
		global $_W;
		if(empty($countarray)) return false;
		$count = '';
		if($type == 'addorminus'){
			foreach($countarray as $k=>$v){
				$count .= ' `'.$k.'`'.' = '.' `'.$k.'` '.' + '.$v.',';
			}
		}elseif($type == 'update'){
			foreach($countarray as $k=>$v){
				$count .= "`".$k."` = '".$v."',";
			}
		}
		$count = trim($count,',');
		$id = intval($id);
		$res = pdo_query("UPDATE ".tablename($tablename)." SET $count WHERE `id` = '{$id}' AND `uniacid` = '{$_W['uniacid']}' ");
		if($res) return true;
		return false;
	}
	
	//在一个表里查询单条数据
	static function getSingelDataInSingleTable($tablename,$array,$select='*'){
		$data = self::structWhereStringOfAnd($array);
		$sql = "SELECT $select FROM ". tablename($tablename) ." WHERE $data[0] ";
		return pdo_fetch($sql,$data[1]);
	}
	
	//在一个表里查询多条数据
	static function getAllDataInSingleTable($tablename,$where,$page,$num,$order='id DESC',$iscache = false,$isNeedPager = true,$select = '*',$str=''){
		global $_W;
		$data = self::structWhereStringOfAnd($where);
		
		$countStr = "SELECT COUNT(*) FROM ".tablename($tablename) ." WHERE $data[0] ";
		$selectStr = "SELECT $select FROM ".tablename($tablename) ." WHERE $data[0] ";
		$res = self::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$iscache,$isNeedPager,$str);
		return $res;
	}
	
	/*
	*	查询数据共用方法
	*	$selectStr -> mysql字符串
	*	$page -> 页码
	*	$num -> 每页数量
	*	$order -> 排序
	*	$isNeadPager -> 是否需要分页
	*/
	static function fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order='`id` DESC',$iscache=false,$isNeedPager=false,$str=''){
		$pindex = max(1, intval($page));
		$psize = $num;

		if($iscache){ // 缓存
			$cacheid = $countStr.$selectStr.$psize.$pindex.$order.$isNeedPager.$str;
			foreach ($params as $k => $v) {
				$cacheid .= $v;
			}
			$cacheid = md5($cacheid);
			$cache = self::getCache('p',$cacheid);
			if(!empty($cache[0]) && $cache['temptime'] > (time() - 30) ) return $cache;
		}

		$total =  $isNeedPager?pdo_fetchcolumn($countStr.$str,$params):'';
		$data = pdo_fetchall($selectStr.$str." ORDER BY $order " . " LIMIT " . ($pindex - 1) * $psize . ',' . $psize,$params);
		$pager = $isNeedPager?pagination($total, $pindex, $psize):'';

		if($iscache && !empty($data)){
			self::setCache('p',$cacheid,array($data,$pager,$total,'temptime'=>time()));
		}
		return array($data,$pager,$total);
	}	
	
	//组合AND数据查询where字符串 = ,>= ,<= <、>必须紧挨字符 例：$where = array('status'=>1,'overtime<'=>time());
 	static function structWhereStringOfAnd($array,$head=''){
		global $_W;
		if(!is_array($array)) return false;
		$array['uniacid'] = $_W['uniacid'];
		$str = '';
		foreach($array as $k=>$v){
			if(isset($k) && $v === '') message('存在异常参数'.$k);
			if(strpos($k,'>') !== false){
				$k = trim(trim($k),'>');
				$eq = ' >= ';
			}elseif(strpos($k,'<') !== false){
				$k = trim(trim($k),'<');
				$eq = ' <= ';
			}elseif(strpos($k,'@') !== false){ //模糊查询
				$eq = ' LIKE ';
				$k = trim(trim($k),'@');
				$v = "%".$v."%";
			}elseif(strpos($k,'#') !== false){ //in查询
				$eq = ' IN ';
				$k = trim(trim($k),'#');
			}else{
				$eq = ' = ';
			}
			$str .= empty($head) ? 'AND `'.$k.'`'.$eq.':'.$k.' ' : 'AND '.$head.'.`'.$k.'`'.$eq.':'.$k.' ';
			
			$params[':'.$k] = $v;
			
		}
		$str = trim($str,'AND');
		return array($str,$params);
	}	
	
	
	
	//获取cookie 传入cookie名 //解决js与php的编码不一致情况。
	static function getCookie($str){
		return urldecode($_COOKIE[$str]);
	}
	

	//共用先查询缓存数据
	static function getDataByCacheFirst($key,$name,$funcname,$valuearray){
		$data = self::getCache($key,$name);

		if(empty($data)){
			
			$data = call_user_func_array($funcname,$valuearray);
			self::setCache($key,$name,$data);
		}

		return $data;
	}
	
	
	//查询缓存
 	static function getCache($key,$name,$actid='') {
		global $_W;
		
		$actid = empty($actid) ? $_W['actid'] : $actid;
		if(empty($key) || empty($name) || empty( $actid ) ) return false;
				
		return cache_read('zfph:'.$_W['uniacid'].':'.$actid.':'.$key.':'.$name);
	}
	
	//设置缓存
	static function setCache($key,$name,$value,$actid='') {
		global $_W;
		$actid = empty($actid) ? $_W['actid'] : $actid;
		if(empty($key) || empty($name) || empty( $actid ) ) return false;

		$res = cache_write('zfph:'.$_W['uniacid'].':'.$actid.':'.$key.':'.$name,$value);
		return $res;
	}
	
	//删除缓存
	static function deleteCache($key,$name,$actid='') {
		global $_W;		
		$actid = empty($actid) ? $_W['actid'] : $actid;
		if(empty($key) || empty($name) || empty( $actid ) ) return false;
		cache_write('zfph:'.$_W['uniacid'].':'.$actid.':'.$key.':'.$name,'');	
		return cache_delete('zfph:'.$_W['uniacid'].':'.$actid.':'.$key.':'.$name);
	}



	//删除所有缓存 每次设置参数后都要删除
	static function deleteThisModuleCache(){
		global $_W;
		$res = cache_clean('zfph');
		return $res;
	}
	
	//创建目录
	static function mkdirs($path) {
		if (!is_dir($path)) {
			mkdir($path,0777,true);
		}
		return is_dir($path);
	}	
	
	// 删除目录及所有子文件
	static function rmdirs($path, $clean = false) {
		if (!is_dir($path)) {
			return false;
		}
		$files = glob($path . '/*');
		if ($files) {
			foreach ($files as $file) {
				is_dir($file) ? self::rmdirs($file) : @unlink($file);
			}
		}
		return $clean ? true : @rmdir($path);
	}

	//加密函数
	static function encrypt($txt) {
		srand((double)microtime() * 1000000);
		$encrypt_key = md5(rand(0, 32000));
		$ctr = 0;
		$tmp = '';
		for($i = 0;$i < strlen($txt); $i++) {
		   $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		   $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
		}
		return base64_encode(self::passport_key($tmp));
	}

	//解密函数
	static function decrypt($txt) {
		
		$txt = self::passport_key(base64_decode($txt));
		$tmp = '';
		for($i = 0;$i < strlen($txt); $i++) {
		   $md5 = $txt[$i];
		   $tmp .= $txt[++$i] ^ $md5;
		}
		return $tmp;
	}

	static function passport_key($txt) {
		global $_W;
		$key = $_W['config']['setting']['authkey'];
		$encrypt_key = md5($key);
		$ctr = 0;
		$tmp = '';
		for($i = 0; $i < strlen($txt); $i++) {
		   $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		   $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
		}
		return $tmp;
	}	
		
	

	//截取字符串,截取start-end之间的,结果不包含start和end；
	static function cut($from, $start, $end, $lt = false, $gt = false){
		$str = explode($start, $from);
		if (isset($str['1']) && $str['1'] != '') {
			$str = explode($end, $str['1']);
			$strs = $str['0'];
		} else {
			$strs = '';
		}
		if ($lt) {
			$strs = $start . $strs;
		}
		if ($gt) {
			$strs .= $end;
		}
		return $strs;
	}	
	
	//组合URL
	static function createModuleUrl($do,$array=array()){
		global $_W;
		$str = '&do='.$do;
		if(!empty($array)){
			foreach($array as $k=>$v){
				$str .= '&'.$k.'='.$v;
			}		
		}
		
		return $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry'.$str.'&m=zofui_posterhelp';
	}

	static function webUrl($do,$array=array()){
		global $_W;
		$str = '&do='.$do;
		if(!empty($array)){
			foreach($array as $k=>$v){
				$str .= '&'.$k.'='.$v;
			}		
		}
		return $_W['siteroot'].'web/index.php?c=site&a=entry'.$str.'&m='.MODULE;
	}		

	//处理空格
	static function trimWithArray($array){
		if(!is_array($array)){
			return trim($array);
		}
		foreach($array as $k=>$v){	
			$res[$k] = self::trimWithArray($v);
		}
		return $res;
	}
	
    public static function httpRequest($url, $post = '', $headers = array(), $forceIp = '', $timeout = 60, $options = array())
    {
        load()->func('communication');
        return ihttp_request($url, $post, $options, $timeout);
    }
	//get请求
    public static function httpGet($url, $forceIp = '', $timeout = 60)
    {
        $res = self::httpRequest($url, '', array(), $forceIp, $timeout);
        if (!is_error($res)) {
            return $res['content'];
        }
        return $res;
    }
	//post请求
    public static function httpPost($url, $data, $forceIp = '', $timeout = 60)
    {
        $headers = array('Content-Type' => 'application/x-www-form-urlencoded');
        $res = self::httpRequest($url, $data, $headers, $forceIp, $timeout);
        if (!is_error($res)) {
            return $res['content'];
        }
        return $res;
    }


    /**
     * 生成一定数量的随机数，并且不重复
     * @param integer $number 数量
     * @param string $len 长度
     * @param string $type 字串类型
     * 0 字母 1 数字 其它 混合
     * @return string
     */
    static public function buildCountRand ($number,$length=4,$mode=1) {
            if($mode==1 && $length<strlen($number) ) {
                //不足以生成一定数量的不重复数字
                return false;
            }
            $rand   =  array();
            for($i=0; $i<$number; $i++) {
                $rand[] =   self::randString($length,$mode);
            }
            $unqiue = array_unique($rand);
            if(count($unqiue)==count($rand)) {
                return $rand;
            }
            $count   = count($rand)-count($unqiue);
            for($i=0; $i<$count*3; $i++) {
                $rand[] =   self::randString($length,$mode);
            }
            $rand = array_slice(array_unique ($rand),0,$number);
            return $rand;
    }



    /**
     * 产生随机字串，可用来自动生成密码
     * 默认长度6位 字母和数字混合 支持中文
     * @param string $len 长度
     * @param string $type 字串类型
     * 0 字母 1 数字 其它 混合
     * @param string $addChars 额外字符
     * @return string
     */
    static public function randString($len=6,$type='',$addChars='') {
        $str ='';
        switch($type) {
            case 0:
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
                break;
            case 1:
                $chars= str_repeat('0123456789',3);
                break;
            case 2:
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
                break;
            case 3:
                $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
                break;
            case 4:
                $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
                break;
                case 5:
                $chars='abcdefghijkmnpqrstuvwxyz23456789'.$addChars;
                break;
            default :
                // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
                $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
                break;
        }
        if($len>10 ) {//位数过长重复字符串一定次数
            $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
        }
        if($type!=4) {
            $chars   =   str_shuffle($chars);
            $str     =   substr($chars,0,$len);
        }else{
            // 中文随机字
            for($i=0;$i<$len;$i++){
              $str.= self::msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1,'utf-8',false);
            }
        }
        return $str;
    } 

    /**
     * 字符串截取，支持中文和其他编码
     * @static
     * @access public
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $charset 编码格式
     * @param string $suffix 截断显示字符
     * @return string
     */
    static public function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
        if(function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif(function_exists('iconv_substr')) {
            $slice = iconv_substr($str,$start,$length,$charset);
        }else{
            $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("",array_slice($match[0], $start, $length));
        }
        return $suffix ? $slice.'...' : $slice;
    }

}
	
	
