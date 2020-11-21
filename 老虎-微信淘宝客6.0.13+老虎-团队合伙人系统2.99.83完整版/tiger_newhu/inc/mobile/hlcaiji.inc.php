<?php
global $_W, $_GPC;
        $page=$_GPC['page'];
        $cfg = $this->module['config'];
        if(empty($cfg['hlAppKey'])){
        	//message('请填写好单库APIKEY', $this->createWebUrl('hlcaijiset'), 'error');
        	echo '请填写好单库APIKEY';
        }
        if(empty($page)){
          //$page=1;
        }
        if(!empty($cfg['gyspsj'])){
          exit;
        }
        $op=$_GPC['op'];
        if($op=='qcljcp'){
            //$url = "http://www.haodanku.com/?json=true&p={$page}";
            $url="http://v2.api.haodanku.com/itemlist/apikey/asdfasdfggdfg/nav/3/cid/0/back/100/min_id/".$page;
            $content=$this->curl_request($url);     
            $userInfo = @json_decode($content, true);
            $page=$userInfo['min_id'];
            print_r($userInfo);
            
            $pagesum=300;
            if(!empty($userInfo['data'])){
               $this->hlinorder($userInfo['data'],$_W);
                if ($userInfo['data']) {
                    $sum=$page + 1;
					//message('温馨提示：请不要关'.$sum.'闭页面，采集任务正在进行中！（采集第' . $page . '页）', $this->createMobileUrl('hlcaiji', array('op' => 'qcljcp','page' =>$sum)), 'error');
					message('温馨提示：请不要关闭页面，采集任务正在进行中！（采集码：' . $page . '）', $this->createMobileUrl('hlcaiji', array('op' => 'qcljcp','type'=>$type,'page' =>$page)), 'error');
                }else {
                   echo '温馨提示：该采集任务已完成！';
                }       
            }else{
              echo '温馨提示：该采集任务已完成！';
            }
        }elseif($op=='hlsxcj'){
            $nav=$_GPC['nav'];
            $cid=$_GPC['cid'];
            $sort=$_GPC['sort'];
            $itemendprice_min=$_GPC['itemendprice_min'];
            $itemendprice_max=$_GPC['itemendprice_max'];
            $itemsale_min=$_GPC['itemsale_min'];
            $itemsale_max=$_GPC['itemsale_max'];
            $tkmoney_min=$_GPC['tkmoney_min'];
            $tkmoney_max=$_GPC['tkmoney_max'];
            $starttime=$_GPC['starttime'];
            $tianmao=$_GPC['tianmao'];
            $new_today=$_GPC['new_today'];
            $nine=$_GPC['nine'];
            if(empty($nine)){
              $nine=0;
              $thirty=0;
            }elseif($nine==1){
              $nine=1;
              $thirty=0;
            }elseif($nine==2){
              $nine=0;
              $thirty=1;
            }

            $url = "http://www.haodanku.com/?json=true&p={$page}&nav={$nav}&cid={$cid}&sort={$sort}&itemendprice_min={$itemendprice_min}&itemendprice_max={$itemendprice_max}&itemsale_min={$itemsale_min}&itemsale_max={$itemsale_max}&tkmoney_min={$tkmoney_min}&tkmoney_max={$tkmoney_max}&starttime={$starttime}&tianmao={$tianmao}&new_today={$new_today}&nine={$nine}&thirty={$thirty}";
            $content=$this->curl_request($url);     
            $userInfo = @json_decode($content, true);  
            //echo "<pre>";
            //print_r($userInfo);
            //exit;
            $pagesum=300;
            if(!empty($userInfo)){
               $this->hlinorder($userInfo,$_W);
                if ($page < $pagesum) {
					message('温馨提示：请不要关闭页面，采集任务正在进行中！（采集第' . $page . '页）', $this->createMobileUrl('hlcaiji', array('op' => 'hlsxcj','nav'=>$nav,'cid'=>$cid,'sort'=>$sort,'itemendprice_min'=>$itemendprice_min,'itemendprice_max'=>$itemendprice_max,'itemsale_min'=>$itemsale_min,'itemsale_max'=>$itemsale_max,'tkmoney_min'=>$tkmoney_min,'tkmoney_max'=>$tkmoney_max,'starttime'=>$starttime,'tianmao'=>$tianmao,'new_today'=>$new_today,'nine'=>$nine,'thirty'=>$thirty,'page' => $page + 1)), 'error');
                } elseif ($page == $pagesum) {
                    //step6.最后一页 | 修改任务状态
                    message('温馨提示：采集任务已完成！（采集第' . $page . '页）', $this->createMobileUrl('hlcaiji'), 'success');
                } else {
                    echo '温馨提示：该采集任务已完成';
                }       
            }else{
                echo '温馨提示：该采集任务已完成';
            }
           
        }