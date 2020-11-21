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
	}else{
		$name='游客';
	}
	return $name;

}
//获取村庄名称
function gettownname($id){
	
	$name='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_town')." WHERE id=:id",array(':id'=>$id));
	if(!empty($res)){
		$name=$res['name'];
	}
	return $name;

}


//返回是否有新消息提示
function getnewdd($weid,$mid){
	$newdd=0;
	/*
	$res=pdo_fetchall("SELECT * FROM ".tablename('bc_party_messages')." WHERE weid=".$weid." AND mid=".$mid." AND status=0 ORDER BY id DESC");
	if (!empty($res)){
		$newdd=1;
	}

	 */
	return $newdd;
}

//返回总人口
function getmembernum($weid){
	$num=pdo_fetchcolumn("SELECT count(mid) FROM ".tablename('bc_community_member')." WHERE weid=".$weid." AND isrz=1");
	if(empty($num)){
		$num=0;
		return $num;
	}else{
		return $num;
	}	
}
//返回总乡镇
function gettownnum($weid){
	$num=pdo_fetchcolumn("SELECT count(id) FROM ".tablename('bc_community_town')." WHERE weid=".$weid." AND lev=2");
	if(empty($num)){
		$num=0;
		return $num;
	}else{
		return $num;
	}	
}
//返回总村庄数
function getvillagenum($weid){
	$num=pdo_fetchcolumn("SELECT count(id) FROM ".tablename('bc_community_town')." WHERE weid=".$weid." AND lev=3");
	if(empty($num)){
		$num=0;
		return $num;
	}else{
		return $num;
	}	
}
//返回管理员姓名
function getmanagename($id){
	$name='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE id=:id",array(':id'=>$id));
	if(!empty($res)){
		$name=$res['uname'];
	}
	return $name;
}

//返回用户姓名
function getusername($id){
	$name='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE id=:id",array(':id'=>$id));
	if(!empty($res)){
		$name=$res['realname'];
	}
	return $name;
}

//返回当前管理员管理级别下的所有成员列表
function getalltownuser($weid,$townid){
	//查询这个乡镇的所有村庄列表
	$list=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=".$weid." AND pid=".$townid);	
	
}


//返回认证村民的人数
function getvillageuser($weid,$vid){
	$num=pdo_fetchcolumn("SELECT count(mid) FROM ".tablename('bc_community_member')." WHERE weid=".$weid." AND menpai=".$vid." AND isrz=1");
	if(empty($num)){
		$num=0;
		return $num;
	}else{
		return $num;
	}	
}
//返回关注村民人数
function getvillagegzuser($weid,$vid){
	$num=pdo_fetchcolumn("SELECT count(id) FROM ".tablename('bc_community_guanzhu')." WHERE weid=".$weid." AND townid=".$vid);
	if(empty($num)){
		$num=0;
		return $num;
	}else{
		return $num;
	}	
}

//返回本村帖子发布数
function getvillagebbs($weid,$vid){
	$num=pdo_fetchcolumn("SELECT count(nid) FROM ".tablename('bc_community_news')." WHERE weid=".$weid." AND menpai=".$vid." AND status=0");
	if(empty($num)){
		$num=0;
		return $num;
	}else{
		return $num;
	}	
}


//返回乡村组织列表
function getorgantypelist($weid,$townid){
	$str='';
	
	$list=pdo_fetchall("SELECT * FROM ".tablename('bc_community_organlev')." WHERE weid=".$weid." AND villageid=".$townid);
	if(!empty($list)){
		
		foreach ($list as $j => $res) {
			
			$str.='<button type="button" class="mui-btn mui-btn-outlined mr05 mb05" id="organtype'.$res['id'].'">'.$res['organname'].'<span class="mui-icon mui-icon-closeempty t-sbla f24" onclick="delorgantype('.$res['id'].')"></span></button>';			
		}	
		
	}
	return $str;
	
}


