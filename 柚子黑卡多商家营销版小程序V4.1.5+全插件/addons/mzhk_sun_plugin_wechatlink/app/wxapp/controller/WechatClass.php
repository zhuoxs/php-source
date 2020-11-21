<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace app\wxapp\controller;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\MiniProgramPage;
use EasyWeChat\Message\Text;
use EasyWeChat\Message\Raw;
use EasyWeChat\Support\Log;


class WechatClass extends BaseClass {
    private $urlarray = array("ctrl"=>"Wechat");
    private $option = array();
    private $wechat;
    private $wxapp_appid = 'wxbef11094c8354d39';
    private $wxapp_url = 'mzhk_sun/pages/index/index';//小程序首页地址
    private $MiniProgramName = "黑卡";
    private $backcontent = "";
    private $goods_url = array(
        1=>"mzhk_sun/pages/index/goods/goods",
        2=>"mzhk_sun/pages/index/bardet/bardet",
        3=>"mzhk_sun/pages/index/groupdet/groupdet",
        4=>"mzhk_sun/pages/index/cardsdet/cardsdet",
        5=>"mzhk_sun/pages/index/package/package",
        6=>"mzhk_sun/pages/index/freedet/freedet",
        12=>"mzhk_sun/plugin2/secondary/detail/detail",
        50=>"mzhk_sun/pages/index/shop/shop",//商家
    );

    public function __construct(){
        parent::__construct();
        global $_GPC, $_W;
        $wechat_set = pdo_get('mzhk_sun_wechat_set', array('uniacid' => $_W['uniacid']));

        if($wechat_set){
            $this->option = array(
                'debug'  => false,
                'app_id' => $wechat_set['wechat_appid'],
                'secret' => $wechat_set['wechat_appsecret'],
                'token'  => $wechat_set['wechat_token'],
                'aes_key' => $wechat_set['wechat_aeskey'],
                'log' => [
                    'level'      => 'debug',
                    'permission' => 0777,
                    'file'       => IA_ROOT.'/addons/'.$_W['current_module']['name'].'/log/easywechat.log',
                ],
            );
            $this->backcontent = $wechat_set['backcontent'];
        }else{
            echo "error";
            exit;
        }
        $this->wechat = new Application($this->option);
        //获取小程序appid和系统配置
        $wechat_set = pdo_get('mzhk_sun_system', array('uniacid' => $_W['uniacid']));
        $this->wxapp_appid = $wechat_set["appid"];
        if($wechat_set["pt_name"]){
            $this->MiniProgramName = $wechat_set["pt_name"];
        }
    }

    public function wechatLink(){
        $wechat = $this->wechat;
        $server = $this->wechat->server;

        $response = $server->serve();
        $response->send();

        $message = $server->getMessage();

        if (isset($message['MsgType']) && $message['MsgType'] == 'event') {
            $return_type = 1;//1为回复客服消息类型
            switch ($message['Event']) {
                case 'subscribe'://
                    //扫码关注会发送小程序卡片，不是扫码关注不发送
                    if(!empty($message['EventKey'])){
                        $data = array();
                        $data['message'] = $message;
    //                    Log::debug('======== message:', $message);
                        //发送小程序卡片
                        $this->sendMiniProgram($data);
                    }
                    //关注的时候另外发送一个消息
                    if(empty($this->backcontent)){
                        $this->backcontent = "①搜索商品或活动名称可以查看相关商品或活动 \n\n ②搜索商家名称可以查看相关商家信息和优惠 \n ";
                    }
                    $send_message = new Raw('{
                        "touser":"'.$message["FromUserName"].'",
                        "msgtype":"text",
                        "text":
                        {
                             "content":"'.$this->backcontent.' \n <a data-miniprogram-appid=\"'.$this->wxapp_appid.'\" data-miniprogram-path=\"'.$this->wxapp_url.'\">直接进入'.$this->MiniProgramName.'小程序查看更多好玩、好吃、好用的</a>"
                        }
                    }');
                    $wechat->staff->message($send_message)->to($message['FromUserName'])->send();
                    break;
                case 'SCAN'://扫码事件
                    $data = array();
                    $data['message'] = $message;
//                    Log::debug('======== message:', $message);
                    //发送小程序卡片
                    $this->sendMiniProgram($data);
                    break;
                case 'CLICK'://自定义菜单事件

                    break;
                default:
                    $send_message_array = "你好，欢迎，谢谢";
                    break;
            }
        }else{
            $data = array();
            if($message['MsgType']=='text'){
                $data['search'] = $message['Content'];
            }
            $data['message'] = $message;
            //发送小程序卡片
            $this->sendMiniProgram($data);
            exit;
        }
        //$server->send();


    }

