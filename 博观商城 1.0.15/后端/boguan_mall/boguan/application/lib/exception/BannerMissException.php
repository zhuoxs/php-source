<?php 
	namespace app\lib\exception;
	
	class BannerMissException extends BaseException{
		//http状态码
		public $code = 400;
		//错误具体信息
		public $msg = '请求的banner不存在！';
		//自定义状态码
		public $errorcode = 10001;
	}
?>