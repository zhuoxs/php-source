<?php
class jinyunzn{
	private $token;
	private $secret;
	/*
		接口类实例化参数
			$token	用户token
			$secret	用户密钥
	*/
	public function __construct($token,$secret){
		$this->token=$token;
		$this->secret=$secret;
	}
	/*
		检查指定打印机是否已激活
		参数说明：
			$seri_num	序列号
	*/
	public function check($seri_num){
		$params=array(
			'seri_num'=>$seri_num,
		);
		return $this->request('check',$params);
	}
	/*
		读取用户已激活打印机列表
		参数说明：
			无
	*/
	public function get_list(){
		return $this->request('list',array());
	}
	/*
		发起打印请求
		参数说明：
			$seri_num	打印机序列号
			$print_data		打印内容
			$print_type		打印类型，可不填
	*/
	public function printing($seri_num,$print_data,$print_type=0){
		$params=array(
			'seri_num'=>$seri_num,
			'print_data'=>$print_data,
			'print_type'=>$print_type,
		);
		return $this->request('print',$params);
	}
	/*
		整理请求数据
		参数说明：
			$action	请求类型，可能的值：print表示打印，list表示获取用户打印机列表，check表示检查指定打印机是否可用。
			$params	业务参数，和请求类型有关
	*/
	public function request($action,$params){
		$post=array(
			'timestamp'=>time(),
			'action'=>$action,
			'token'=>$this->token,
			'data'=>base64_encode(json_encode($params)),
		);
		$post['sign']=$this->get_sign($post,$this->secret);
		return $this->post($post);
	}
	/*
		向云平台发起请求
	*/
	public function post($post){
		$api_url='http://www.jinyunzn.com/api/print/index.php';
		$timeout=60;
		$ch = curl_init($api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		$res=curl_exec($ch);
		$res=@json_decode($res,true);
		return $res;
	}
	/*
		根据密钥生成签名
	*/
	public function get_sign($params,$secret){
		ksort($params);
		$sign_str='';
		foreach($params as $key=>$value){
			$sign_str.=$key.$value;
		}
		$sign_str.=$secret;
		return  md5($sign_str);
	}
}