    /*
     * 发送消息
     * */
    /**
     * @param array $data
     */
    public function sendMiniProgram($data=array()){
        global $_GPC, $_W;
        //客服发送消息
        $wechat = $this->wechat;
        // 临时素材
        $temporary = $wechat->material_temporary;

        $title = $this->MiniProgramName;
        $thumb_media_id = '';//小程序卡片媒体id
        $tabletype = 0;//来源，默认0，0不使用公众号助手提供的二维码  1商品表，2商家表，3次卡表
        $id = isset($data['gid'])?intval($data['gid']):0;
        //判断是否扫码海报二维码
        if(!empty($data['message']['EventKey'])){
            $qrscene = str_replace("qrscene_","",$data['message']['EventKey']);
            if(!empty($qrscene)){
                $qrscene_arr = explode("&",$qrscene);
                $scene = array();
                foreach($qrscene_arr as $k => $v){
                    $str = explode("=", $v);
                    if($str[0]=="tty"){//tabletype
                        $tabletype = intval($str[1]);
                    }else{
                        $scene[$k] = $v;
                    }
                    //获取id值
                    if($str[0]=="gid" || $str[0]=="id"){
                        $id = intval($str[1]);
                    }
                }
                $scene = implode("&", $scene);
            }
        }

        if(isset($id) && $id>0){
            if($tabletype==1){
                $goods = pdo_get('mzhk_sun_goods', array('uniacid' => $_W['uniacid'],'gid' => $id));
            }elseif($tabletype==2){//商家
                $brand = pdo_get('mzhk_sun_brand', array('uniacid' => $_W['uniacid'],'bid' => $id));
                if($brand){
                    $goods = array(
                        'media_id'=>isset($brand['media_id'])?$brand['media_id']:"",
                        'media_id_time'=>isset($brand['media_id_time'])?$brand['media_id_time']:0,
                        'wechat_media_img'=>isset($brand['wechat_media_img'])?$brand['wechat_media_img']:"",
                        'pic'=>$brand['img'],
                        'gname'=>$brand['bname'],
                        'lid'=>50,
                    );
                }
            }elseif($tabletype==3){//次卡
                $goods = pdo_get('mzhk_sun_subcard_goods', array('uniacid' => $_W['uniacid'],'id' => $id));
            }
        }elseif(isset($data['search']) && !empty($data['search'])){
            $nowtime = date('Y-m-d H:i:s',time());
            $sql = "select * from ".tablename('mzhk_sun_goods')." where uniacid=".$_W['uniacid']." and gname like'%".$data['search']. "%' and (lid=1 or (lid=2 and is_kjopen=1) or (lid=3 and is_ptopen=1) or (lid=4 and is_jkopen=1) or (lid=5 and is_qgopen=1) or (lid=6 and is_hyopen=1)) and isshelf=1 and num>0 and antime>='" .$nowtime."' order by sort asc,gid DESC";
            $goods = pdo_fetch($sql);
            if($goods){
                $lid_arr = array(1=>"gid",2=>"id",3=>"id",4=>"gid",5=>"id",6=>"id");
                $scene = $lid_arr[$goods["lid"]]."=".$goods['gid'];
                $tabletype = 1;
            }elseif(pdo_tableexists("mzhk_sun_subcard_goods")){
                $sql = "select * from ".tablename('mzhk_sun_subcard_goods')." where uniacid=".$_W['uniacid']." and gname like'%".$data['search']."%' and status=1 and num>0 and antime>='".time()."' order by sort asc,id DESC";
                $goods = pdo_fetch($sql);
                $scene = "id = ".$goods['id'];
                $tabletype = 3;
            }
            if(!$goods){//没有商品就找商家
                $sql = "select * from ".tablename('mzhk_sun_brand')." where uniacid=".$_W['uniacid']." and bname like'%".$data['search']."%' and status=2 and brand_open=0 order by istop desc,sort asc,bid DESC";
                $brand = pdo_fetch($sql);
                if($brand){
                    $goods = array(
                        'media_id'=>isset($brand['media_id'])?$brand['media_id']:"",
                        'media_id_time'=>isset($brand['media_id_time'])?$brand['media_id_time']:0,
                        'wechat_media_img'=>isset($brand['wechat_media_img'])?$brand['wechat_media_img']:"",
                        'pic'=>$brand['img'],
                        'gname'=>$brand['bname'],
                        'lid'=>50,
                        'bid'=>$brand['bid'],
                    );
                    $scene = "id = ".$brand['bid'];
                    $tabletype = 2;
                }
            }
        }

        if($goods){
            $thumb_media_id = $this->getThumbMediaId($goods,$tabletype);
            $title = $goods["gname"];
            $this->wxapp_url = $this->goods_url[$goods['lid']]."?".$scene;
        }

        //用来判断是否已经发送过卡片了，关注的话发送卡片就在发送欢迎关注的话
        if(!empty($thumb_media_id)){//有图就发送卡片
            $send_message = new MiniProgramPage(
                array(
                    'title' => $title,
                    'appid' => $this->wxapp_appid,
                    'pagepath' => $this->wxapp_url,
                    'thumb_media_id' => $thumb_media_id
                )
            );
        }else{
//	    	$send_message = new Text(
//	    		array(
//	    			'content' => '①搜索商品或活动名称可以查看相关商品或活动哦 /\r/\n ②搜索商家名称可以查看相关商家哦 \r\n ③<a href="http://www.qq.com" data-miniprogram-appid="'.$this->wxapp_appid.'" data-miniprogram-path="'.$this->wxapp_url.'">直接进入'.$title.'小程序查看更多好玩、好吃、好用的</a>'
//	    		)
//	    	);
            $send_message = new Raw('{
                "touser":"'.$data["message"]["FromUserName"].'",
                "msgtype":"text",
                "text":
                {
                     "content":" ①搜索商品或活动名称可以查看相关商品或活动 \n\n ②搜索商家名称可以查看相关商家信息和优惠 \n\n ③<a href=\"http://www.qq.com\" data-miniprogram-appid=\"'.$this->wxapp_appid.'\" data-miniprogram-path=\"'.$this->wxapp_url.'\">直接进入'.$title.'小程序查看更多好玩、好吃、好用的</a>"
                }
            }');

        }
        $wechat->staff->message($send_message)->to($data['message']['FromUserName'])->send();
    }

