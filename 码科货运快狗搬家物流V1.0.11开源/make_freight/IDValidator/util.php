<?php
//namespace com\jdk5\blog\IDValidator;

/**
 * 工具
 */
class util {
	private static $GB2260;
	private static $instance;
	function __construct() {
		if (!class_exists("GB2260")){
			include 'GB2260.php';
		}
		self::$GB2260 = GB2260::getGB2260 ();
	}
	public static function getInstance() {
		if (is_null ( self::$instance )) {
			self::$instance = new util ();
		}
		return self::$instance;
	}
	public function checkArg($id) {
		$id = strtoupper ( $id );
		$code = null;
		if (strlen ( $id ) === 18) {
			// 18位
			$code = array (
					"body" => substr ( $id, 0, 17 ),
					"checkBit" => substr ( $id, - 1 ),
					"type" => 18
			);
		} else if (strlen($id) === 15) {
			// 15位
			$code = array (
					"body" => $id,
					"type" => 15
			);
		} else {
			return false;
		}
		return $code;
	}

	// 地址码检查
	function checkAddr($addr) {
		$addrInfo = $this->getAddrInfo ( $addr );
		return ($addrInfo === false ? false : true);
	}

	// 取得地址码信息
	function getAddrInfo($addr) {
		// 查询GB/T2260,没有引入GB2260时略过
		if (self::$GB2260 === null) {
			return $addr;
		}
		if (! isset ( self::$GB2260 [$addr] )) {
			// 考虑标准不全的情况，搜索不到时向上搜索
			$tmpAddr = substr ( $addr, 0, 4 ) . '00';
			if (! isset ( self::$GB2260 [$tmpAddr] )) {
				$tmpAddr = substr ( $addr, 0, 2 ) . '0000';
				if (! isset ( self::$GB2260 [$tmpAddr] )) {
					return false;
				} else {
					return self::$GB2260 [$tmpAddr] . '未知地区';
				}
			} else {
				return self::$GB2260 [$tmpAddr] . '未知地区';
			}
		} else {
			return self::$GB2260 [$addr];
		}
	}

	// 生日码检查
	function checkBirth($birth) {
		$year = $month = $day = 0;
		if (strlen ( $birth ) == 8) {
			$year = intval ( substr ( $birth, 0, 4 ) );
			$month = intval ( substr ( $birth, 4, 2 ) );
			$day = intval ( substr ( $birth, - 2 ) );
		} else if (strlen($birth) == 6) {
			$year = intval ( '19' + substr ( $birth, 0, 2 ) );
			$month = intval ( substr ( $birth, 2, 2 ) );
			$day = intval ( substr($birth, - 2 ) );
		} else {
			return false;
		}
		// TODO 是否需要判断年份
		/*
		 * if( year<1800 ){ return false; }
		 */
		// TODO 按月份检测
		if ($month > 12 || $month === 0 || $day > 31 || $day === 0) {
			return false;
		}

		return true;
	}

	// 顺序码检查
	function checkOrder($order) {
		// 暂无需检测
		return true;
	}
	// 加权
	function weight($t) {
		return pow ( 2, $t - 1 ) % 11;
	}
	// 随机整数
	function rand($max, $min = 1) {
		//return round ( rand(0, 1) * ($max - $min) ) + $min;
		return rand($min, $max);
	}
	// 数字补位
	function str_pad($str, $len = 2, $chr = '0', $right = false) {
		$str = strval($str);
		if (strlen ( $str ) >= $len) {
			return $str;
		} else {
			for($i = 0, $j = $len - strlen ( $str ); $i < $j; $i ++) {
				if ($right) {
					$str = $str . $chr;
				} else {
					$str = $chr . $str;
				}
			}
			return $str;
		}
	}
}