<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $miyao=$_GPC['miyao'];
	$content=$_GPC['content'];
	
        if($miyao!==$cfg['miyao']){
		exit(json_encode(array('status' => 2, 'content' => '密钥错误，请检测秘钥，或更新缓存！')));
        }
				
	//$content=htmlspecialchars_decode($_GPC['content']);
	$content=str_replace("&quot;",'"',$content); 
	//file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/hdb--ordernews.txt","\n:".$content,FILE_APPEND);
	$userInfo = @json_decode($content, true);
	//file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/hdb--ordernews.txt","\n----".$userInfo,FILE_APPEND);
	//$dtklist=$userInfo['result'];
	$this->hlinorder($userInfo['data'],$_W);
        echo "好单库 加密页码".$_GPC['page']."采集【入库】成功";