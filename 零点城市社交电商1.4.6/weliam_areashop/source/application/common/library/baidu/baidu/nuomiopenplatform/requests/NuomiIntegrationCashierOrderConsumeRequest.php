<?php
/**
 * NOP API: nuomi.integration_cashier.IntegrationCashierConsumeNotify request
 * 
 * @author sdk-maker
 * @since 1.0, 2015.12.29
 */
class NuomiIntegrationCashierOrderConsumeRequest extends NuomiNopBaseRequest
{

	public $nopMethod = 'nuomi.integration_cashier.IntegrationCashierConsumeNotify';


	/**
	 * @notice 通知消费独有的参数，不能从父类中继承
	 * @param int $orderId 糯米的订单ID,非业务方的订单ID
	 */
	public function setOrderId($orderId){
		$this->apiParams['orderId'] = $orderId;
	}

	/**
	 * @notice 通知消费独有的参数，不能从父类中继承
	 * @param int $userId 糯米的用户ID,非业务方的用户ID
	 */
	public function setUserId( $userId ){
		$this->apiParams['userId'] = $userId;
	}



	/**
     * @param array $params 
	 * @desc 这里添加必要的检验就可以，业务方也可以自己添加
	 * @throws Exception
	 */
	public function checkRequestParams($params)
	{

		$keys = array('appKey','rsaSign','orderId','userId');

		foreach($keys as $key){

			$value = $params[$key];

			NuomiRequestParamsCheck::checkNotNull($key,$value);

		}

	}
	

}