//返回各个乡镇管理员人数
function getmanagenum($weid,$townid){
	$num=pdo_fetchcolumn("SELECT count(id) FROM ".tablename('bc_community_jurisdiction')." WHERE weid=".$weid." AND townid=".$townid);
	if(empty($num)){
		$num=0;
		return $num;
	}else{
		return $num;
	}	
}

//返回收入
function getsouru($n){
	
    $s='';
    switch($n){
        case $n == 1:
             $s='0-5000元';
        	break;
        case $n == 2:
       		 $s='5000-10000元';
        	break;
        case $n == 3:
             $s='10000至3万元';
        	break;
        case $n == 4:
             $s='3万元至10万元';
        	break;
        case $n == 5:
             $s='0万元以上';
        	break;
        case $n == 6:
             $s='其它';
            break;
        
        default:
            $s='其它';
                
    }
    return $s;

}


//返回种养技术分类名称
function gettechnologytype($id){
	$name='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_coursetype')." WHERE id=:id",array(':id'=>$id));
	if(!empty($res)){
		$name=$res['title'];
	}
	return $name;
}



//返回组织成员列表
function getorganuserlist($weid,$id){
	
	$list=pdo_fetchall("SELECT * FROM " . tablename('bc_community_organuser') . " WHERE weid=".$weid." AND organid=".$id." ORDER BY id DESC");	
	$comment = '';
	foreach ($list as $t => $com) {
		$comment.='<div class="mui-col-xs-12 ubb b-gra" onclick="openorganuser('.$com['id'].')">'
			.'<div class="mui-row tx-c pt05 pb05">'
				.'<div class="mui-col-xs-4 ">'.$com['username'].'</div>'
				.'<div class="mui-col-xs-8 ubl b-gra">'.$com['zhiwei'].'</div>'
			.'</div>'
		.'</div>';
	}	
	return $comment;	
}


//返回产品分类名称
function getcategoryname($id){
	$name='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE id=:id",array(':id'=>$id));
	if(!empty($res)){
		$name=$res['ctitle'];
	}
	return $name;
}

//返回订单状态
function getorderstatus($n){
	$s='';
    switch($n){
        case $n == 1:
             $s='待发货';
        	break;
        case $n == 2:
       		 $s='已发货';
        	break;
        case $n == 3:
             $s='待确认收货';
        	break;
        case $n == 4:
             $s='已确认收货';
        	break;
        case $n == 5:
             $s='客服处理中';
        	break;
        case $n == 6:
             $s='客服已确认';
            break;
		case $n == 7:
             $s='该订单已关闭';
            break;
        case $n == 9:
             $s='待付款';
            break;
        default:
            $s='';
                
    }
    return $s;
}

//返回商家商品数
function getsellergoods($weid,$sid){
	$num=pdo_fetchcolumn("SELECT count(id) FROM ".tablename('bc_community_mall_goods')." WHERE weid=".$weid." AND sid=".$sid);
	if(empty($num)){
		$num=0;
		return $num;
	}else{
		return $num;
	}	
}
//返回商家订单数
function getsellerorders($weid,$sid){
	$num=pdo_fetchcolumn("SELECT count(id) FROM ".tablename('bc_community_mall_orders')." WHERE weid=".$weid." AND sid=".$sid);
	if(empty($num)){
		$num=0;
		return $num;
	}else{
		return $num;
	}	
}

//返回商家钱包余额
function getsellerwallets($weid,$sid){
	$num=pdo_fetchcolumn("SELECT sum(amount) FROM ".tablename('bc_community_mall_wallet')." WHERE weid=".$weid." AND mid=".$sid);
	if(empty($num)){
		$num='0.00';
		return $num;
	}else{
		return $num;
	}	
}
//返回商家提现冻结金额
function getsellerwalletsdj($weid,$sid){
	$num=pdo_fetchcolumn("SELECT sum(amount) FROM ".tablename('bc_community_mall_wallet')." WHERE weid=".$weid." AND mid=".$sid." AND type=2 AND status=0");
	if(empty($num)){
		$num='0.00';
		return $num;
	}else{
		return $num;
	}	
}

