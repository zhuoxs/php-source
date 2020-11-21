<?php
namespace app\api\controller;

use app\base\controller\Api;
use app\model\Leader;
use app\model\Leaderuser;
use app\model\Order;
use app\model\Store;
use app\model\User;
use app\model\Usercode;
use app\model\Usercoupon;
use app\model\Config;
use app\model\Distribution;

class Cuser extends Api
{
    public function login(){
        $openid = input('request.openid');
        $info = User::get(['openid'=>$openid])?:new User();

        $data = input('request.');
        $data['login_time'] = time();

        $share_user_id = input('request.share_user_id',0);
        unset($data['share_user_id']);

        if (!isset($info->id)){
            $info->id = 0;
        }

//        本人不是分销商 and 有分享人 and 分享人是分销商
        if (!User::isDistribution($info->id) && $share_user_id && User::isDistribution($share_user_id)){
            $data['last_share_user_id'] = $share_user_id;

            //        第一次进入
            if(!isset($info->id) || !$info->id){
                $data['first_share_user_id'] = $share_user_id;

//                判断成为分销商的条件 ： 0首次进入
                if (!Config::get_value('distribution_relation',0)){
                    $data['share_user_id'] = $share_user_id;
                }
            }
        }

        $ret = $info->allowField(true)->save($data);

        if ($ret){
            success_withimg_json($info);
        }else{
            error_json('登录失败');
        }
    }
//    获取用户随机码
//        传入：
//            user_id
    public function getUserCode(){
        $user_id = input('request.user_id');
        $usercode = Usercode::get(['user_id'=>$user_id])?:new Usercode();

        $ret = true;

        if (!isset($usercode['id']) || !$usercode['id'] || $usercode['end_time']<= time()){
            $code = md5(uniqid());
            $usercode->code = $code;
            $usercode->user_id = $user_id;
            $usercode->end_time = time()+12*60*60;
            $ret = $usercode->save();
        }

        if ($ret){
            success_json($usercode['code']);
        }else{
            error_json('生成失败');
        }
    }
    /**
     * 我的个人信息
    */
    public function myInfo(){
        $user_id=input('request.user_id',0);

        if($user_id<= 0){
            error_json('user_id不能为空');
        }

        $info['userinfo'] = User::get($user_id);

        $info['couponCount'] = Usercoupon::where('user_id',$user_id)
            ->where('state',1)
            ->where('end_time > '.time())
            ->count();

        $info['store_switch'] = Config::get_value('mstore_switch',0);

        $info['is_leader'] = !!Leader::get(['user_id'=>$user_id,'check_state'=>2]);
        $info['is_leaderuser'] = !!Leaderuser::get(['user_id'=>$user_id]);
        $info['has_store'] = !!Store::get(['user_id'=>$user_id,'check_state'=>2]);

        $info['order_count']=[
            'state1' => Order::where('user_id',$user_id)
                ->where('state',1)
                ->count(),
            'state2' => Order::where('user_id',$user_id)
                ->where('state',2)
                ->count(),
            'state3' => Order::where('user_id',$user_id)
                ->where('state',3)
                ->count(),
            'state4' => Order::where('user_id',$user_id)
                ->where('state',4)
                ->count(),
            'state5' => Order::where('user_id',$user_id)
                ->where('state',5)
                ->where('is_delete',0)
                ->count(),
        ];


        $info['is_distribution'] = false;
        $info['distributioninfo'] = [];
        if (pdo_tableexists('sqtg_sun_distribution')) {
            $info['distributioninfo'] = Distribution::get(['user_id'=>$user_id]);
            $info['is_distribution'] = !!Distribution::get(['user_id'=>$user_id,'check_state'=>2]);
        }

        $info['distribution_switch'] = !!Config::get_value('distribution_level',0);

        success_withimg_json($info);
    }
    public function GetwxCode(){
        global $_W;
        $access_token = getAccessToken();
        $scene = input("request.scene");
        if (!preg_match('/[0-9a-zA-Z\!\#\$\&\'\(\)\*\+\,\/\:\;\=\?\@\-\.\_\~]{1,32}/', $scene)) {
            return $this->result(1, '场景值不合法', array());
        }
        $page = input("request.page");

        $width = input("request.width",430);
        $auto_color = input("request.auto_color",false);
        $line_color =input("request.line_color",array('r' => 0,'g' => 0,'b' => 0));
        $is_hyaline =input("request.is_hyaline",true);
        $uniacid = $_W["uniacid"];

        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token;
        $data = array();
        $data["scene"] = $scene;
        $data["page"] = $page;
        $data["width"] = $width;
        $data["auto_color"] = $auto_color;
        $data["line_color"] = $line_color;
        $data["is_hyaline"] = $is_hyaline;
        $json_data = json_encode($data);
        $return = $this->request_post($url,$json_data);

        //将生成的小程序码存入相应文件夹下
        $imgname = time().rand(10000,99999).'.jpg';
        file_put_contents(IA_ROOT."/attachment/".$imgname,$return);
        echo json_encode($imgname);
    }

    public function DelwxCode(){
        global $_W;
        $imgurl = input("request.imgurl");
        $filename = IA_ROOT.'/attachment/'.$imgurl;
        if(file_exists($filename)){
            $info ='删除成功';
            unlink($filename);
        }else{
            $info ='没找到:'.$filename;
        }
        echo $info;
    }

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
