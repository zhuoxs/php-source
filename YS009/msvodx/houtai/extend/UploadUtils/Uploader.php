<?php
/**
 * 全站上传工具类
 * Author:  xiangzhanyou
 * CreateDate:    2017-11-14
 * LastDate:      2017-11-17
 */


namespace UploadUtils;

use think\Exception;
use think\Db;

use UploadUtils\AliyunOssPostObject;
use UploadUtils\QiniuPostObject;



class Uploader
{

    private $uploadType;    //aliyunoss,qiniuyun,web_server,yunzhuanma
    private $clientDb;      //client db
    private $dbConfig;      //save the db config
    private static $_intance = null;      //单例模式
    private $allowServerType = ['aliyunoss', 'qiniuyun', 'web_server', 'yunzhuanma'];
    private $allowFileType=['video','image','ico'];


    /**
     * 创建Uploader对象
     * @return null|uploader
     */
    public static function instance()
    {
        if (!self::$_intance instanceof self) {
            self::$_intance = new self();
        }
        return self::$_intance;
    }

    /**
     * 构造函数
     * uploader constructor.
     * @throws Exception
     */
    private function __construct()
    {
        $sessionUser = session('admin_user');
        if (!$sessionUser) throw new Exception('请登陆后再使用上传功能！');

        //create database connection
        $dbconf = Db::name('admin_user')->field('db_config')->where('id', '=', $sessionUser['uid'])->find();
        $dbconf = \json_decode($dbconf['db_config'], true);
        if ($dbconf) {
            //get upload config
            $dbconf = [
                'type' => $dbconf['type'],
                'username' => $dbconf["username"],
                'password' => $dbconf["password"],
                'hostname' => $dbconf["hostname"],
                'hostport' => $dbconf["hostport"] ? $dbconf["hostport"] : '3306',
                'database' => $dbconf["database"],
                'charset' => $dbconf["charset"] ? $dbconf["charset"] : 'utf-8',
                'prefix' => $dbconf['prefix'] ? $dbconf['prefix'] : 'ms_'
            ];

            if (x_db_config($dbconf)) {
                $this->clientDb = Db::connect($dbconf);
                $this->dbConfig = $dbconf;
            } else {
                $this->clientDb = null;
                throw new Exception('无法连接数据库！');
            }

        } else {
            throw new Exception('请配置好您的数据库连接信息后再试！');
        }
    }

    /**
     * 获取上传配置信息,包括图片,视频两种配置信息
     * @return array 返回对应上传方式的配置信息
     */
    public function getUploadConfig()
    {
        $_config = $this->clientDb->name('admin_config')->where(array('group' => 'attachment'))->field(array('name', 'value'))->select();
        if (!$_config) return false;

        $config = [];
        foreach ($_config as $item) {
            $config[$item['name']] = $item['value'];
        }

        $curImgServerType = $config['image_save_server_type'];
        $curVodServerType = $config['video_save_server_type'];

        $imgConf = ['image_save_server_type' => $curImgServerType];
        $imgConf['config'] = $this->filterConfig($curImgServerType, $config);

        $videoConf = ['video_save_server_type' => $curVodServerType];
        $videoConf['config'] = $this->filterConfig($curVodServerType, $config);

        $icoConf=['ico_save_server_type'=>'web_server','config'=>['web_server_url'=>$config['web_server_url']]];

        $returnData = [
            'image' => $imgConf,
            'video' => $videoConf,
            'ico'   => $icoConf
        ];

        return $returnData;
    }