//返回商家总的订单收入
function getsellerzsr($weid,$sid){
	$num=pdo_fetchcolumn("SELECT sum(amount) FROM ".tablename('bc_community_mall_wallet')." WHERE weid=".$weid." AND status=1 AND type=1 AND mid=".$sid);
	if(empty($num)){
		$num='0.00';
		return $num;
	}else{
		return $num;
	}	
}
//返回总的订单收入
function getallamount($weid,$townid,$lev){
	$cx='';
	if($lev==2){
		$cx=' AND danyuan='.$townid;
	}else if($lev==3){
		$cx=' AND menpai='.$townid;
	}
	$num=pdo_fetchcolumn("SELECT sum(amount) FROM ".tablename('bc_community_mall_wallet')." WHERE weid=".$weid.$cx." AND status=1 AND type=1");
	if(empty($num)){
		$num='0.00';
		return $num;
	}else{
		return $num;
	}	
}
//返回商家的提现总和
function getsellertx($weid,$sid){
	$num=pdo_fetchcolumn("SELECT sum(amount) FROM ".tablename('bc_community_mall_wallet')." WHERE weid=".$weid." AND status=1 AND type=2 AND mid=".$sid);
	if(empty($num)){
		$num='0.00';
		return $num;
	}else{
		return $num;
	}	
}
//返回已提现总和
function gettxamount($weid){
	$num=pdo_fetchcolumn("SELECT sum(amount) FROM ".tablename('bc_community_mall_wallet')." WHERE weid=".$weid." AND status=1 AND type=2");
	if(empty($num)){
		$num='0.00';
		return $num;
	}else{
		return $num;
	}	
}
//返回冻结提现额
function gettxamountdj($weid){
	$num=pdo_fetchcolumn("SELECT sum(amount) FROM ".tablename('bc_community_mall_wallet')." WHERE weid=".$weid." AND status=0 AND type=2");
	if(empty($num)){
		$num='0.00';
		return $num;
	}else{
		return $num;
	}	
}

//返回大类下的所有小类
function getsmalltype($weid,$pid){
	
	$list=pdo_fetchall("SELECT * FROM " . tablename('bc_community_mall_category') . " WHERE weid=".$weid." AND pid=".$pid." ORDER BY id DESC");	
	$comment = '';
	if($list){
		foreach ($list as $t => $com) {
			$comment.='<button type="button" class="mui-btn mui-btn-success mui-btn-outlined mb05 mr05" onclick="opengoods('.$pid.','.$com['id'].')">'.$com['ctitle'].'</button>';
		}	
		
	}
	
	return $comment;	
	
}

//获取商品类别名称
function getgoodstypename($id){
	
	$name='';
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE id=:id",array(':id'=>$id));
	if(!empty($res)){
		$name=$res['ctitle'];
	}
	return $name;

}

//返回订单数
function getordernum($weid,$townid,$lev,$n){
	$cx='';
	if($manage['lev']==2){
		$cx=' AND danyuan='.$townid;
	}else if($manage['lev']==3){
		$cx=' AND menpai='.$townid;
	}
	if($n!=0){
		$cx.=' AND postatus='.$n;
	}


	$num=pdo_fetchcolumn("SELECT count(id) FROM ".tablename('bc_community_mall_orders')." WHERE weid=".$weid.$cx);
	if(empty($num)){
		$num=0;
		return $num;
	}else{
		return $num;
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


function operate_log($uid,$type,$message){
    global $_W;
    $result = false;
    $newdata = array(
        'weid' => $_W['uniacid'],
        'uid' => $uid,
        'type' => $type,
        'ip' => $_W['clientip'],
        'message' => $message,
        'dateline' => time()
    );
    $res = pdo_insert('bc_community_log',$newdata);
    if($res){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}




?>