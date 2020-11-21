<?php
defined('IN_IA') or exit('Access Denied');
require_once IA_ROOT."/addons/weliam_merchant/core/common/defines.php";
require_once PATH_CORE."common/autoload.php";
Func_loader::core('global');

class Weliam_merchantModuleProcessor extends WeModuleProcessor {

	public function respond() {
		global $_W;
		$rule = pdo_fetch('select * from ' . tablename('rule') . ' where id=:id limit 1', array(':id' => $this->rule));
		if (empty($rule)) {
			return false;
		}
		$message = $this -> message;
		file_put_contents(PATH_DATA."storeqr.log", var_export($message, true).PHP_EOL, FILE_APPEND);
		
		if($rule['name'] == '智慧城市商户二维码'){
			$news = Storeqr::Processor($message);
			return $this -> send_message($news);
		}else{
			$names = explode(':', $rule['name']);
			$plugin = (isset($names[1]) ? $names[1] : '');
			if(!empty($plugin)){
				$plugin::Processor($message);
			}
		}
	}
	
	public function send_message($message) {
		global $_W;
		if ($message['type'] == 'text') {
			return $this -> respText($message['data']);
		} elseif ($message['type'] == 'news') {
			return $this -> respNews($message['data']);
		}
		return false;
	}
}