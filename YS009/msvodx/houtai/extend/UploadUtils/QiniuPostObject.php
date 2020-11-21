<?php
/**
 * 七牛云表单POST上传封装类
 * Author:  dreamer
 * Date:    2017/11/20
 */

namespace UploadUtils;

use Qiniu\Auth;
use Qiniu\Zone;

class QiniuPostObject
{

    private $config = null;
    private $serverDomain = [
        "华东"=>"http://upload.qiniup.com",
        "华北"=>"http://upload-z1.qiniup.com",
        "华南"=>"http://upload-z2.qiniup.com",
        "北美"=>"http://upload-na0.qiniup.com"
    ];

    public function __construct($config)
    {
        $this->config = $config;
    }


    /**
     * 生成七牛云 web直传的必要参数
     * @return array
     * @throws \Exception
     */
    public function getFormParams($fileName='')
    {
        if (!$this->config) throw new \Exception('请先给予七牛云存储配置信息后再操作.');

        //参数判断
        if(!isset($this->config['qiniu_accesskey']) || !isset($this->config['qiniu_secretkey']) || !isset($this->config['qiniu_bucket']) || !isset($this->config['qiniu_upload_server']) || !isset($this->config['qiniu_resource_default_domain']))
        {
            throw new \Exception('配置不完整，请正确配置七牛云相关设置后重试');
        }

        $accessId = $this->config['qiniu_accesskey'];
        $secretKey = $this->config['qiniu_secretkey'];
        $bucket = $this->config['qiniu_bucket'];
        $psotHost =$this->serverDomain[$this->config['qiniu_upload_server']];
        $resourceDomain = $this->config['qiniu_resource_default_domain'];

        $auth = new Auth($accessId, $secretKey);

        if(empty($fileName)) $fileName=$this->randomStr();
        $token = $auth->uploadToken($bucket);

        $response = [
            'key'=>$fileName,
            'token'=>$token,
            'post_url'=>$psotHost,
            'resource_domain'=>$resourceDomain
        ];

        return $response;
    }


    /**
     * 生成指定长度的随机字符串
     * @param int $len
     * @return string
     */
    public function randomStr($len=0){

        $str='abcdefghijklmnopqrstuvwxyz0123456789';
        $returnStr='';
        if($len==0) $len=32;

        for($i=0;$i<$len;$i++){
            $returnStr.=substr($str,rand(0,strlen($str)),1);
        }

        return $returnStr;
    }
}