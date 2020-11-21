<?php

namespace app\model;

use app\api\controller\Cwx;
use app\base\model\Base;

class System extends Base
{
    static public function get_curr(){
        $info = self::get([]);
        return $info;
    }
    public function getZnyAuth(){
        $info =self::get([]);
        if($info['zny_apid']&&$info['zny_apikey']){
            $url='https://api.znymall.cn/index.php?s=/api/Openapi/getApiInfo';
            $new=new Cwx();
            $data['apid']=$info['zny_apid'];
            $data['apikey']=$info['zny_apikey'];
            $res=$new ->https_request($url,$data);
            $return_data=json_decode($res,true);
            $zny_auth=0;
            if($return_data['code']==0){
                if($return_data['data']['shop_id']>0){
                    $zny_auth=1;
                }
                if($return_data['data']['uid']>0){
                    $zny_auth=2;
                }
            }
        }else{
            $zny_auth=-1;
        }
        return $zny_auth;
    }
}
