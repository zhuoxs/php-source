<?php
// +----------------------------------------------------------------------
// | msvodx[TP5内核]
// +----------------------------------------------------------------------
// | Copyright © 2019-QQ97250974
// +----------------------------------------------------------------------
// | 专业二开仿站定制修改,做最专业的视频点播系统
// +----------------------------------------------------------------------
// | Author: cherish ©2018
// +----------------------------------------------------------------------

namespace app\common\util;
use app\common\util\Http;

class Cloud {

    //错误信息
    private $error = '出现未知错误 Cloud ！';
    //需要发送的数据
    private $data = array();
    //接口
    private $api = NULL;
    // 站点标识
    private $identifier = '';
    // 升级锁
    public $lock = '';
    // 升级目录路径
    public $path = './';
    // 请求类型
    public $type = 'post';

    //服务器地址
    const api_url = 'http://cloud.hisiphp.com/thinkphp5/';
    
    /**
     * 架构函数
     * @param string $path  目录路径
     * @author frs whs tcl dreamer ©2016
     */
    public function __construct($identifier = '', $path = './') {
        $this->identifier = $identifier;
        $this->path = $path;
        $this->lock = ROOT_PATH.'upload/cloud.lock';
    }

    /**
     * 获取服务器地址
     * @author frs whs tcl dreamer ©2016
     * @return string
     */
    public function apiUrl() {
        return self::api_url;
    }

    /**
     * 获取错误信息
     * @author frs whs tcl dreamer ©2016
     * @return string
     */
    public function getError() {
        return $this->error;
    }

    /**
     * 需要发送的数据
     * @param  array $data 数据
     * @author frs whs tcl dreamer ©2016
     * @return obj
     */
    public function data($data) {
        $this->data = $data;
        return $this;
    }
    /**
     * [api 请求接口]
     * @param  string $api 接口
     * @author frs whs tcl dreamer ©2016
     * @return array
     */
    public function api($api) {
        $this->api = self::api_url.$api;
        return $this->run($this->data);
    }
    /**
     * [type 请求类型]
     * @param  string $type 请求类型(get,post)
     * @author frs whs tcl dreamer ©2016
     * @return obj
     */
    public function type($type){
        $this->type = $type;
        return $this;
    }

    /**
     * 升级包下载
     * @param  string $api 接口
     * @author frs whs tcl dreamer ©2016
     * @return array
     */
    public function down($api) {
        $this->api = self::api_url.$api;
        $file = time().'.zip';
        $request = $this->run(false);
        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
        $ch = curl_init();
        $fp = fopen($this->path.$file, 'wb');
        curl_setopt($ch, CURLOPT_URL, $request['url']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3600);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOPROGRESS, 0);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_BUFFERSIZE, 64000);
        curl_setopt($ch, CURLOPT_POST, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$request['params']);
        $res = curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        if (curl_errno($ch) || $curl_info['http_code'] != 200) {
            curl_error($ch);
            unlink($this->path.$file);
            return false;
        }else{
            curl_close($ch);
        }
        fclose($fp);
        if (is_file($this->lock)) {
            @unlink($this->lock);
        }
        return $this->path.$file;
    }

    /**
     * [run 执行接口]
     * @return array
     * @author frs whs tcl dreamer ©2016
     */
    private function run($request = true){
        $params['format'] = 'json';
        $params['timestamp'] = time();
        $params['domain'] = $_SERVER['SERVER_NAME'].ROOT_DIR;
        $params['identifier'] = $this->identifier;
        $params = array_merge($params,$this->data);
        $params = array_filter($params);
        if (is_file($this->lock)) {
            @unlink($this->lock);
        }
        file_put_contents($this->lock, $params['timestamp']);
        if($request === false){
            $result = array();
            $result['url'] = ''.$this->api.'';
            $result['params'] = ''.http_build_query($params).'';
            return $result;
        }
        if($this->type == 'get'){
            $result = http::getRequest($this->api, $params);
        }elseif ($this->type == 'post') {
            $result = http::postRequest($this->api, $params);
        }
        return self::_response($result);
    }

    /**
     * 组装数据返回格式
     * @return array
     * @author frs whs tcl dreamer ©2016
     */
    private function _response($result) {
        if (is_file($this->lock)) {
            @unlink($this->lock);
        }
        if(!$result || empty(json_decode($result, 1))) {
            return ['code' => 0, 'msg' => '请求的接口网络异常，请稍后在试！'];
        } else {
            return json_decode($result, 1);
        }
    }
}