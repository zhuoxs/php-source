<?php
set_time_limit(0);
ob_end_clean();
 global $_W, $_GPC;
        $page=$_GPC['page'];
        $cfg = $this->module['config'];
        $dtkAppKey=$cfg['dtkAppKey'];
        //echo '<pre>';
        //print_r($dtklist);
        //exit; 
        

        $op=$_GPC['op'];
        if($op=='dtkcj'){

            $url = "http://api.dataoke.com/index.php?r=goodsLink/www&type=www_quan&appkey={$dtkAppKey}&v=2&page={$page}";
            $content=$this->curl_request($url);     
            $userInfo = @json_decode($content, true);
           // $dtklist=$userInfo['data']['result'];
            if($userInfo['data']['total_num']==0){
               message ( '本页暂无商品可同步', $this->createWebUrl ( 'dtkcaiji' ),'error');
            }
            
            $this->indtkgoods($userInfo['result']); 
          //usleep(500000);
          message ( '采集成功，查看商品', $this->createWebUrl ( 'tbgoods' ) );
        
        }elseif($op=='qcljcp'){//全站领卷采集
            if(empty($page)){
              $page=1;
            }
            $url="http://api.dataoke.com/index.php?r=Port/index&type=total&appkey={$dtkAppKey}&v=2&page=1";
            $content=$this->curl_request($url);     
            $userInfo = @json_decode($content, true);
            $pagesum=ceil($userInfo['data']['total_num']/50);  //总页数
//             echo '<pre>';
//            print_r($userInfo);
//            exit;
            if($page<=$pagesum){
                $url="http://api.dataoke.com/index.php?r=Port/index&type=total&appkey={$dtkAppKey}&v=2&page={$page}";
                load()->func('communication');
                $json = ihttp_get($url);  
                $userInfo = @json_decode($json['content'], true);
                //echo '<pre>';
                //print_r($userInfo);
                //exit;
                $this->indtkgoods($userInfo['result']);
                //usleep(500000);

                if ($page < $pagesum) {
					message('温馨提示：请不要关闭页面，采集任务正在进行中！（' . $page . '/' . $pagesum . '）', $this->createWebUrl('dtkcaiji', array('op' => 'qcljcp','page' => $page + 1)), 'error');
                } elseif ($page == $pagesum) {
                    //step6.最后一页 | 修改任务状态
                   message('温馨提示：采集任务已完成！（' . $page . '/' . $total . '）', $this->createWebUrl('dtkcaiji'), 'success');
                } else {
                    //已结束
                    //pdo_update('healer_tplmsg_bulk', array('status' => 2), array('uniacid' => $_W['uniacid'], 'id' => $bulk['id']));
                    message('温馨提示：该采集任务已完成！', $this->createWebUrl('dtkcaiji'), 'error');
                }
                          
            }
        }elseif($op=='sspl'){//时时跑量
            $url="http://api.dataoke.com/index.php?r=Port/index&type=paoliang&appkey={$dtkAppKey}&v=2";
            $content=$this->curl_request($url);     
            $userInfo = @json_decode($content, true);
            //usleep(500000);
            //echo '<pre>';
            //print_r($userInfo);
            //exit;
            $this->indtkgoods($userInfo['result']); 
            message ( '采集成功，查看商品', $this->createWebUrl ( 'tbgoods' ) );
        }elseif($op=='top100'){//top100
            $url="http://api.dataoke.com/index.php?r=Port/index&type=top100&appkey={$dtkAppKey}&v=2";
            load()->func('communication');
            $json = ihttp_get($url);        
            $userInfo = @json_decode($json['content'], true);
            //echo '<pre>';
            //print_r($userInfo);
            //exit;
            $this->indtkgoods($userInfo['result']); 
            //usleep(500000);
            message ( '采集成功，查看商品', $this->createWebUrl ( 'tbgoods' ) );
        }
        include $this->template ( 'dtkcaiji' );       