    /**
     * 根据上传服务器类型过滤掉其他参数
     * @param $serverType
     * @param $config
     * @return array
     */
    private function filterConfig($serverType, $config)
    {
        if (!is_array($config)) return false;
        if (!in_array($serverType, $this->allowServerType)) throw new Exception('存储方式不正确，可供使用的存储方式有: ' . implode(',', $this->allowServerType));

        $currentConfig = [];

        try {
            switch ($serverType) {
                case 'web_server':
                    $currentConfig['web_server_url'] = $config['web_server_url'];
                    break;
                case 'yunzhuanma':
                    $currentConfig['yzm_upload_url'] = $config['yzm_upload_url'];
                    $currentConfig['yzm_play_secretkey'] = $config['yzm_play_secretkey'];
                    break;
                case 'qiniuyun':
                    $currentConfig['qiniu_accesskey'] = $config['qiniu_accesskey'];
                    $currentConfig['qiniu_secretkey'] = $config['qiniu_secretkey'];
                    $currentConfig['qiniu_bucket'] = $config['qiniu_bucket'];
                    $currentConfig['qiniu_upload_server'] = $config['qiniu_upload_server'];
                    $currentConfig['qiniu_resource_default_domain'] = $config['qiniu_resource_default_domain'];
                    break;
                case 'aliyunoss':
                    $currentConfig['aliyun_accesskey'] = $config['aliyun_accesskey'];
                    $currentConfig['aliyun_secretkey'] = $config['aliyun_secretkey'];
                    $currentConfig['aliyun_bucket'] = $config['aliyun_bucket'];
                    $currentConfig['aliyun_oss_city'] = $config['aliyun_oss_city'];
                    break;
            }
            return $currentConfig;
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }


    /**
     * 此方法已废弃 @dreamer 2017/11/17
     *
     * 获取当前上传方式对应的配置信息
     * @return array 返回对应上传方式的配置信息  false:未查询到配置信息
     */
    private function getUploadConfig_SCRAP($uploadType = '')
    {
        if (empty($uploadType)) $uploadType = $this->uploadType;

        $_config = $this->clientDb->name('admin_config')->where(array('group' => 'attachment'))->field(array('name', 'value'))->select();
        if (!$_config) return false;

        $config = [];
        foreach ($_config as $item) {
            $config[$item['name']] = $item['value'];
        }

        $currentConfig = [];
        switch ($uploadType) {
            case 'web_server':
                $currentConfig['upload_type'] = 'web_server';
                $currentConfig['web_server_url'] = $config['web_server_url'];
                break;
            case 'yunzhuanma':
                $currentConfig['upload_type'] = 'yunzhuanma';
                $currentConfig['yzm_upload_url'] = $config['yzm_upload_url'];
                $currentConfig['yzm_play_secretkey'] = $config['yzm_play_secretkey'];
                break;
            case 'qiniuyun':
                $currentConfig['upload_type'] = 'qiniuyun';
                $currentConfig['qiniu_accesskey'] = $config['qiniu_accesskey'];
                $currentConfig['qiniu_secretkey'] = $config['qiniu_secretkey'];
                $currentConfig['qiniu_bucket'] = $config['qiniu_bucket'];
                break;
            case 'aliyunoss':
                $currentConfig['upload_type'] = 'aliyunoss';
                $currentConfig['aliyun_accesskey'] = $config['aliyun_accesskey'];
                $currentConfig['aliyun_secretkey'] = $config['aliyun_secretkey'];
                $currentConfig['aliyun_bucket'] = $config['aliyun_bucket'];
                break;
            default:
                $currentConfig = $config;
        }

        return $currentConfig;
    }


    /**
     * 设置上传服务器类型
     * @param $serverType   上传服务器类型('aliyunoss','qiniuyun','web_server','yunzhuanma')
     * @return null 返回上传工具类本身（uploader）
     * @throws Exception
     */
    private function setServerType($serverType)
    {
        if (!in_array($serverType, $this->allowServerType)) throw new Exception('存储方式不正确，可供使用的存储方式有: aliyunoss,qiniuyun,web_server,yunzhuanma .');

        $this->uploadType = $serverType;

        return self::instance();
    }


    /**
     * 创建web直传参数列表
     * @param $upServer 上传的目标服务器类型
     * @param $fileType 上传的文件类型
     * @param $fileName 指定上传的文件名称
     * @return array
     */
    public function createWebUploadParams($upServer,$fileType,$fileName='')
    {
        if(!in_array($upServer,$this->allowServerType)) return false;
        if(!in_array($fileType,$this->allowFileType)) return false;

        $_config=$this->getUploadConfig();
        $params = [];
        switch ($upServer) {
            case 'web_server':
                $params['post_url'] = $_config[$fileType]['config']['web_server_url'] . '/Xuploader.php';
                break;
            case 'yunzhuanma':
                $params['post_url'] = $_config[$fileType]['config']['yzm_upload_url'] . "/uploads";
                break;
            case 'qiniuyun':
                //生成相应的参数
                $qiniuPoster=new QiniuPostObject($_config[$fileType]['config']);
                $params=$qiniuPoster->getFormParams();
                break;
            case 'aliyunoss':
                //生成相应的参数
                $ossPoster=new AliyunOssPostObject($_config[$fileType]['config']);
                $params=$ossPoster->getFormParams($fileName);
                break;
        }

        $params['serverType']=$upServer;
        return $params;
    }



}
