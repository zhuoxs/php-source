<?php


global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$all_net=$this->get_allnet(); 

$base=$this->get_base(); 
$title=$base['title'].' - 乡村旅游';
$mid=$this->get_mid(); 


$gz=$this->guanzhu(); 
//判断是否需要进入强制关注页
if($gz==1){
	if ($_W['fans']['follow']==0){
		include $this -> template('follow');
		exit;
	};
}else{
	//取得用户授权
	mc_oauth_userinfo();
}
$weid = $_W['uniacid'];
//获取当前用户的信息
$member=$this->getmember();
$id = intval($_GPC['sights_id']);

//评价
if($_GPC['act'] == 'assess'){
    if(!$mid){
        $result = array();
        $result['full'] = 2;
        $result['message'] = '请先登陆！';
        echo json_encode($result);
        exit;
    }


    $assess = intval($_GPC['assess']);
    $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_assess_log')." WHERE link_id=$id AND a_type=1 AND mid=$mid");
    if($count < 1){
        pdo_insert('bc_community_assess_log',array(
            'weid'=>$weid,
            'link_id'=>$id,
            'assess'=>$assess,
            'a_type'=>1,
            'dateline'=>time(),
            'mid'=>$mid
        ));
        $items = pdo_fetch("SELECT * FROM ".tablename('bc_community_tour_sights')." WHERE sights_id = $id");
        if($assess==1){
            pdo_update('bc_community_tour_sights',array('good'=>$items['good']+1),array('sights_id'=>$id));
        }
        if($assess==2){
            pdo_update('bc_community_tour_sights',array('general'=>$items['general']+1),array('sights_id'=>$id));
        }
        if($assess==3){
            pdo_update('bc_community_tour_sights',array('poor'=>$items['poor']+1),array('sights_id'=>$id));
        }
        $result = array();
        $result['full'] = 1;
        $result['message'] = '评价成功！';
    }else{
        $result = array();
        $result['full'] = 2;
        $result['message'] = '您已评价过了';
    }
    echo json_encode($result);
    exit;
}

//评论
if($_GPC['act'] == 'message_list_ajax') {
    $page = intval($_GPC['page']);
    $psize = 10;
    $start = ($page-1)*$psize;
    $list = pdo_fetchall("SELECT A.*,B.nickname,B.avatar FROM ".tablename('bc_community_tour_comment')." A LEFT JOIN ".tablename('bc_community_member')." B ON A.mid=B.mid WHERE A.weid=$weid AND A.ctype=1 AND A.link_id = $id ORDER BY A.dateline DESC LIMIT $start,$psize");

    foreach ($list as $key => $value) {
        $value['dateline'] = date('Y-m-d H:i',$value['dateline']);
        echo '<div class="mui-row" style="padding: 8px 15px; border-top:#f0f0f0 solid 1px;">
				<div class="mui-col-xs-2"><img src="'.$value['avatar'].'" style="max-width: 100%; width: 42px; border-radius: 50%;"></div>
				<div class="mui-col-xs-8">
					<div style="font-size: 13px; color: #aaaaaa;">'.$value['nickname'].'</div>
					<div style="font-size: 13px; color: #aaaaaa;">'.$value['dateline'].'</div>
					<div style="padding: 10px 0px; font-size: 14px;">'.$value['message'].'</div>
				</div>
				<div class="mui-col-xs-2" style="text-align: right;">
					<span class="like" data-value="'.$value['cid'].'"><i class="iconfont icon-dianzan" style="font-size: 12px;"></i><span class="like_value">'.$value['likes'].'</span></span>
				</div>
			</div>';
    }
    exit;
}


//评论
if($_GPC['act'] == 'message') {
    if(!$mid){
        $result = array();
        $result['full'] = 2;
        $result['message'] = '请先登陆！';
        echo json_encode($result);
        exit;
    }

    if(!$_GPC['message']){
        $result = array();
        $result['full'] = 2;
        $result['message'] = '请输入评论内容！';
        echo json_encode($result);
        exit;
    }


    $res = pdo_insert('bc_community_tour_comment',array(
        'weid'=>$weid,
        'link_id'=>$id,
        'message'=>addslashes($_GPC['message']),
        'ctype'=>1,
        'dateline'=>time(),
        'mid'=>$mid
    ));

    if($res){
        $result = array();
        $result['full'] = 1;
        $result['message'] = '评论成功！';
    }else{
        $result = array();
        $result['full'] = 1;
        $result['message'] = '评论失败！';
    }
    echo json_encode($result);
    exit;
}
//评论点赞
if($_GPC['act'] == 'like'){
    $message_id = intval($_GPC['message_id']);
    if(!$mid){
        $result = array();
        $result['full'] = 2;
        $result['message'] = '请先登陆！';
        echo json_encode($result);
        exit;
    }
    $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_tour_like_log')." WHERE link_id=$message_id AND mid=$mid");
    if($count < 1){
        pdo_insert('bc_community_tour_like_log',array(
            'weid'=>$weid,
            'link_id'=>$message_id,
            'dateline'=>time(),
            'mid'=>$mid
        ));
        $items = pdo_fetch("SELECT * FROM ".tablename('bc_community_tour_comment')." WHERE cid = $message_id");
        pdo_update('bc_community_tour_comment',array('likes'=>$items['likes']+1),array('cid'=>$message_id));
        $result = array();
        $result['full'] = 1;
        $result['message'] = '点赞成功！';
    }else{
        $result = array();
        $result['full'] = 2;
        $result['message'] = '您已点赞过了';
    }
    echo json_encode($result);
    exit;
}









$items = pdo_fetch("SELECT * FROM ".tablename('bc_community_tour_sights')." WHERE sights_id = $id");
$items['latlong'] = explode(',',$items['latlong']);
$tour = pdo_fetch("SELECT * FROM ".tablename('bc_community_tour_info')." WHERE weid=$weid AND town_id = ".$items['town_id']);
$total_assess_count = $items['good']+$items['general']+$items['poor'];
$items['good_p'] = intval($items['good']/$total_assess_count*100);
$items['general_p'] = intval($items['general']/$total_assess_count*100);
$items['poor_p'] = intval($items['poor']/$total_assess_count*100);

include $this -> template('tour_sights_view');

?>