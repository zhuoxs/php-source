<?php
//namespace com\jdk5\blog\IDValidator;

class IDValidator {
	private static $GB2260;
	private static $instance;
	private static $cache = array();
	private static $util;
	function __construct() {
		if (!class_exists("GB2260")){
			include 'GB2260.php';
		}
		if (!class_exists("util")){
			include 'util.php';
		}
		self::$GB2260 = GB2260::getGB2260 ();
		self::$util = util::getInstance();
	}
	public static function getInstance() {
		if (is_null ( self::$instance )) {
			self::$instance = new IDValidator ();
		}
		return self::$instance;
	}
	function isValid($id) {
		$code = self::$util->checkArg ( $id );
		if ($code === false) {
			return false;
		}
		// 查询cache
		if (isset ( self::$cache [ $id ] ) && self::$cache [$id] ['valid'] !== false) {
			return self::$cache [$id] ['valid'];
		} else {
			if (! isset ( self::$cache [ $id ] )) {
				self::$cache [$id] = array ();
			}
		}

		$addr = substr ( $code ['body'], 0, 6 );
		$birth = $code ['type'] === 18 ? substr ( $code ['body'], 6, 8 ) :
			substr ( $code ['body'], 6, 6 );
		$order = substr ( $code ['body'], - 3 );

		if (! (self::$util->checkAddr ( $addr ) && self::$util->checkBirth ( $birth ) &&
			self::$util->checkOrder ( $order ))) {
			self::$cache [$id] ['valid'] = false;
			return false;
		}

		// 15位不含校验码，到此已结束
		if ($code ['type'] === 15) {
			self::$cache [$id] ['valid'] = true;
			return true;
		}

		/* 校验位部分 */

		// 位置加权
		$posWeight = array ();
		for($i = 18; $i > 1; $i --) {
			$wei = self::$util->weight ( $i );
			$posWeight [$i] = $wei;
		}

		// 累加body部分与位置加权的积
		$bodySum = 0;
		$bodyArr = str_split( $code ['body'] );
		for($j = 0; $j < count ( $bodyArr ); $j ++) {
			$bodySum += (intval ( $bodyArr [$j], 10 ) * $posWeight [18 - $j]);
		}

		// 得出校验码
		$checkBit = 12 - ($bodySum % 11);
		if ($checkBit == 10) {
			$checkBit = 'X';
		} else if ($checkBit > 10) {
			$checkBit = $checkBit % 11;
		}
		// 检查校验码
		if ($checkBit != $code ['checkBit']) {
			self::$cache [$id] ['valid'] = false;
			return false;
		} else {
			self::$cache [$id] ['valid'] = true;
			return true;
		}
	}
	// 分析详细信息
	function getInfo ($id) {
		// 号码必须有效
		if ($this->isValid($id) === false) {
			return false;
		}
		// TODO 复用此部分
		$code = self::$util->checkArg($id);

		// 查询cache
		// 到此时通过isValid已经有了cache记录
		if (isset(self::$cache[$id]) && isset(self::$cache[$id]['info'])) {
			return self::$cache[$id]['info'];
		}

		$addr = substr($code['body'], 0, 6);
		$birth = ($code['type'] === 18 ? substr($code['body'], 6, 8) :
				substr($code['body'], 6, 6));
		$order = substr($code['body'], -3);

		$info = array();
		$info['addrCode'] = $addr;
		if (self::$GB2260 !== null) {
			$info['addr'] = self::$util->getAddrInfo($addr);
		}
		$info ['birth'] = ($code ['type'] === 18 ? (substr ( $birth, 0, 4 ) . '-' . substr ( $birth, 4, 2 ) . '-' . substr ( $birth, - 2 )) : ('19' . substr ( $birth, 0, 2 ) . '-' . substr ( $birth, 2, 2 ) . '-' . substr ( $birth, - 2 )));
		$info['sex'] = ($order % 2 === 0 ? 0 : 1);
		$info['length'] = $code['type'];
		if ($code['type'] === 18) {
			$info['checkBit'] = $code['checkBit'];
		}

		// 记录cache
		self::$cache[$id]['info'] = $info;

		return $info;
	}
	
	// 仿造一个号
	function makeID ($isFifteen=false) {
		// 地址码
		$addr = null;
		if (self::$GB2260 !== null) {
			$loopCnt = 0;
			while ($addr === null) {
				// 防止死循环
				if ($loopCnt > 50) {
					$addr = 110101;
					break;
				}
				$prov = self::$util->str_pad(self::$util->rand(66), 2, '0');
				$city = self::$util->str_pad(self::$util->rand(20), 2, '0');
				$area = self::$util->str_pad(self::$util->rand(20), 2, '0');
				$addrTest = $prov . $city . $area;
				if (isset(self::$GB2260[$addrTest])) {
					$addr = $addrTest;
					break;
				}
				$loopCnt ++;
			}
		} else {
			$addr = 110101;
		}
	
		// 出生年
		$yr = self::$util->str_pad(self::$util->rand(99, 50), 2, '0');
		$mo = self::$util->str_pad(self::$util->rand(12, 1), 2, '0');
		$da = self::$util->str_pad(self::$util->rand(28, 1), 2, '0');
		if ($isFifteen) {
			return $addr . $yr . $mo . $da
				. self::$util->str_pad(self::$util->rand(999, 1), 3, '1');
		}
	
		$yr = '19' . $yr;
		$body = $addr . $yr . $mo . $da . self::$util->str_pad(self::$util->rand(999, 1), 3, '1');
	
		// 位置加权
		$posWeight = array();
		for ($i = 18; $i > 1; $i--) {
			$wei = self::$util->weight($i);
			$posWeight[$i] = $wei;
		}
	
		// 累加body部分与位置加权的积
		$bodySum = 0;
		$bodyArr = str_split($body);
		for ($j = 0; $j < count($bodyArr); $j++) {
			$bodySum += (intval($bodyArr[$j], 10) * $posWeight[18 - $j]);
		}
	
		// 得出校验码
		$checkBit = 12 - ($bodySum % 11);
		if ($checkBit == 10) {
			$checkBit = 'X';
		} else if ($checkBit > 10) {
			$checkBit = $checkBit % 11;
		}
		return ($body . $checkBit);
	}
}
