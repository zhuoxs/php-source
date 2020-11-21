<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $miyao=$_GPC['miyao'];
        if($miyao!==$cfg['miyao']){
						exit(json_encode(array('status' => 2, 'content' => '密钥错误，请检测秘钥，或更新缓存！')));
        }
				
				$content=htmlspecialchars_decode($_GPC['content']);
				file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/dtk--ordernews.txt","\n:".$_GPC['content'],FILE_APPEND);
				$userInfo = @json_decode($content, true);
				//$dtklist=$userInfo['result'];
				$this->indtkgoods($userInfo['result']);
        echo "大淘客 第".$_GPC['page']."页采集【入库】成功";