<?php
global $_W, $_GPC;
$dluid=$_GPC['dluid'];//share id
$uid=$_GPC['uid'];

        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	echo "请在微信端打开!";
	        	exit;
	        }	        
        }
		$rank = $poster['slideH'];  
        if(empty($rank)){
          $rank=20;
        }
        $cfg=$this->module['config'];
     	
        $shares=pdo_fetchall("select uid, sum(num) AS rmb from ".tablename($this->modulename."_jl")." where num>0 and weid='{$_W['uniacid']}' group by uid order by sum(num) desc");
//      
//      echo "<pre>";
//      	print_r($shares);
//      	exit;


        $cfg=$this->module['config'];  
            foreach ($shares as $k=>$value){
            	
            	$share=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$value['uid']}'");//当前粉丝信息
            	if(empty($share['nickname'])){
            		continue;
            	}
            	$good[$k]['nickname']=$share['nickname'];
            	$good[$k]['avatar']=$share['avatar'];
            	$good[$k]['credit1']=intval($value['rmb']);               
            }

        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
		include $this->template ('user/ranking' );