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
//返回单个短信群人数数量
function getgroupmn($weid,$gid){
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_group')." WHERE weid=".$weid." AND gid=".$gid);
	if(!empty($res)){
		$a=explode(",",$res['gmember']);
		$b=array_filter($a);
		$c=count($b);
		return $c;
	}else{
		return 0;
	}
	
}


//返回群成员是否被选中状态
function getcheck($weid,$tel,$gid){
	$check='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_group')." WHERE weid=".$weid." AND gid=".$gid);
	if(!empty($res)){
		$a=explode(",",$res['gmember']);
		$b=array_filter($a);
		
			$isin = in_array($tel,$b);
			if($isin){
    			$check='checked';
			}else{
    			$check='';
			}
		
		
		return $check;
	}else{
		return $check;
	}
}


//返回不同分类帖子的数量
function getnewsnum($weid,$meid){
	$newsnum=pdo_fetchcolumn("SELECT count(nid) FROM ".tablename('bc_community_news')." WHERE weid=".$weid." AND nmenu=".$meid);
	return $newsnum;
}

//返回全部帖子的数量
function getnewsallnum($weid){
	$newsallnum=pdo_fetchcolumn("SELECT count(nid) FROM ".tablename('bc_community_news')." WHERE weid=".$weid);
	return $newsallnum;
}

//返回报名人数
function getreportnum($weid,$nid){
	$reportnum=pdo_fetchcolumn("SELECT count(reid) FROM ".tablename('bc_community_report')." WHERE weid=".$weid." AND newsid=".$nid);
	if(empty($reportnum)){
		$reportnum=0;
		return $reportnum;
	}else{
		return $reportnum;
	}
	
}


function getcheckeded($id,$meid){
	$name='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE meid=:meid",array(':meid'=>$meid));
	$authorid=explode(",",$res['authorid']);		
	foreach ($authorid as $key => $item) {
        	
      	if($item==$id){
      		$name='checked="checked"';
      	}
    }	
	return $name;
}


//获取角色名称
function getrolename($id){
	//获取权限角色表
	$name='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_authority')." WHERE id=:id",array(':id'=>$id));
	if(!empty($res)){
		$name=$res['authortitle'];
	}else{
		$name='游客';
	}
	return $name;

}

function gettownname($id){
	
	$name='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_town')." WHERE id=:id",array(':id'=>$id));
	if(!empty($res)){
		$name=$res['name'];
	}
	return $name;

}

?>