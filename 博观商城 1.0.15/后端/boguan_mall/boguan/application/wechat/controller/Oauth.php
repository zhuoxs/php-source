<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2019-4-1
 * Time: 15:44
 */
namespace app\wechat\controller;

use think\Log;
use app\boguan\model\PublicSettings;
use app\boguan\model\BaseModel;
use app\boguan\model\PublicUser;

class Oauth extends Base
{
    public function index(){

        $code= input('code');
        $uniacid= input('uniacid');
        $publicSettings= PublicSettings::where('uniacid',$uniacid)->find();
        $request_url = config("settings.oauth_access_token_url");
        $url = sprintf($request_url, $publicSettings['appid'], $publicSettings['app_secret'],$code);

        $result= json_decode(curl_post($url),true);
        if (isset($result['openid']) || $result['openid'] != ''){
            $user_info_url= config("settings.public_user_info_url");
            $post_url= sprintf($user_info_url, $result['access_token'], $result['openid']);
            $res= json_decode(curl_post($post_url),true);
            if (!array_key_exists('errcode',$res)){
                $have_user= PublicUser::where(['uniacid'=> $uniacid,'openid'=> $res['openid']])->find();
                $user_data= [
                    'uniacid'=> $uniacid,
                    'openid'=> $res['openid'],
                    'nickname'=> $res['nickname'],
                    'avatar'=> $res['headimgurl'],
                ];
                if (empty($have_user)){
                    //新增
                    $status= PublicUser::create($user_data);
                }else{
                    $user_data['id']= $have_user['id'];
                    $user_data['update_time']= time();
                    $status= PublicUser::update($user_data);
                }
                if ($status !== false){
                    return $this->redirect('general/index/success',['msg'=> '授权成功，请返回后台刷新']);
                }else{
                    return $this->redirect('general/index/error',['msg'=> '授权失败，请稍候再试']);

                }
            }
        }

    }


}