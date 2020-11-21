<?php
/**
 * NOP API: nuomi.integration_cashier.IntegrationCashierConsumeNotify request
 * 
 * @author sdk-maker
 * @since 1.0, 2015.12.29
 */
abstract class NuomiNopBaseRequest extends NuomiBaseRequest
{

	protected $nopMethod = null;

	/**
	 * @desc 设置需要请求的HOST
	 * @var string
	 */
	protected $host = 'http://nop.nuomi.com/nop/server/rest';


	/**
	 * @var string 输入哪个平台的接口
	 */
	protected $interfaceBelongToWhichPlatform = 'nop';


	public function __construct()
	{
		$this->apiParams = array(
			'nop_appid' => 'yrO7h9xWcw',
			'nop_method' =>  $this->getNopMethod(),
			'nop_sign' => 'nuomiopenplatfomsdk',
			'nop_timestamp'=> time(),
		);
	}



	/**
	 * @desc 获取请求nop平台的method方法
	 * @return string
	 */
	public function getNopMethod()
	{
		return $this->nopMethod;
	}

	/**
	 * 获取请求的URL
	 * @param string $systemParams
     * @return string
	 */
	public function getUrlForNop($systemParams){

		$querystring = http_build_query($systemParams);

		//系统参数放querystring
		$url = $this->host . '?' . $querystring;

		return $url;
	}//function getUrlForNop() end


}
