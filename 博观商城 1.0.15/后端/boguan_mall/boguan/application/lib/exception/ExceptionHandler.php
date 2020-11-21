<?php 
namespace app\lib\exception;
use think\exception\Handle;
use think\exception;
use think\Request;

class ExceptionHandler extends Handle{
	private $code;
	private $msg;
	private $errorCode;
	//需要返回客户端当前请求的url路径
	
	public function render(\Exception $e) {
		if($e instanceof BaseException){
			$this->code=$e->code;
			$this->msg=$e->msg;
			$this->errorCode=$e->errorcode;
		}else{
			if(config('app_debug')){
				return parent::render($e);
			}else{
				$this->code='500';
				$this->msg='服务器内部错误！';
				$this->errorCode=999;
			}
		}
		$request=Request::instance();
		$result=[
				'msg'=>$this->msg,
				'error_code'=>$this->errorCode,
				'request_url'=>$request->url()
		];
		return json($result,$this->code);
	}
	
	private function recordErrorLog(\Exception $e) {
		Log::init([
				'type'=>'File',
				'path'=>LOG_PATH,
				'level'=>['eroor']
		]);
		Log::record($e->getMessage(), 'error');
	}
}
?>