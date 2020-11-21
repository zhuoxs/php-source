<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

error_reporting(0);

define('UC_CLIENT_VERSION', '1.6.0');
define('UC_CLIENT_RELEASE', '20110501');

define('API_DELETEUSER', 1);
define('API_RENAMEUSER', 1);
define('API_GETTAG', 1);
define('API_SYNLOGIN', 1);
define('API_SYNLOGOUT', 1);
define('API_UPDATEPW', 1);
define('API_UPDATEBADWORDS', 1);
define('API_UPDATEHOSTS', 1);
define('API_UPDATEAPPS', 1);
define('API_UPDATECLIENT', 1);
define('API_UPDATECREDIT', 1);
define('API_GETCREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_UPDATECREDITSETTINGS', 1);
define('API_ADDFEED', 1);
define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '1');

define('IN_SYS', true);
require '../framework/bootstrap.inc.php';
$query = $_GET;
if(is_array($query)) {
	$sql = "SELECT `uc` FROM " . tablename('uni_settings') . " WHERE `uniacid`=:uniacid LIMIT 1";
	$setting = pdo_fetch($sql, array(':uniacid' => $query['uniacid']));
	if(!empty($setting) && !empty($setting['uc'])) {
		$uc = iunserializer($setting['uc']);
		
		if(!empty($uc) && $uc['status'] == '1') {
			define('UC_CONNECT', $uc['connect'] == 'mysql' ? 'mysql' : '');
			
			define('UC_DBHOST', $uc['dbhost']);
			define('UC_DBUSER', $uc['dbuser']);
			define('UC_DBPW', $uc['dbpw']);
			define('UC_DBNAME', $uc['dbname']);
			define('UC_DBCHARSET', $uc['dbcharset']);
			define('UC_DBTABLEPRE', $uc['dbtablepre']);
			define('UC_DBCONNECT', $uc['dbconnect']);
			
			define('UC_CHARSET', $uc['charset']);
			define('UC_KEY', $uc['key']);
			define('UC_API', $uc['api']);
			define('UC_APPID', $uc['appid']);
			define('UC_IP', $uc['ip']);
			
			$get = $post = array();
			parse_str(authcode($query['code'], 'DECODE', UC_KEY), $get);

			if(TIMESTAMP - $get['time'] > 3600) {
				exit('Authracation has expiried');
			}
			if(empty($get)) {
				exit('Invalid Request');
			}
		
			include_once IA_ROOT . '/framework/library/uc/lib/xml.class.php';
			$input = file_get_contents('php://input');
			$post = xml_unserialize($input);
		
			if(in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcredit', 'getcreditsettings', 'updatecreditsettings', 'addfeed'))) {
				$note = new uc_note();
				echo $note->$get['action']($get, $post);
				exit();
			} else {
				exit(API_RETURN_FAILED);
			}
		}
	}
}

class uc_note {

	function _serialize($arr, $htmlon = 0) {
		return xml_serialize($arr, $htmlon);
	}

	function test($get, $post) {
		return API_RETURN_SUCCEED;
	}

	function deleteuser($get, $post) {
		if(!API_DELETEUSER) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function renameuser($get, $post) {
		if(!API_RENAMEUSER) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function gettag($get, $post) {
		if(!API_GETTAG) {
			return API_RETURN_FORBIDDEN;
		}
		return $this->_serialize(array($get['id'], array()), 1);
	}

	function synlogin($get, $post) {
		if(!API_SYNLOGIN) {
			return API_RETURN_FORBIDDEN;
		}
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		$cookietime = 31536000;
		$uid = intval($get['uid']);
		if(($member = getuserbyuid($uid, 1))) {
			dsetcookie('auth', authcode("$member[password]\t$member[uid]", 'ENCODE'), $cookietime);
		}
	}

	function synlogout($get, $post) {
		if(!API_SYNLOGOUT) {
			return API_RETURN_FORBIDDEN;
		}
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		dsetcookie('auth', '', -31536000);
	}

	function updatepw($get, $post) {
		if(!API_UPDATEPW) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function updatebadwords($get, $post) {
		if(!API_UPDATEBADWORDS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function updatehosts($get, $post) {
		if(!API_UPDATEHOSTS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function updateapps($get, $post) {
		if(!API_UPDATEAPPS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function updateclient($get, $post) {
		if(!API_UPDATECLIENT) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function updatecredit($get, $post) {
		if(!API_UPDATECREDIT) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function getcredit($get, $post) {
		if(!API_GETCREDIT) {
			return API_RETURN_FORBIDDEN;
		}
	}

	function getcreditsettings($get, $post) {
		if(!API_GETCREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
	}

	function updatecreditsettings($get, $post) {
		if(!API_UPDATECREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function addfeed($get, $post) {
		if(!API_ADDFEED) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}
}