    public function getThumbMediaId($goods,$tabletype=0){
        global $_GPC, $_W;
        // 临时素材
        $temporary = $this->wechat->material_temporary;
        $is_interim = false;//临时图片需要删除
        $thumb_media_id = "";
        if(isset($goods["media_id"]) && !empty($goods["media_id"]) && $goods["media_id_time"]>(time()-60*2)){//media_id 有效
            $thumb_media_id = $goods["media_id"];
        }else{
            if(isset($goods['wechat_media_img']) && !empty($goods['wechat_media_img'])){//有上传小程序需要的卡片图
                $wechat_media_img = $goods['wechat_media_img'];
            }else{//使用列表图
                $wechat_media_img = $goods['pic'];
            }
            if(!empty($wechat_media_img)){
                if(file_exists(IA_ROOT.'/attachment/'.$wechat_media_img)){//本地图片
                    $images_dir = IA_ROOT.'/attachment/'.$wechat_media_img;
                }else{//远程图片
                    $images_dir = $this->downloadImage($_W["attachurl"].$wechat_media_img,IA_ROOT.'/addons/'.$_W['current_module']['name'].'/mediaimg/');
                    $images_dir = IA_ROOT.'/addons/'.$_W['current_module']['name'].'/mediaimg/'.$images_dir;
                    $is_interim = true;
                }
                if($images_dir){
                    $temporary_res = $temporary->uploadImage($images_dir);
                    if(isset($temporary_res['media_id']) && !empty($temporary_res['media_id'])){
                        $thumb_media_id = $temporary_res['media_id'];
                        //下载的远程图要删除
                        if($is_interim && file_exists($images_dir)){
                            unlink($images_dir);
                        }
                        if($tabletype==1) {
                            //更新商品中的媒体id等信息
                            $result = pdo_update('mzhk_sun_goods', array('media_id' => $thumb_media_id, 'media_id_time' => time()), array('gid' => $goods["gid"]));
                        }
                    }
                }
            }
        }
        return $thumb_media_id;
    }

    //生成二维码
    public function wechatQrcode(){
        global $_GPC, $_W;
        $tabletype = intval($_GPC["tabletype"]);
        $scene = $_GPC["scene"];
        $scene = empty($scene)?"tty=".$tabletype:$scene."&"."tty=".$tabletype;
        $qrcode = $this->wechat->qrcode;
        $result = $qrcode->temporary($scene, 20 * 24 * 3600);
        // $url = $result->url; // 二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片
        $ticket = $result->ticket;
        $url = $qrcode->url($ticket);
        $content = file_get_contents($url); // 得到二进制图片内容
        $wechat_img = time().rand(10000,99999).'.jpg';
        file_put_contents("../attachment/".$wechat_img, $content); // 写入文件

        echo $wechat_img;
    }

}