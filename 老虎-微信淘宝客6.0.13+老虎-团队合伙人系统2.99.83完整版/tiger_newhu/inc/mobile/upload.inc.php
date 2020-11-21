<?php
global $_W,$_GPC;
		load()->classs('weixin.account');
        $accObj= WeixinAccount::create($_W['uniacid']);
        $access_token = $accObj->fetch_token();

		$media_id = $_GET['media_id'];

        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;

        $newfolder= ATTACHMENT_ROOT . 'images' . '/tiger_newhu_photos'."/";//文件夹名称
        if (!is_dir($newfolder)) {
            mkdir($newfolder, 7777);
        } 
        $picurl = 'images'.'/tiger_newhu_photos'."/".date('YmdHis').rand(1000,9999).'.jpg';
        $targetName = ATTACHMENT_ROOT.$picurl;
        $ch = curl_init($url); // 初始化
        $fp = fopen($targetName, 'wb'); // 打开写入
        curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);       
        echo $picurl;