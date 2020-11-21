<?php 
	
class Util 
{
	//查询缓存
 	static function getCache($key,$name) {
		global $_W;
		if(empty($key) || empty($name)) return false;
		return cache_read('weliam_shiftcar:'.$_W['uniacid'].':'.$key.':'.$name);
	}
	
	//设置缓存
	static function setCache($key,$name,$value) {
		global $_W;
		if(empty($key) || empty($name)) return false;	
		
		$res = cache_write('weliam_shiftcar:'.$_W['uniacid'].':'.$key.':'.$name,$value);
		return $res;
	}
	
	//删除缓存
	static function deleteCache($key,$name) {
		global $_W;		
		if(empty($key) || empty($name)) return false;
		
		return cache_delete('weliam_shiftcar:'.$_W['uniacid'].':'.$key.':'.$name);
	}
	
	//删除所有缓存 每次设置参数后都要删除
	static function deleteThisModuleCache(){
		global $_W;
		$res = cache_clean('weliam_shiftcar');
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
    
    public static function long2short($longurl){
    	load()->model('account');
    	load()->func('communication');
		$longurl = trim($longurl);
		$token = WeAccount::token();
		$url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token={$token}";
		$send = array();
		$send['action'] = 'long2short';
		$send['long_url'] = $longurl;
		$response = ihttp_request($url, json_encode($send));
		if(is_error($response)) {
			$result = error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
		}
		$result = @json_decode($response['content'], true);
		if(empty($result)) {
			$result =  error(-1, "接口调用失败, 元数据: {$response['meta']}");
		} elseif(!empty($result['errcode'])) {
			$result = error(-1, "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']}");
		}
		if(is_error($result)) {
			$result = array('errcode' => -1, 'errmsg' => $result['message']);
		}
		return $result;
    }
	
	/** 
	* 二维数组转一维数组 
	* 
	* @access static public
	* @name i_array_column 
	* @param $input $columnKey $indexKey 
	* @return json 
	*/  
	static function i_array_column($input, $columnKey, $indexKey=null){
	    if(!function_exists('array_column')){ 
	        $columnKeyIsNumber  = (is_numeric($columnKey))?true:false; 
	        $indexKeyIsNull            = (is_null($indexKey))?true :false; 
	        $indexKeyIsNumber     = (is_numeric($indexKey))?true:false; 
	        $result                         = array(); 
	        foreach((array)$input as $key=>$row){ 
	            if($columnKeyIsNumber){ 
	                $tmp= array_slice($row, $columnKey, 1); 
	                $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null; 
	            }else{ 
	                $tmp= isset($row[$columnKey])?$row[$columnKey]:null; 
	            } 
	            if(!$indexKeyIsNull){ 
	                if($indexKeyIsNumber){ 
	                  $key = array_slice($row, $indexKey, 1); 
	                  $key = (is_array($key) && !empty($key))?current($key):null; 
	                  $key = is_null($key)?0:$key; 
	                }else{ 
	                  $key = isset($row[$indexKey])?$row[$indexKey]:0; 
	                } 
	            } 
	            $result[$key] = $tmp; 
	        } 
	        return $result; 
	    }else{
	        return array_column($input, $columnKey, $indexKey);
	    }
	}
    
	static function getdistance($lng1, $lat1, $lng2, $lat2) {
        //将角度转为狐度
        $radLat1 = @deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = @deg2rad($lat2);
        $radLng1 = @deg2rad($lng1);
        $radLng2 = @deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2) , 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2) , 2))) * 6378.137 * 1000;
        return $s;
    }
	
	static function currency_format($currency, $decimals = 2) {
		$currency = floatval($currency);
		if (empty($currency)) {
			return '0.00';
		}
		$currency = number_format($currency, $decimals);
		$currency = str_replace(',', '', $currency);
		return $currency;
	}
	
	/**
	 * 遍历子文件件
	 *
	 * @access static public
	 * @name traversingFiles
	 * @param $dir  父级文件路径
	 * @return array
	 */
	static function traversingFiles($dir) {
		if (!file_exists($dir))
			return array();
		$styles = array();
		if ($handle = opendir($dir)) {
			while (($file = readdir($handle)) !== false) {
				if ($file != ".." && $file != ".") {
					if (is_dir($dir . "/" . $file)) {
						$styles[] = $file;
					}
				}
			}
			closedir($handle);
		}
		return $styles;
	}
	
	/**
	 * 加密密码
	 *
	 * @access static public
	 * @name encryptedPassword
	 * @param $password  密码
	 * @param $salt  密码
	 * @param $flag  特殊标记
	 * @return array
	 */
	static function encryptedPassword($password, $salt, $flag = '') {
		return md5($salt . $password . $flag);
	}
	
	/**
	 * 生成加密盐
	 *
	 * @access static public
	 * @name createSalt
	 * @param $num  加密盐位数
	 * @return string
	 */
	static function createSalt($num = 6) {
		$salt = '';
		$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		$max = strlen($strPol) - 1;
		for ($i = 0; $i < $num; $i++) {
			$salt .= $strPol[rand(0, $max)];
			//rand($min,$max)生成介于min和max两个数之间的一个随机整数
		}
		return $salt;
	}
}