<?php
/**
 * NOP API: nuomi.integration_cashier.IntegrationCashierConsumeNotify request
 * 
 * @author sdk-maker
 * @since 1.0, 2015.12.29
 */
abstract class NuomiBaseRequest
{

    protected $interfaceBelongToWhichPlatform = null;

    /**
     * @var array 接口中使用的参数
     */
    protected $apiParams = array();

    /**
     * @return array
     */
    public function getApiParams()
    {
        return $this->apiParams;
    }

    /**
     * @return null
     */
    public function getRequestPlatform(){
        return $this->interfaceBelongToWhichPlatform;
    }


    /**
     * @notice 无论是openapi还是nop都需要设置appKey参数，所以放到基类中来
     * @param int $appKey
     */
    public function setAppKey($appKey){
        $this->apiParams['appKey'] = $appKey;
    }

    /**
     * @param $rsaSign
     * @notice 无论是openapi还是nop都需要设置rsaSign参数，所以放到基类中来
     */
    public function setRsaSign($rsaSign){
        $this->apiParams['rsaSign'] = $rsaSign;
    }


}
