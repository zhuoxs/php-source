<?php
//http://cs.tigertaoke.com/app/index.php?i=14&c=entry&do=appdh&m=tiger_newhu&fztype=1
	//菜单//广告
global $_W, $_GPC;
		$cfg = $this->module['config'];
		$weid=$_W['uniacid'];
    	if($cfg['mmtype']==2){
    		$lm=2;
    	}else{
    		$lm=0;
    	}    	
    	$httpsurl=$cfg['tknewurl'];
    	
    	
    	$where=" and fztype=".$_GPC['fztype'];//1首页广告   2广告下面菜单  3图标下面图片 4底部菜单  5会员中心下方图标
    	
    	//echo $weid;
		

		$dh = pdo_fetchall("SELECT * FROM " . tablename("tiger_newhu_appdh") . " WHERE showtype<>1 and  weid='{$weid}' {$where} order by px asc");

		$dha=array();
		foreach($dh as $k=>$v){
			if($v['hd']==1){
				$hdname="聚划算";
			}elseif($v['hd']==2){
				$hdname="淘抢购";
			}elseif($v['hd']==3){
				$hdname="秒杀";
			}elseif($v['hd']==5){
				$hdname="视频单";
			}elseif($v['hd']==10){
				$hdname="大额券";
			}elseif($v['hd']==11){
				$hdname="9.9元专区";
			}elseif($v['hd']==12){
				$hdname="30元封顶";
			}
			
			if($v['apppage1']=='xb://product/'){
				$apppage1='xb://product/'.$v['itemid'];
			}else{
				$apppage1=$v['apppage1'];
			}
			
			$dha[$k]['id']=$v['id'];
			$dha[$k]['px']=$v['px'];
			$dha[$k]['fztype']=$v['fztype'];
			$dha[$k]['type']=$v['type'];
			$dha[$k]['title']=$v['title'];
			$dha[$k]['ftitle']=$v['ftitle'];
			$dha[$k]['hd']=$v['hd'];
			$dha[$k]['hdname']=$hdname;
			$dha[$k]['apppage1']=$apppage1;
			$dha[$k]['apppage2']=$v['apppage2'];
			$dha[$k]['fqcat']=$v['fqcat'];
			$dha[$k]['flname']=$v['flname'];
			$dha[$k]['headcolorleft']=$v['headcolorleft'];
			$dha[$k]['headcolorright']=$v['headcolorright'];
			$dha[$k]['xz']=$v['xz'];
			$dha[$k]['pic']=tomedia($v['pic']);
			$dha[$k]['pic1']=tomedia($v['pic1']);
			$dha[$k]['url']=urlencode($v['url']);		
			$dha[$k]['h5title']=$v['h5title'];
		}
		//file_put_contents(IA_ROOT."/addons/tiger_tkxcx/dh_log.txt","\ndaohang:".json_encode($dha),FILE_APPEND);
		exit(json_encode(array('errcode'=>0,'data'=>$dha))); 
?>