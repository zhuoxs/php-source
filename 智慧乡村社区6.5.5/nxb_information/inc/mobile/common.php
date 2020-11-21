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
    $restime=date('Y-m-d H:i',$oldtime);    
    return $restime;
}	

//返回产品已售百分比	
function getys($pqty,$pyqty){
	$ys=$pyqty/$pqty*100;
	return floor($ys);
}

//返回产品已售的圆形率
function getcircle($pqty,$pyqty){
	$ys=$pyqty/$pqty;
	$circle=$ys*360;
	return ceil($circle);	
}

//返回视频分类上一级的分类名称
function get2name($weid,$vpid){
	$videotype=pdo_fetch("SELECT * FROM ".tablename('cn_tmow_video_partition')." WHERE weid=:uniacid AND vpid=:vpid",array(':uniacid'=>$weid,':vpid'=>$vpid));
	$vpname=$videotype['vpname'];
	return $vpname;
}

//返回该视频分区内的所有视频列表
function getvideolist($weid,$vpid){
	$videolist=pdo_fetchall("SELECT * FROM " . tablename('cn_tmow_video') . " WHERE weid=" .$weid. " AND vpid=".$vpid." ORDER BY vid DESC");	
	$option = '';
	foreach ($videolist as $t => $com) {
		$option.='<li class="bd-item-list">'
        		.'<a href="javascript:;" onclick="openurl('.$com['vid'].');">'
        			.'<img src="'.tomedia($com['vimg']).'"><strong>'.$com['vname'].'</strong>'
        		.'</a>'
        	.'</li>';		
	}	
	return $option;			
}

//返回文章分类名称
function getarttypename($weid,$atid){
	$atname='';
	$articletype=pdo_fetch("SELECT * FROM ".tablename('cn_tmow_articletype')." WHERE weid=:uniacid AND atid=:atid",array(':uniacid'=>$weid,':atid'=>$atid));
	if(!empty($articletype)){
		$atname=$articletype['atname'];
	}
	
	return $atname;
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