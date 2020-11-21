<?php

ini_set("display_errors", "on");

require_once __DIR__ . '/ali_sdk/vendor/autoload.php';

use Aliyun\Core\Config;
use Aliyun\Core\Exception\ClientException;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Dypls\Request\V20170525\BindAxbRequest;
use Aliyun\Api\Dypls\Request\V20170525\BindAxnRequest;
use Aliyun\Api\Dypls\Request\V20170525\UnbindSubscriptionRequest;
use Aliyun\Api\Dypls\Request\V20170525\UpdateSubscriptionRequest;
use Aliyun\Api\Dypls\Request\V20170525\QueryRecordFileDownloadUrlRequest;
use Aliyun\Api\Dypls\Request\V20170525\QuerySubscriptionDetailRequest;
use Aliyun\Api\Dypls\Request\V20170525\BindAxnExtensionRequest;

// 加载区域结点配置
Config::load();

/**
 * Class PlsDemo
 *
 * 号码隐私保护API产品的DEMO程序，直接执行此文件即可体验号码隐私保护产品API功能
 * (只需要将AK替换成开通了云通信-号码隐私保护产品功能的AK即可)
 * 备注:Demo工程编码采用UTF-8
 */
class Alimsg
{

    static $acsClient = null;

    static $accessKeyId = null;
    static $accessKeySecret = null;
    static $chizi  = null;
    static $during = null;

    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public static function getAcsClient() {
        //产品名称:云通信号码隐私保护服务API产品,开发者无需替换
        $product = "Dyplsapi";

        //产品域名,开发者无需替换
        $domain = "dyplsapi.aliyuncs.com";

        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = self::$accessKeyId; // AccessKeyId

        $accessKeySecret = self::$accessKeySecret; // AccessKeySecret


        // 暂时不支持多Region
        $region = "cn-hangzhou";

        // 服务结点
        $endPointName = "cn-hangzhou";


        if(static::$acsClient == null) {

            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }


    /**
     * AXB绑定接口
     *
     * @return stdClass
     * @throws ClientException
     */
    public static function bindAxb() {

        //组装请求对象-具体描述见控制台-文档部分内容
        $request = new BindAxbRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        //必填:号池Key
        $request->setPoolKey(self::$chizi);

        //必填:AXB关系中的A号码
        $request->setPhoneNoA("15010101010");

        //必填:AXB关系中的B号码
        $request->setPhoneNoB("15020202020");

        //可选:指定X号码进行绑定
        $request->setPhoneNoX("1700000000");

        //可选:期望分配X号码归属的地市(省去地市后缀后的城市名称)
        $request->setExpectCity("北京");

        //必填:绑定关系对应的失效时间-不能早于当前系统时间
        $request->setExpiration("2017-09-08 17:00:00");

        //可选:是否需要录制音频-默认是false
        $request->setIsRecordingEnabled(false);

        //可选:外部业务自定义ID属性
        $request->setOutId("yourOutId");

        //hint 此处可能会抛出异常，注意catch
        $response = static::getAcsClient()->getAcsResponse($request);

        return $response;
    }

    /**
     * AXN绑定接口
     *
     * @return stdClass
     * @throws ClientException
     */
    public static function bindAxn($driverMobile,$log_id) {

        //组装请求对象-具体描述见控制台-文档部分内容
        $request = new BindAxnRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        //必填:号池Key
        $request->setPoolKey(self::$chizi);

        //必填:AXB关系中的A号码
        $request->setPhoneNoA($driverMobile);

        //可选:AXN中A拨打X的时候转接到的默认的B号码,如果不需要则不设置
//        $request->setPhoneNoB("15020202020");

        //可选:指定X号码进行选号
//        $request->setPhoneNoX("17000000000");

        //可选:期望分配X号码归属的地市(省去地市后缀后的城市名称)
        $request->setExpectCity("北京");

        //必填:95中间号,NO_170代表选择使用170号码资源
        $request->setNoType("NO_95");

        //必填:绑定关系对应的失效时间-不能早于当前系统时间
//        $request->setExpiration("2017-09-08 17:00:00");
        $during = self::$during * 60;
        $expire_data = date("Y-m-d H:i:s",time() + $during);
        $request->setExpiration($expire_data);

        //可选:是否需要录制音频-默认是false
        $request->setIsRecordingEnabled(false);

        //可选:外部业务自定义ID属性
        $request->setOutId($log_id);

        //hint 此处可能会抛出异常，注意catch
        $response = static::getAcsClient()->getAcsResponse($request);

        return $response;
    }

    /**
     * 解绑接口
     *
     * @return stdClass
     * @throws ClientException
     */
    public static function unbindSubscription($subsId, $secretNo) {

        //组装请求对象
        $request = new UnbindSubscriptionRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        //必填:号池Key
        $request->setPoolKey("FC123456");

        //必填:对应的产品类型
//        $request->setProductType("AXB_170");
        $request->setProductType("AXN_95");

        //必填-分配的X小号-对应到绑定接口中返回的secretNo;
        $request->setSecretNo($secretNo);

        //必填-绑定关系对应的ID-对应到绑定接口中返回的subsId;
        $request->setSubsId($subsId);

        //hint 此处可能会抛出异常，注意catch
        $response = static::getAcsClient()->getAcsResponse($request);

        return $response;
    }

    /**
     * 更新绑定关系
     *
     * @return stdClass
     * @throws ClientException
     */
    public static function updateSubscription($subsId, $secretNo,$bMobile) {

        //组装请求对象
        $request = new UpdateSubscriptionRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        //必填:号池Key
        $request->setPoolKey(self::$chizi);
//        $request->setPoolKey(self::$chizi);

        //必填: 您所选择的产品类型,目前支持AXB_170、AXN_170、AXN_95三种产品类型
        $request->setProductType("AXN_95");

        //必填: 创建绑定关系API接口所返回的订购关系ID
        $request->setSubsId($subsId);

        //必填: 创建绑定关系API接口所返回的X号码
        $request->setPhoneNoX($secretNo);


        // todo 以下操作三选一, 目前支持三种类型: updateNoA(修改A号码)、updateNoB(修改B号码)、updateExpire(更新绑定关系有效期)

        // -------------------------------------------------------------------

        // 1. 修改A号码示例：
        // 必填: 操作类型
//        $request->setOperateType("updateNoA");

        // OperateType为updateNoA时必选: 需要修改的A号码
//        $request->setPhoneNoA("150000000");

        // -------------------------------------------------------------------

        // 2. 修改B号码示例：
        // 必填: 操作类型
         $request->setOperateType("updateNoB");

        // OperateType为updateNoB时必选: 需要修改的B号码
         $request->setPhoneNoB($bMobile);

        // -------------------------------------------------------------------

        // 3. 更新绑定关系有效期示例：
        // 必填: 操作类型
        // $request->setOperateType("updateExpire");

        // OperateType为updateExpire时必选: 需要修改的绑定关系有效期
        // $request->setExpiration("2017-09-05 12:00:00");

        // -------------------------------------------------------------------

        // 此处可能会抛出异常，注意catch
        $response = static::getAcsClient()->getAcsResponse($request);

        return $response;
    }

    /**
     * 获取录音文件下载链接
     *
     * @return stdClass
     * @throws ClientException
     */
    public static function queryRecordFileDownloadUrl() {

        //组装请求对象
        $request = new QueryRecordFileDownloadUrlRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        //必填:号池Key
        $request->setPoolKey("FC123456");

        //必填: 对应的产品类型,目前一共支持三款产品AXB_170,AXN_170,AXN_95
        $request->setProductType("AXB_170");

        //必填: 话单回执中返回的标识每一通唯一通话行为的callId
        $request->setCallId("abcedf1234");

        //必填: 话单回执中返回的callTime字段
        $request->setCallTime("2017-09-05 12:00:00");

        //hint 此处可能会抛出异常，注意catch
        $response = static::getAcsClient()->getAcsResponse($request);

        return $response;
    }

    /**
     * 查询绑定关系详情
     *
     * @return stdClass
     * @throws ClientException
     */
    public static function querySubscriptionDetail() {

        //组装请求对象
        $request = new QuerySubscriptionDetailRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        //必填:号池Key
        $request->setPoolKey("FC123456");

        //必填: 产品类型,目前一共支持三款产品AXB_170,AXN_170,AXN_95
        $request->setProductType("AXB_170");

        //必填: 绑定关系ID
        $request->setSubsId("123456");

        //必填: 绑定关系对应的X号码
        $request->setPhoneNoX("170000000");

        //hint 此处可能会抛出异常，注意catch
        $response = static::getAcsClient()->getAcsResponse($request);

        return $response;
    }


    /**
     * AXN分机复用绑定
     *
     * @return stdClass
     * @throws ClientException
     */
    public static function bindAxnExtension() {

        //组装请求对象
        $request = new BindAxnExtensionRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        //必填:对应的号池Key
        $request->setPoolKey("FC12345678");

        //必填:AXN关系中的A号码
        $request->setPhoneNoA("15010101010");

        //可选:分机号，如果不填，自动分配1-3位
        $request->setExtension("103");

        //必填:绑定关系对应的失效时间-不能早于当前系统时间
        $request->setExpiration("2017-09-08 17:00:00");

        //可选:是否需要录制音频-默认是false
        $request->setIsRecordingEnabled(false);

        //外部业务自定义ID属性
        $request->setOutId("yourOutId");

        //hint 此处可能会抛出异常，注意catch
        $response = static::getAcsClient()->getAcsResponse($request);

        return $response;
    }
}

// 调用示例：
/*set_time_limit(0);
header("Content-Type: text/plain; charset=utf-8");

$axbResponse = PlsDemo::bindAxb();
echo "AXB绑定(bindAxb)接口返回的结果:\n";
echo "Code={$axbResponse->Code}\n";
echo "Message={$axbResponse->Message}\n";
echo "RequestId={$axbResponse->RequestId}\n";
$axbSubsId = !empty($axbResponse->SecretBindDTO) ? $axbResponse->SecretBindDTO->SubsId : null;
$axbSecretNo = !empty($axbResponse->SecretBindDTO) ? $axbResponse->SecretBindDTO->SecretNo : null;
echo "subsId={$axbSubsId}\n";
echo "secretNo={$axbSecretNo}\n";

sleep(3);

if ($axbResponse->Code === "OK") {
    $unbind = PlsDemo::unbindSubscription($axbSubsId, $axbSecretNo);
    echo "解绑(unbindSubscription)接口返回的结果\n";
    echo "Code={$axbResponse->Code}\n";
    echo "Message={$axbResponse->Message}\n";
    echo "RequestId={$axbResponse->RequestId}\n";

    sleep(3);
}

$axnResponse = PlsDemo::bindAxn();
echo "AXN绑定(bindAxn)接口返回的结果:\n";
echo "Code={$axnResponse->Code}\n";
echo "Message={$axnResponse->Message}\n";
echo "RequestId={$axnResponse->RequestId}\n";
$axnSubsId = !empty($axnResponse->SecretBindDTO) ? $axnResponse->SecretBindDTO->SubsId : null;
$axnSecretNo = !empty($axnResponse->SecretBindDTO) ? $axnResponse->SecretBindDTO->SecretNo : null;
echo "subsId={$axnSubsId}\n";
echo "secretNo={$axnSecretNo}\n";

sleep(3);

if($axnResponse->Code === "OK") {
    $unbind = PlsDemo::unbindSubscription($axnSubsId, $axnSecretNo);
    echo "解绑(unbindSubscription)接口返回的结果:\n";
    echo "Code={$axnResponse->Code}\n";
    echo "Message={$axnResponse->Message}\n";
    echo "RequestId={$axnResponse->RequestId}\n";
}

sleep(3);

$response = PlsDemo::updateSubscription();
echo "更新绑定关系(UpdateSubscription)接口返回的结果:\n";
print_r($response);


sleep(3);

$response = PlsDemo::queryRecordFileDownloadUrl();
echo "获取录音文件下载链接(QueryRecordFileDownloadUrl)接口返回的结果:\n";
print_r($response);


sleep(3);

$response = PlsDemo::querySubscriptionDetail();
echo "查询绑定关系详情(QuerySubscriptionDetail)接口返回的结果:\n";
print_r($response);


sleep(3);

$response = PlsDemo::bindAxnExtension();
echo "AXN分机复用绑定(BindAxnExtension)接口返回的结果:\n";
print_r($response);*/
