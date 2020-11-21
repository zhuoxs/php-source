<?php

	//返回时间戳的时间格式
function getgaptime($oldtime){
    $gaptime=time()-$oldtime;
    switch($gaptime){
        case $gaptime == 0:
            $restime='刚刚';
        break;
        case $gaptime < 60:
        $restime=$gaptime.'秒之前';
            break;
            case $gaptime < 60*60:
                $restime=floor($gaptime/60).'分钟前';
            break;
            case $gaptime < 60*60*24:
                $restime=floor($gaptime/(60*60)).'小时前';
                break;
                case $gaptime < 60*60*24*3;
                $restime=floor($gaptime/(60*60*24)) == 1 ? '昨天'.date('H:i',$oldtime) : '前天'.date('H:i',$oldtime);
                break;
                case $gaptime < 60*60*24*30:
                    $restime=floor($gaptime/(60*60*24)).'天前';
                break;
                case $gaptime < 60*60*24*365:
                    $restime=floor($gaptime/(60*60*24*30)).'月前';
                break;
                case $gaptime < 60*60*24*365*3:
                    $restime=floor($gaptime/(60*60*24*365)).'年前';
                break;
                default:
                    $restime=date('Y-m-d',$oldtime);
                
    }
    return $restime;
}

function gettime($oldtime){
    $restime=date('Y-m-d H:i:s',$oldtime);    
    return $restime;
}

//返回不同类型产品的数量
function getptnum($ptid,$weid){
	$pnum=pdo_fetchcolumn("SELECT count(pid) FROM ".tablename('cn_tmow_product')." WHERE weid=".$weid." AND ptid=".$ptid);
	return $pnum;
}

//返回客服服务用户数量
function getsm($sid,$weid){
	$snum=pdo_fetchcolumn("SELECT count(mid) FROM ".tablename('cn_tmow_member')." WHERE weid=".$weid." AND sid=".$sid);
	return $snum;
}

function genTree9($items) {
    $tree = array(); //格式化好的树
    foreach ($items as $item)
        if (isset($items[$item['tid']]))
            $items[$item['tid']]['son'][] = &$items[$item['id']];
        else
            $tree[] = &$items[$item['id']];
    return $tree;
    }


//返回对应文章类型的文章数
function getarticlenum($weid,$atid){
		$anum=pdo_fetchcolumn("SELECT count(aid) FROM ".tablename('cn_tmow_article')." WHERE weid=".$weid." AND atid=".$atid);
		return $anum;
	}
//返回对应分区的监控视频数
function getvideonum($weid,$vpid){
		$vnum=pdo_fetchcolumn("SELECT count(vid) FROM ".tablename('cn_tmow_video')." WHERE weid=".$weid." AND vpid=".$vpid);
		return $vnum;
	}
//返回客服名称
function getkfname($weid,$sid){
	$name='';
	$service=pdo_fetch("SELECT * FROM ".tablename('cn_tmow_service')." WHERE weid=:uniacid AND sid=:sid",array(':uniacid'=>$weid,':sid'=>$sid));
	if (!empty($service)){
		$name=$service['sname'];
	}
	return $name;
}

