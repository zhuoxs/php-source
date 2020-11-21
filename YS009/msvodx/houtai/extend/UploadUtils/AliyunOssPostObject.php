<?php
/**
 * 阿里云表单POST上传封装类
 * Author:  dreamer
 * Date:    2017/11/20
 */

namespace UploadUtils;


class AliyunOssPostObject
{

    private $cityURLArray = [
        '杭州' => 'oss-cn-hangzhou',
        '上海' => 'oss-cn-shanghai',
        '青岛' => 'oss-cn-qingdao',
        '北京' => 'oss-cn-beijing',
        '张家口' => 'oss-cn-zhangjiakou',
        '深圳' => 'oss-cn-shenzhen',
        '香港' => 'oss-cn-hongkong',
        '硅谷' => 'oss-us-west-1',
        '弗吉尼亚' => 'oss-us-east-1',
        '新加坡' => 'oss-ap-southeast-1',
        '悉尼' => 'oss-ap-southeast-2',
        '日本' => 'oss-ap-northeast-1',
        '法兰克福' => 'oss-eu-central-1',
        '迪拜' => 'oss-me-east-1',
    ];
    private $config=null;

    public function __construct($config)
    {
        $this->config=$config;
    }


    /**
     * 格式化时间成gmt iso格式
     * @param $time
     * @return string
     */
    private function gmt_iso8601($time)
    {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration . "Z";
    }


    /**
     * 根据阿里云OSS配置信息，获取完整的bucket URL地址
     * @return string
     * @throws Exception
     */
    private function getBucketURL(){
        if(empty($this->config['aliyun_bucket'])) throw new \Exception('阿里云OSS的bucket不能为空.');

        if(isset($this->config['aliyun_oss_city'])&&isset($this->cityURLArray[$this->config['aliyun_oss_city']])){
            $cityUrl=$this->cityURLArray[$this->config['aliyun_oss_city']];
        }else{
            throw new \Exception('阿里云OSS的city信息配置不正确');
        }

        $url='http://' . $this->config['aliyun_bucket'] . '.' . $cityUrl. '.aliyuncs.com';

        return $url;
    }


    /**
     * 生成阿里云OSS web直传的必要参数
     * @return array
     * @throws \Exception
     */
    public function getFormParams()
    {
        if(!$this->config) throw new \Exception('请先给予阿里云OSS配置信息后再操作.');

        $id = $this->config['aliyun_accesskey'];
        $key = $this->config['aliyun_secretkey'];
        $host = $this->getBucketURL();

        $now = time();
        $expire = 30; //设置该policy超时时间
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);


        $callbackUrl='http://client.meisicms.com/aliyunOssNotify.php';
        $callback_param = array('callbackUrl'=>$callbackUrl,
            'callbackBody'=>'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}',
            'callbackBodyType'=>"application/x-www-form-urlencoded");
        $callback_string = json_encode($callback_param);
        $base64_callback_body = base64_encode($callback_string);


        //最大文件大小.用户可以自己设置
        $condition = array(0 => 'content-length-range', 1 => 0, 2 => 1048576000);
        $conditions[] = $condition;


        //上传目录
        $dir = date('Ymd') . "/";
        $start = array(0 => 'starts-with', 1 => '$key', 2 => $dir);
        $conditions[] = $start;

        $arr = array('expiration' => $expiration, 'conditions' => $conditions);

        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response = array();
        $response['OSSAccessKeyId'] = $id;
        $response['post_url'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        $response['key']=$dir;

        //默认添加: 否则oss成功后将会返回非200的代码
        $response['success_action_status']=200;

        //$response['callback']=$base64_callback_body;

        return $response;
    }
}