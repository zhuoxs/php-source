<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace app\admin\controller;


class cloudClass extends BaseClass {
    private $urlarray = array("ctrl"=>"cloud");

    public function __construct(){ 
        parent::__construct();
        global $_W, $_GPC;
        $GLOBALS['frames'] = $this->getMainMenu();
    }


    /*参数配置*/
    public function cloud(){
        global $_W, $_GPC;
        
		$item=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));

		if($item['cappid']&&$item['cappsecret']){
			$url='https://api.znymall.cn/index.php?s=/api/Openapi/getApiInfo';
            $newdata['apid']=$item['cappid'];
            $newdata['apikey']=$item['cappsecret'];
			$newres = $this->request_post($url,$newdata);
            $return_data=json_decode($newres,true);
			
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


        if(checksubmit('submit')){

            $data['uniacid']=$_W['uniacid'];
			$data['cappid']=$_GPC['cappid'];
			$data['cappsecret']=$_GPC['cappsecret'];
            
            if($_GPC['id']==''){
                $res=pdo_insert('mzhk_sun_system',$data,array('uniacid'=>$_W['uniacid']));
                if($res){
                    message('添加成功',$this->createWebUrl('cloud'),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_system', $data, array('uniacid'=>$_W['uniacid'], 'id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('cloud'),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

        include $this->template('web/cloud/cloud');
    }

	/*挚能云商品*/
	public function cloudgoods(){
        global $_W, $_GPC;

		include $this->template('web/cloud/cloudgoods');
    }

	/*接口*/
	public function request_post($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $tmpInfo = curl_exec($ch);
        $error = curl_errno($ch);
        curl_close($ch);
        if ($error) {
            return false;
        }else{
            return $tmpInfo;
        } 
    }

	

}