//后台统计相关
//返回用户交易单数
function getordernum($weid,$mid){
	//查询订单表，返回符合条件的记录个数
	$onum=pdo_fetchcolumn("SELECT count(poid) FROM ".tablename('cn_tmow_productorders')." WHERE weid=".$weid." AND mid=".$mid);
	return $onum;	
}
//返回用户交易总额
function getordertotal($weid,$mid){
	//查询订单表，返回符合条件的记录个数
	$ototal=pdo_fetchcolumn("SELECT SUM(pototalprice) FROM ".tablename('cn_tmow_productorders')." WHERE weid=".$weid." AND mid=".$mid);
	return $ototal;	
}
//返回用户可用余额
function getye($weid,$mid){
	$ye=pdo_fetchcolumn("SELECT SUM(amount) FROM ".tablename('cn_tmow_wallet')." WHERE weid=".$weid." AND mid=".$mid." AND wstatus=0");
	if(empty($ye)){
		$ye=0.00;
	}
	return $ye;	
}
//返回用户已返本金
function getyfbj($weid,$mid){
	$yfbj=pdo_fetchcolumn("SELECT SUM(amount) FROM ".tablename('cn_tmow_wallet')." WHERE weid=".$weid." AND mid=".$mid." AND wstatus=0 AND wtype=8");
	if(empty($yfbj)){
		$yfbj=0.00;
	}
	return $yfbj;	
}
//返回用户待返本金
function getdfbj($weid,$mid){
	$dfbj=pdo_fetchcolumn("SELECT SUM(amount) FROM ".tablename('cn_tmow_wallet')." WHERE weid=".$weid." AND mid=".$mid." AND wstatus=1 AND wtype=8");
	if(empty($dfbj)){
		$dfbj=0.00;
	}
	return $dfbj;	
}
//返回用户已返收益
function getyfsy($weid,$mid){
	$yfsy=pdo_fetchcolumn("SELECT SUM(amount) FROM ".tablename('cn_tmow_wallet')." WHERE weid=".$weid." AND mid=".$mid." AND wstatus=0 AND wtype=4");
	if(empty($yfsy)){
		$yfsy=0.00;
	}
	return $yfsy;	
}
//返回用户待返收益
function getdfsy($weid,$mid){
	//计算待收收益：到期分红的和按月分红的
	$dssy1=pdo_fetchcolumn("SELECT SUM(mproprofit) FROM ".tablename('cn_tmow_moon_profit')." WHERE weid=".$weid." AND mid=".$mid." AND mprostatus=2");
	if(empty($dssy1)){
		$dssy1=0;
	}
	$dssy2=pdo_fetchcolumn("SELECT SUM(eproprofit) FROM ".tablename('cn_tmow_expire_profit')." WHERE weid=".$weid." AND mid=".$mid." AND eprostatus=2");
	if(empty($dssy2)){
		$dssy2=0;
	}
	$dssy=$dssy1+$dssy2;
	return $dssy;	
}
//返回用户已返注册佣金
function getyfzcyj($weid,$mid){
	$yfzcyj=pdo_fetchcolumn("SELECT SUM(amount) FROM ".tablename('cn_tmow_wallet')." WHERE weid=".$weid." AND mid=".$mid." AND wstatus=0 AND wtype=5");
	if(empty($yfzcyj)){
		$yfzcyj=0.00;
	}
	return $yfzcyj;	
}
//返回用户已返购买佣金
function getyfgmyj($weid,$mid){
	$yfgmyj=pdo_fetchcolumn("SELECT SUM(amount) FROM ".tablename('cn_tmow_wallet')." WHERE weid=".$weid." AND mid=".$mid." AND wstatus=0 AND wtype=9");
	if(empty($yfgmyj)){
		$yfgmyj=0.00;
	}
	return $yfgmyj;	
}
//返回用户待返注册佣金
function getdfzcyj($weid,$mid){
	$dfzcyj=pdo_fetchcolumn("SELECT SUM(amount) FROM ".tablename('cn_tmow_wallet')." WHERE weid=".$weid." AND mid=".$mid." AND wstatus=1 AND wtype=5");
	if(empty($dfzcyj)){
		$dfzcyj=0.00;
	}
	return $dfzcyj;	
}
//返回用户待返购买佣金
function getdfgmyj($weid,$mid){
	$dfgmyj=pdo_fetchcolumn("SELECT SUM(amount) FROM ".tablename('cn_tmow_wallet')." WHERE weid=".$weid." AND mid=".$mid." AND wstatus=1 AND wtype=9");
	if(empty($dfgmyj)){
		$dfgmyj=0.00;
	}
	return $dfgmyj;	
}
//返回用户活动支出
function gethdzc($weid,$mid){
	$hdzc=pdo_fetchcolumn("SELECT SUM(amount) FROM ".tablename('cn_tmow_wallet')." WHERE weid=".$weid." AND mid=".$mid." AND wstatus=0 AND wtype=6");
	if(empty($hdzc)){
		$hdzc=0.00;
	}
	return $hdzc;	
}

function dq($t){
	$res=0;
	$j=time();
	if($j>=$t){
		$res=1;
	}
	return $res;
}

//发送模板消息
function sendTemplate_common($touser,$template_id,$url,$data){
     	global $_W; 
     	$weid = $_W['acid'];  
        load()->classs('weixin.account');
        $accObj= WeixinAccount::create($weid);
        $ret=$accObj->sendTplNotice($touser, $template_id, $data, $url);
        return $ret;
      
	}
?>