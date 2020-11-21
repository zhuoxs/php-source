<?php

use OSS\OssClient;
use OSS\Core\OssException;

require 'aliyun-oss-php-sdk-2.3.0.phar';
class AliOss {
     protected $dir_url;//存文件的路径
     protected $upname; //文件记名字
          function __construct($dir_url,$upname) {
            $this->dir_url = $dir_url;
            $this->upname = $upname;
        }
         public function Alyunos()
            {
                $accessKeyId = "LTAI1jmlOyu4XDQX";
                $accessKeySecret = "CZbAXWU3vLXMtCq60anLpeTEDvYGyS";
                $endpoint = "http://oss.webstrongtech.net.w.kunlunar.com";
                try {
                    $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                } catch (OssException $e) {
                    print $e->getMessage();
                    exit();
                }
                $bucket = 'webstrong';
                $object = 'hyb_yl/'.$this->upname;
                $filePath =$this->dir_url.'/'.$this->upname;
                try{
                    $mm=$ossClient->uploadFile($bucket,$object,$filePath);
                    $mp4 = $mm['info']['url'];
                    return $mp4;
                } catch(OssException $e) {
                    printf($e->getMessage() . "\n");
                    exit();
                }
            }

    }
