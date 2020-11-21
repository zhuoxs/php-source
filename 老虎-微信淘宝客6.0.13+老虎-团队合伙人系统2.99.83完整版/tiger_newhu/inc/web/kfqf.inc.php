<?php
global $_W, $_GPC;
        $page=$_GPC['page'];
        $cfg = $this->module['config'];
        if(empty($page)){
          $page=1;
        }
        $op=$_GPC['op'];
        $weid=$_W['uniacid'];
        if(!empty($cfg['gyspsj'])){
          $weid=$cfg['gyspsj'];
        }
        $goods=pdo_fetchall("SELECT id,itemid,itemtitle,itempic,itemendprice FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$weid}' and qf=1 order by id desc limit 7");
        
        


        //$arr=$this->postgoods($goods,'oEujHwVd9QkK9FZHgyOYlbKM1tT0');
//        $pindex = max(1, intval($_GPC['page']));
//	    $psize = 1000;        
//        $time24=time()-86400;        
//        $list = pdo_fetchall("select from_user from ".tablename("stat_msg_history")." where uniacid='{$_W['uniacid']}' and createtime>{$time24} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
//        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('stat_msg_history')." where uniacid='{$_W['uniacid']}' and createtime>{$time24} order by id desc");
//		$pager = pagination($total, $pindex, $psize);
//
//
//   
//
//        foreach ($list as $k=>$v){
//          $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
//          $temp[$k]=$v;
//         }
//        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组 
//        //print_r($temp);
//        $pagesum=ceil($total/1000);  //总页数


        $pindex = max(1, intval($_GPC['page']));
	    $psize = 100;           
        
        $list = pdo_fetchall("select openid,nickname from ".tablename("mc_mapping_fans")." where uniacid='{$_W['uniacid']}' order by fanid desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('mc_mapping_fans')." where uniacid='{$_W['uniacid']}' order by fanid desc");
        
		$pager = pagination($total, $pindex, $psize);
        $pagesum=ceil($total/100);  //总页数


        if($op=='kfqf'){
            if(!empty($list)){
               foreach ($list as $k => $v){

                   //echo $v['openid']."<br>";


                  $arr=postgoods($_W,$goods,$v['openid']);
                  //$arr=postgoods($_W,$goods,'oEujHwVd9QkK9FZHgyOYlbKM1tT0');
                  //exit;
               }
                if ($page < $pagesum) {
					message('温馨提示：请不要关闭页面，群发正在进行中！（群发第' . $page . '页）', $this->createWebUrl('kfqf', array('op' => 'kfqf','page' => $page + 1)), 'error');
                } elseif ($page == $pagesum) {
                    //step6.最后一页 | 修改任务状态
                    message('温馨提示：群发任务已完成！（群发第' . $page . '页）', $this->createWebUrl('tbgoods'), 'success');
                } else {
                    message('温馨提示：该群发任务已完成！', $this->createWebUrl('tbgoods'), 'error');
                }       
            }else{
               message('温馨提示：该群发任务已完成！', $this->createWebUrl('tbgoods'), 'success');
            }
        }
        
        
        function postgoods($w,$goods,$openid){//发送图文消息       
	        foreach ($goods as $key => $value) {
	           // $viewurl=$w['siteroot'].str_replace('./','app/',$this->createMobileurl('view',array('itemid'=>$value['itemid'])));
	            $viewurl=$w['siteroot']."app/index.php?i=".$w['uniacid']."&c=entry&do=view&m=tiger_newhu&itemid=".$value['itemid'];
	            $response[] = array(
	                'title' => urlencode("【券后价:".$value['itemendprice']."】".$value['itemtitle']),
	                'description' => urlencode($value['itemtitle']),
	                'picurl' => tomedia($value['itempic']."_100x100.jpg"),
	                'url' =>$viewurl
	            );
	        }
	
	        $message = array(
	            'touser' => trim($openid),
	            'msgtype' => 'news',
	            'news' => array('articles'=>$response)
	        );
	
	       
	       $acid = $w['acid'];
			if (empty($acid)) {
				$acid = $w['uniacid'];
			}
	       $account_api = WeAccount::create($acid);
	       $status = $account_api->sendCustomNotice($message);
	       return $status;
	}
        