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
	//返回评论数
function getcommentnum($weid,$newsid){
	$commentnum=pdo_fetchcolumn("SELECT count(cid) FROM ".tablename('bc_community_comment')." WHERE weid=".$weid." AND newsid=".$newsid);
	return $commentnum;
}

//返回点赞列表
/*
function getthumbslist($weid,$newsid){
	$thumbslist=pdo_fetchall("SELECT a.*,b.realname,b.nickname FROM " . tablename('bc_community_thumbs') . " as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid WHERE a.weid=" .$weid. " AND newsid=".$newsid." ORDER BY thid DESC");	
	$comment = '';
	foreach ($thumbslist as $t => $com) {
		if ($com['realname']){
			$comment.=$com['realname'].'&nbsp;';
		}else{
			$comment.=$com['nickname'].'&nbsp;';
		}		
	}
	return $comment;
}
*/

//返回栏目名称
function getmenuname($weid,$menuid){
	$munename='';
	$menu=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=".$weid." AND meid=".$menuid);
	if(!empty($menu)){
		$munename=$menu['mtitle'];
	}
	return $munename;
}

//返回评论列表
function getcommentlist($weid,$newsid){
	$commentlist=pdo_fetchall("SELECT a.*,b.avatar,b.nickname FROM " . tablename('bc_community_comment') . " as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid WHERE a.weid=" .$weid. " AND newsid=".$newsid." ORDER BY cid DESC");	
	$comment = '';
	foreach ($commentlist as $t => $com) {
		$comment.='<div class="mui-row b-sgra pt02 pb1 pt05 ubb b-gra">'
					.'<div class="mui-col-xs-1">'
						.'<img src="'.tomedia($com['avatar']).'" class="plxtx">'											
					.'</div>'
					.'<div class="mui-col-xs-11 pl05">'
						.'<div class="mui-row pl02">'
							.'<div class="mui-col-xs-6 ulev-1 t-gra">'.$com['nickname'].'</div>'
							.'<div class="mui-col-xs-6 tx-r ulev-1 t-gra pr05">'.getgaptime($com['cctime']).'</div>'
							.'<div class="mui-col-xs-12 ulev-1 t-sbla">'.$com['comment']
							.'</div>'
						.'</div>'
					.'</div>'
				.'</div>';
	}	
	return $comment;		
}

//返回首页单个帖子的评论列表
function getcommentlist6($weid,$newsid){
	//先查询这个帖子的评论数
	$commentnum=pdo_fetchcolumn("SELECT count(cid) FROM ".tablename('bc_community_comment')." WHERE weid=" .$weid." AND newsid=".$newsid);
	
	
	$commentlist=pdo_fetchall("SELECT a.*,b.avatar,b.realname FROM " . tablename('bc_community_comment') . " as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid WHERE a.weid=" .$weid. " AND newsid=".$newsid." ORDER BY cid DESC LIMIT 0,5");	
	$comment = '';
	foreach ($commentlist as $t => $com) {
		$comment.='<p><span class="t-blu">'.$com['realname'].'：</span><span class="">'.$com['comment'].'</span></p>';	
	}	
	
	return $comment;		
}


//返回点赞数
function getzannum($weid,$newsid){
	$zannum=pdo_fetchcolumn("SELECT count(thid) FROM ".tablename('bc_community_thumbs')." WHERE weid=".$weid." AND newsid=".$newsid." AND thstatus=1");
	return $zannum;
}

//返回点赞列表
function getthumbslist($weid,$newsid){
	$zanlist=pdo_fetchall("SELECT a.*,b.avatar FROM " . tablename('bc_community_thumbs') . " as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid WHERE a.weid=" .$weid. " AND newsid=".$newsid." AND thstatus=1");	
	$zan = '';
	foreach ($zanlist as $j => $res) {
		$zan.='<img src="'.tomedia($res['avatar']).'" class="zantx">';
	}	
	return $zan;		
}

//返回赞图标的颜色
function getzancolor($weid,$mid,$newsid){
	$zancolor="";
	$zanstatus=pdo_fetch("SELECT * FROM ".tablename('bc_community_thumbs')." WHERE weid=".$weid." AND newsid=".$newsid." AND mid=".$mid);
	if(!empty($zanstatus)){
		if($zanstatus['thstatus']==1){
			$zancolor="t-red";
		}else{
			$zancolor="t-gra";
		}
	}
	
	return $zancolor;
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

//返回意见建议类型的名称
function gettypename($weid,$ptype){
	$type=pdo_fetch("SELECT * FROM ".tablename('bc_community_type')." WHERE weid=".$weid." AND tid=".$ptype);	
	return $type['tname'];
}


//获取角色名称
function getrolename($id){
	//获取权限角色表
	$name='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_authority')." WHERE id=:id",array(':id'=>$id));
	if(!empty($res)){
		$name=$res['authortitle'];
	}
	return $name;

}


?>