<?php
// +----------------------------------------------------------------------
// | JuhePHP [ NO ZUO NO DIE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2015 http://juhe.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Juhedata <info@juhe.cn-->
// +----------------------------------------------------------------------
 
//----------------------------------
// 聚合数据全国违章接口调用类
//----------------------------------
class Weliam_Juhewz{
    public $appkey = false; //申请的全国违章查询APPKEY
 
    private $cityUrl = 'http://v.juhe.cn/wz/citys';
 
    private $wzUrl = 'http://v.juhe.cn/wz/query';
 
    public function __construct($appkey){
        $this->appkey = $appkey;
    }
 
    /**
     * 获取违章支持的城市列表
     * @return array
     */
    public function getCitys($province=false){
        $params = 'key='.$this->appkey."&format=2";
        $content = $this->juhecurl($this->cityUrl,$params);
        return $this->_returnArray($content);
    }
 
    /**
     * 查询车辆违章
     * @param  string $city     [城市代码]
     * @param  string $carno    [车牌号]
     * @param  string $engineno [发动机号]
     * @param  string $classno  [车架号]
     * @return  array 返回违章信息
     */
    public function query($city,$carno,$engineno='',$classno=''){
        $params = array(
            'key' => $this->appkey,
            'city'  => $city,
            'hphm' => $carno,
            'engineno'=> $engineno,
            'classno'   => $classno
        );
        $content = $this->juhecurl($this->wzUrl,$params,1);
        return $this->_returnArray($content);
    }
 
    /**
     * 将JSON内容转为数据，并返回
     * @param string $content [内容]
     * @return array
     */
    public function _returnArray($content){
        return json_decode($content,true);
    }
 
    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    public function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
 
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }
}