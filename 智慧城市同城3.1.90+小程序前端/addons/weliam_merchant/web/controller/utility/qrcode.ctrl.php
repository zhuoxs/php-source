<?php
/**
 * Comment: ...
 * Author: ZZW
 * Date: 2018/11/20
 * Time: 12:06
 */
defined('IN_IA') or exit('Access Denied');

class qrcode_WeliamController{

    public function getQrCode(){
        global $_W,$_GPC;
        $url = urldecode($_GPC['url']);
        if(!$url){
            return false;
        }
        m('qrcode/QRcode')->png($url, false, QR_ECLEVEL_H, 4);
    }

}