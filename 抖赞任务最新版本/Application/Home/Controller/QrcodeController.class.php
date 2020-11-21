<?php
namespace Home\Controller;

use Common\Controller\HomeBaseController;

class QrcodeController extends HomeBaseController
{
    /**
     * 推广二维码生成的物理路径
     * @param $uid
     * @return string
     */
    public function sp_qrcode_physics_path($name) {
        return SITE_PATH."/Upload/qrcode/{$name}.png";
    }

    /**
     * 用户二维码网络路径
     * @param $uid
     * @return string
     */
    public function sp_qrcode_http_path($name) {
        return 'http://'.$_SERVER['HTTP_HOST']."/Upload/qrcode/{$name}.png";
    }

    /**
     * 生成推广二维码
     */
    public function qrcode(){
        $member_id = $this->get_member_id();
        if( !($member_id > 0) ) {
            $this->error('您还未登陆，登陆后会生成您的专属推广二维码');
        }

        $qrcode_name = "share_" . $member_id;
        $url = U('Public/reg',array('smid'=>$member_id),'',true);

        if( file_exists($this->sp_qrcode_physics_path($qrcode_name)) == false ) {
            $this->create_qrcode($url, $this->sp_qrcode_physics_path($qrcode_name));
        }
        $path = $this->sp_qrcode_http_path($qrcode_name);
        $this->success('二维码生成成功', $path);
    }

    /**
     * 生成推广二维码
     */
    public function create_qrcode($url, $save_path){
        $size = 5;
        Vendor('Phpqrcode.phpqrcode');
        \QRcode::png($url,$save_path,QR_ECLEVEL_L,$size,2,false,0xFFFFFF,0x000000);
        //合成文字
        $backgroud = 'tpl/Public/images/agent_bg.png';
        $img = imagecreatefromstring(file_get_contents($backgroud));

        $font = 'tpl/font/msyh.ttf';//字体
        $fontColor = imagecolorallocate($img, 0, 0, 0);//字体颜色 RGB
        $fontColor_2 = imagecolorallocate($img, 251,249,44);//字体颜色 RGB
        $fontSize = 0;   //字体大小
        $circleSize = 0; //旋转角度
        $left = 270;      //左边距  387
        $top = 1240;       //顶边距  807
        //imagefttext($img, $fontSize, $circleSize, $left, $top, $fontColor, $font, "我是\r\n我为{~echo sp_cfg('website')}钱包代言");
        imagefttext($img, $fontSize, $circleSize, $left, $top, $fontColor_2, $font, "推荐码：".$this->get_member_id());

        $qCodeImg = imagecreatefromstring(file_get_contents($save_path));
        list($qCodeWidth, $qCodeHight, $qCodeType) = getimagesize($save_path);
        imagecopymerge($img, $qCodeImg, 170, 1285, 0, 0, $qCodeWidth, $qCodeHight, 100);
        //imagecopymerge($img, $qCodeImg, 220, 170, 0, 0, $qCodeWidth, $qCodeHight, 100);

        /*$headimgurl = imagecreatefromstring(file_get_contents(sp_img($this->get_member_headimg())));
        //新建图片95*95
        $newim = imagecreatetruecolor(95, 95);
        imagecopyresampled($newim, $headimgurl, 0, 0, 0, 0, 95, 95, 364, 364);
        imagecopymerge($img, $newim, 18, 28, 0, 0, 95, 95, 100);*/

        header('Content-Type:image/png');
        imagejpeg($img, $save_path);
        imagedestroy($img);
        imagedestroy($qCodeImg);
        //imagedestroy($headimgurl);
    }
}