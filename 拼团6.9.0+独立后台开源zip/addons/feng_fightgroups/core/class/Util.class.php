<?php 
	// +----------------------------------------------------------------------
	// | Copyright (c) 2016-9-8.
	// +----------------------------------------------------------------------
	// | Describe: 拼团公共方法类
	// +----------------------------------------------------------------------
	// | Author: qidada<937991452@qq.com>
	// +----------------------------------------------------------------------
class Util 
{
	/** 
	* 获取用户进入方式 
	* 
	* @access public
	* @name 方法名称 
	* @param mixed  参数一的说明 
	* @return array 
	*/  
	function check_explorer(){
		global $_W;
		
		if(!empty($_W['openid'])){
			return 'weixin';
		}else{
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'CK 2.0') > -1) return 'yunapp';
			return 'wap';
		}
	}
	/** 
	* 查询单条数据
	* 
	* @access static
	* @name  getSingelData($tablename,$array,$select='*') 
	* @param $tablename  表名         'tg_member'
	* @param $where  	  查询条件  array('name'=>'qidada')
	* @param $select     查询字段  " id,name "
	* @return array 
	*/  
	static function getSingelData($select,$tablename,$where){
		$data = self::createStandardWhereString($where);
		return pdo_fetch("SELECT $select FROM ". tablename($tablename) ." WHERE $data[0] ",$data[1]);
	}
	
	/** 
	* 查询多条数据
	* 
	* @access static
	* @name  getNumData($tablename,$where,$page,$num,$order='id DESC',$isNeadPager = true,$select = '*') 
	* @param $tablename  表名         'tg_member'
	* @param $where  	  查询条件  array('name'=>'qidada')
	* @param $select     查询字段  " id,name "
	* @param $pindex     分页查询页码 
	* @param $psize      分页查询每页数量
	* @param $order      排序查询
	* @return $res array($data,$pager,$total) $data:查询的数据 $pager:分页结果 $total :数据总条数
	*/
	static function getNumData($select,$tablename,$where,$order,$pindex,$psize,$ifpage){
		global $_W;
		$data = self::createStandardWhereString($where);
		$countStr = "SELECT COUNT(*) FROM ".tablename($tablename) ." WHERE $data[0] ";
		$selectStr = "SELECT $select FROM ".tablename($tablename) ." WHERE $data[0] ";
		$res = self::getDataIfPage($countStr,$selectStr,$data[1],$pindex,$psize,$order,$ifpage);
		return $res;
	}
	/** 
	* 查询数据共用方法
	* 
	* @access static
	* @name  getDataIfPage
	* @param $tablename  表名         'tg_member'
	* @param $where  	  查询条件  array('name'=>'qidada')
	* @param $select     查询字段  " id,name "
	* @param $pindex     分页查询页码 
	* @param $psize      分页查询每页数量
	* @param $order      排序查询
	* @return $res array($data,$pager,$total) $data:查询的数据 $pager:分页结果 $total :数据总条数
	*/
	static function getDataIfPage($countStr,$selectStr,$params,$pindex,$psize,$order,$ifpage){
		
			$pindex = max(1, intval($pindex));
			$total =  $ifpage?pdo_fetchcolumn($countStr,$params):'';
			if($psize>0 && $ifpage){
				$data = pdo_fetchall($selectStr." ORDER BY $order " . " LIMIT " . ($pindex - 1) * $psize . ',' . $psize,$params);
			}else{
				$data = pdo_fetchall($selectStr." ORDER BY $order",$params);
			}
			$pager =  pagination($total, $pindex, $psize);	
			
			return array($data,$pager,$total);
	}	
	/** 
	* 创建标准查询条件字符串
	* 
	* @access static
	* @name  createStandardWhereString($where)
	* @param $where  	  查询条件  array('name'=>'qidada')
	*        注：= ,>= ,<= <,>,@(模糊查询),#(in)必须紧挨字符 例：$where = array('id'=>1,'createtime<'=>time(),'@name'=>'qidada','#status'=>(1,2,3)); 
	* @return array 
	*/  
 	static function createStandardWhereString($where=array()){
		global $_W;
		if(!is_array($where)) return false;
		$where['uniacid'] = $where['uniacid']>0?$where['uniacid']:$_W['uniacid'];
		$sql = '';
		foreach($where as $k=>$v){
			$i=0;
			if(isset($k) && $v === '') message('存在异常参数'.$k);
			if(strpos($k,'>') !== false){
				$k = trim(trim($k),'>');
				$eq = ' >= ';
			}elseif(strpos($k,'<') !== false){
				$k = trim(trim($k),'<');
				$eq = ' <= ';
			}elseif(strpos($k,'@') !== false){ 
				$eq = ' LIKE ';
				$k = trim(trim($k),'@');
				$v = "%".$v."%";
			}elseif(strpos($k,'#') !== false){
				$i=1;
				$eq = ' IN ';
				$k = trim(trim($k),'#');
			}elseif(strpos($k,'!=') !== false){
				$i=1;
				$eq = ' != ';
				$k = trim(trim($k),'!=');
			}elseif(strpos($k,'^') !== false){
				$i=2;
				$arr = explode("^",$k);
				$num = count($arr);
				$str = '(';
				for($j=0;$j<$num;$j++){
					if($num-$j==1){
						$str .= $arr[$j]." LIKE  '%".$v."%'";
					}else{
						$str .= $arr[$j]." LIKE  '%".$v."%'" ." or ";
					}
				}
				$str .=')';
			}elseif(strpos($k,'&') !== false){
				$i=3;
				$k = trim(trim($k),'&');
				$str = "( ".$k." is null or ".$k."=0 ) ";
			}else{
				$eq = ' = ';
			}
			if($i==1){
				$sql .= 'AND `'.$k.'`'.$eq.$v.' ';
			}elseif($i==2){
				$sql .= 'AND '.$str;
			}elseif($i==3){
				$sql .= 'AND '.$str;
			}else{
				if($params[':'.$k]){
					$sql .= 'AND `'.$k.'`'.$eq.':2'.$k.' ';
					$params[':2'.$k] = $v;
				}else{
					$sql .= 'AND `'.$k.'`'.$eq.':'.$k.' ';
					$params[':'.$k] = $v;
				}
			}
			
		}
		$sql = trim($sql,'AND');
		return array($sql,$params);
	}	
	/** 
	* 获取数据先查询缓存数据
	* 
	* @access static
	* @name  getDataByCacheFirst($key,$name,$funcName,$valueArray) 
	* @param $key		  关键字         'goods'
	* @param $name  	  关键字         'id'
	* @param $funcName   array 调用方法所属类和该方法名
	* @param $valueArray 调用方法传参 
	* @return $data 缓存数据
	*/
	static function getDataByCacheFirst($key,$name,$funcName,$valueArray){
		
		$data = self::getCache($key,$name);
		if(empty($data)){
			$data = call_user_func_array($funcName,$valueArray);
			self::setCache($key,$name,$data);
		}
		return $data;
	}
	/** 
	* 获取缓存数据
	* 
	* @access static
	* @name  getCache($key,$name) 
	* @param $key		  关键字         'goods'
	* @param $name  	  关键字         'id'
	* @return $data 缓存数据
	*/
 	static function getCache($key,$name) {
		global $_W;
		if(empty($key) || empty($name)) return false;
		return cache_read('feng_fightgroups:'.$_W['uniacid'].':'.$key.':'.$name);
	}
	/** 
	* 设置缓存数据
	* 
	* @access static
	* @name  getCache($key,$name) 
	* @param $key		  关键字         'goods'
	* @param $name  	  关键字         'id'
	* @param $value  	  关键字对应的缓存数据
	* @return 
	*/
	static function setCache($key,$name,$value) {
		global $_W;
		if(empty($key) || empty($name)) return false;	
		$res = cache_write('feng_fightgroups:'.$_W['uniacid'].':'.$key.':'.$name,$value);
		return $res;
	}
	
	/** 
	* 删除指定缓存数据
	* 
	* @access static
	* @name  getCache($key,$name) 
	* @param $key		  关键字         'goods'
	* @param $name  	  关键字         'id'
	* @return 
	*/
	static function deleteCache($key,$name) {
		global $_W;		
		if(empty($key) || empty($name)) return false;
		return cache_delete('feng_fightgroups:'.$_W['uniacid'].':'.$key.':'.$name);
	}
	
	/** 
	* 删除所有缓存数据
	* 
	* @access static
	* @name  getCache($key,$name) 
	* @param $key		  关键字         'goods'
	* @param $name  	  关键字         'id'
	* @param $value  	  关键字对应的缓存数据
	* @return 
	*/
	static function deleteAllCache(){
		global $_W;
		$res = cache_clean();
		return $res;
	}
	/** 
	* 生成核销码
	* 
	* @access static
	* @name  getCache($key,$name) 
	* @param $key		  关键字         'goods'
	* @param $name  	  关键字         'id'
	* @param $value  	  关键字对应的缓存数据
	* @return 
	*/
	static function createBdeleteNumber(){
		$str = '';
		$chars = '0123456789';
		for ($i = 0; $i < 8; $i++) {
			$str .= $chars[mt_rand(0, strlen($chars) - 1)];
		}
		return $str;
	}
	/** 
	* 函数的含义说明 
	* 
	* @access public
	* @name 方法名称 
	* @param mixed  参数一的说明 
	* @return array 
	*/  
	static function wl_log($filename,$path,$filedata){
		$url_log = $path."log/".date('Y-m-d',time())."/".$filename.".log";
		$url_dir = $path."log/".date('Y-m-d',time());
		if (!is_dir($url_dir)){
			mkdir($url_dir, 0777, true);
		}
		
		file_put_contents($url_log, var_export('/====================================================================================='.date('Y-m-d H:i:s',time()).'/', true).PHP_EOL, FILE_APPEND);
		file_put_contents($url_log, var_export($filedata, true).PHP_EOL, FILE_APPEND);
		return 'log_success';
	}
	
	static function getOneMemberByCache(){
		global $_W;
		$addresss = self::getCache('orderTip','10000');
		if(empty($addresss)){
			$addresss = pdo_fetchall("SELECT openid,city FROM".tablename('tg_address')."WHERE 1 limit 1,10000");
			self::setCache('orderTip','10000',$addresss);
		}
		$index = rand(1, count($addresss));
		$address = $addresss[$index] ;
		$member = pdo_fetch("select nickname,avatar from ".tablename('tg_member')." where  openid='{$address['openid']}'");
		$list['nickname'] = mb_substr($member['nickname'], 0,4,'utf-8');	
		$list['avatar'] = $member['avatar'];	
		$list['city'] = $address['city'];
		$sec = rand(1,10);
		$list['sec'] = $sec;
		return $list;
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
}
	
	
?>