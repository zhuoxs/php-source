<?php
global $_W, $_GPC;
        $page=$_GPC['page'];
        $cfg = $this->module['config'];
        if(empty($page)){
          $page=1;
        }
        $op=$_GPC['op'];
        if(!empty($cfg['qfmbid'])){//管理员订单提交提醒
            $mbid=$cfg['qfmbid'];
            $mb=pdo_fetch("select * from ".tablename($this->modulename."_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
            //$msg=$this->mbmsg($cfg['qfmbid'],$mb,$mb['mbid'],$mb['turl'],$fans,$orderid);                  
        }else{
           message('请先选择模版消息ID');
        }


        $pindex = max(1, intval($_GPC['page']));
	    $psize = 100;           
        $list = pdo_fetchall("select openid,nickname from ".tablename("mc_mapping_fans")." where uniacid='{$_W['uniacid']}' order by fanid desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('mc_mapping_fans')." where uniacid='{$_W['uniacid']}' order by fanid desc");
        
		$pager = pagination($total, $pindex, $psize);
        $pagesum=ceil($total/100);  //总页数
        if($op=='qf'){
            if(!empty($list)){
                foreach($list as $k=>$v){
                 $fans['nickname']=$v['nickname'];
                 $msg=$this->mbmsg($v['openid'],$mb,$mb['mbid'],$mb['turl'],$fans,'');
                }
                if ($page < $pagesum) {
					message('温馨提示：请不要关闭页面，群发正在进行中！（群发第' . $page . '页）', $this->createWebUrl('mbxxqf', array('op' => 'qf','page' => $page + 1)), 'error');
                } elseif ($page == $pagesum) {
                    //step6.最后一页 | 修改任务状态
                    message('温馨提示：群发任务已完成！（群发第' . $page . '页）', $this->createWebUrl('index'), 'success');
                } else {
                    message('温馨提示：该群发任务已完成！', $this->createWebUrl('index'), 'error');
                }       
            }else{
               message('温馨提示：该群发任务已完成！', $this->createWebUrl('index'), 'success');
            }
        }