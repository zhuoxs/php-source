<?php
/**
 * NOP API: nuomi.integration_cashier.IntegrationCashierConsumeNotify request
 * 
 * @author sdk-maker
 * @since 1.0, 2015.12.29
 */
class NuomiOpenApiBaseRequest extends NuomiBaseRequest
{
	/**
	 * @desc 设置需要请求的HOST
	 * @var string
	 */
	private $host = 'http://u.nuomi.com/platform/userinfo/tokenhandler/getuserinfo';

	/**
	 * @var string 输入哪个平台的接口
	 */
	protected $interfaceBelongToWhichPlatform = 'openapi';

	/**
	 * @desc openapi的拼装方式不一样
	 * @param $host
	 * @param $uri
	 * @return string
	 */
	public function getUrlForOpenApi(){
		return sprintf('%s/%s',$this->host,$this->uri);
	}






}
