<?php
/**
 * NOP API: nuomi.integration_cashier.IntegrationCashierConsumeNotify request
 * 
 * @author sdk-maker
 * @since 1.0, 2015.12.29
 */

class NuomiIntegrationCashierGetUserInfoRequest extends NuomiOpenApiBaseRequest
{
	protected $uri = 'platform/userinfo/tokenhandler/getuserinfo';


	/**
	 * @notice 获取用户信息接口独有的参数
	 * @param string $token 用户校验的令牌环值
	 */
	public function setToken( $token ){
		$this->apiParams['token'] = $token;
	}

	/**
     * @param string $params
     * @return string
	 * @desc 这里添加必要的检验就可以，业务方也可以自己添加
	 * @throws Exception
	 */
	public function checkRequestParams($params)
	{

		$keys = array('appKey','sign','token');

		foreach($keys as $key){

			$value = $params[$key];

			NuomiRequestParamsCheck::checkNotNull($key,$value);

		}

	}
	

}
