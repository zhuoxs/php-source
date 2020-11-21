<?php
global $_W, $_GPC;
$dluid=$_GPC['dluid'];//share id
        $cfg=$this->module['config']; 
        $ad = pdo_fetchall("SELECT * FROM " . tablename($this -> table_ad) . " WHERE weid = '{$_W['weid']}' order by id desc");

        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
//	        if(empty($fans)){
//	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
//     	  	  	 header("Location: ".$loginurl); 
//     	  	  	 exit;
//	        }	 
	          
	          $fans = $_W['fans'];
	          $share=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'"); 
			  $mc = mc_fetch($fans['uid']);
              $fans['credit2']=$share['credit2'];
              $fans['avatar']=$fans['tag']['avatar'];
              $fans['nickname'] =$fans['tag']['nickname'];   
              $fans['tkuid']=  $share['id'];  
        }
        
        $xfcredit= pdo_fetchcolumn("SELECT SUM(num) FROM " . tablename($this->modulename.'_jl')." where type=1 and uid='{$fans['tkuid']}' and num<0  and  weid='{$_W['uniacid']}'");
        $czcredit= pdo_fetchcolumn("SELECT SUM(num) FROM " . tablename($this->modulename.'_jl')." where type=1 and uid='{$fans['tkuid']}' and num>0  and  weid='{$_W['uniacid']}'");

        
		$pid = $_GPC['pid'];
		
		//ajax请求开始
		if($_W['isajax']){
			$page=$_GPC['page'];
			$uid=$_GPC['uid'];
            $pindex = max(1, intval($page));
		    $psize = 20;

            $list = pdo_fetchall("select * from ".tablename($this->modulename."_jl")." where weid='{$_W['uniacid']}' and type=1 and uid='{$uid}' order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_jl')." where type=1 and uid='{$uid}'  and  weid='{$_W['uniacid']}'");
            $list1=array();
            foreach($list as $k=>$v){
            	$list1[$k]['remark']=$v['remark'];  
            	$list1[$k]['num']=$v['num']; 
            	$list1[$k]['createtime']=date("Y-m-d H:i",$v['createtime']);        
            }
            exit(json_encode(array('pages' =>ceil($total/20), 'data' =>$list1)));
		}



        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
        include $this -> template('user/credit2');