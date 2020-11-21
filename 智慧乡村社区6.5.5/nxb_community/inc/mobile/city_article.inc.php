<?php


global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$all_net = $this->get_allnet();

$base = $this->get_base();
$title = $base['title'] . ' - ';
$mid = $this->get_mid();


$gz = $this->guanzhu();
//判断是否需要进入强制关注页
if ($gz == 1) {
    if ($_W['fans']['follow'] == 0) {
        include $this->template('follow');
        exit;
    };
} else {
    //取得用户授权
    mc_oauth_userinfo();
}
$weid = $_W['uniacid'];
//获取当前用户的信息
$member = $this->getmember();


if ($_GPC['act'] == 'getmainclass') {
    $cid = intval($_GPC['cid']);
    $class = pdo_fetchall("SELECT * FROM " . tablename('bc_community_article_class') . " WHERE weid=:uniacid AND parent_id=$cid ORDER BY displayorder DESC,dateline DESC", array(':uniacid' => $_W['uniacid']));
    foreach ($class as $key => $value) {
        if($key == 0){
            echo '<div class="mui-control-item menu-item" data-value="' . $value['cid'] . '" style="background-color: #fff; font-size: 16px; font-family:Microsoft YaHei; color: #fa6c17; height: 42px;">
							<div style="line-height: 40px; border-bottom: 2px #fa6c17 solid;">' . $value['classname'] . '</div>
						</div>';
        }else{
            echo '<div class="mui-control-item menu-item" data-value="' . $value['cid'] . '" style="line-height: 41px;  border-left: 1px solid #dfdfdf; border-bottom: 1px solid #dfdfdf;font-size: 16px;">
							<div style="line-height: 40px;">' . $value['classname'] . '</div>
						</div>';
        }
    }
    exit;
}

if ($_GPC['act'] == 'getsubsubclass') {
    $cid = intval($_GPC['cid']);
    $class = pdo_fetch("SELECT * FROM " . tablename('bc_community_article_class') . " WHERE weid=:uniacid AND parent_id=$cid ORDER BY displayorder DESC,dateline DESC", array(':uniacid' => $_W['uniacid']));
    $cid = $class['cid'];
    $class = pdo_fetchall("SELECT * FROM " . tablename('bc_community_article_class') . " WHERE weid=:uniacid AND parent_id=$cid ORDER BY displayorder DESC,dateline DESC", array(':uniacid' => $_W['uniacid']));
    foreach ($class as $value) {
        echo '<div class="submenu" data-value="' . $value['cid'] . '">' . $value['classname'] . '</div>';
    }
    exit;
}



if ($_GPC['act'] == 'getsubclass') {
    $cid = intval($_GPC['cid']);
    $class = pdo_fetchall("SELECT * FROM " . tablename('bc_community_article_class') . " WHERE weid=:uniacid AND parent_id=$cid ORDER BY displayorder DESC,dateline DESC", array(':uniacid' => $_W['uniacid']));
    foreach ($class as $value) {
        echo '<div class="submenu" data-value="' . $value['cid'] . '">' . $value['classname'] . '</div>';
    }
    exit;
}

if ($_GPC['act'] == 'list_ajax') {
    $cid = intval($_GPC['cid']);
    $cids = getchildclass($cid);
    $cids = implode(',', $cids);
    $page = intval($_GPC['page']);
    $psize = 10;
    $start = ($page - 1) * $psize;
    $sql = '';
    if($_GPC['keyword']){
        $keyword = addslashes($_GPC['keyword']);
        $sql .= " AND title like '%$keyword%' ";
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename('bc_community_article') . " WHERE weid=$weid AND class_id in($cids) $sql ORDER BY dateline DESC LIMIT $start,$psize");
    foreach ($list as $key => $value) {
        $value['town_name'] = pdo_getcolumn('bc_community_town', array('id' => $value['town_id']), 'name');
        $value['content'] = cutstr_html(htmlspecialchars_decode($value['content']), 150);
        $value['dateline_txt'] = date('Y年m月d日',$value['dateline']);
        echo '<div style="padding: 12px; background-color: #fff; margin-bottom: 12px;" class="article_item link" data-url="'.$this->createMobileUrl('town_article',array('act'=>'view','aid'=>$value['aid'])).'">
			<div class="mui-row">
				<div class="mui-col-xs-3"><img src="' . tomedia($value['cover']) . '" style="width: 80px; height: 80px; display: block; margin: auto;"> </div>
				<div class="mui-col-xs-9">
					<div style="height: 32px; line-height: 32px; font-size:20px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;">
						' . $value['title'] . '
					</div>
					<div style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;overflow: hidden; line-height: 18px; font-size: 14px; color: #c0c0c0; padding-top: 8px;">
						' . $value['content'] . '
					</div>
				</div>
			</div>
			<div class="mui-row" style="margin-top: 10px;color: #c0c0c0; font-size: 12px;">
				<div class="mui-col-xs-4" style="text-align: center;">来自于：'.$value['town_name'].'</div>
				<div class="mui-col-xs-4" style="border-left: 1px solid #dfdfdf;border-right: 1px solid #dfdfdf; text-align: center;"><i class="iconfont icon-chakan" style="font-size: 12px;"></i> '.$value['click'].'</div>
				<div class="mui-col-xs-4" style="text-align: center;">'.$value['dateline_txt'].'</div>
			</div>
		</div>';
    }
    exit;
}


if($_GPC['act'] == 'view'){
    $aid = intval($_GPC['aid']);
    $items = pdo_get('bc_community_article', array('aid' => $aid));
    $items['dateline_txt'] = date('Y年m月d日',$items['dateline']);
    $items['author'] = pdo_getcolumn('bc_community_jurisdiction', array('id' => $items['author_id']), 'uname');
    $items['content'] = htmlspecialchars_decode($items['content']);
    //更新点击
    $items['click'] = $items['click']+1;
    pdo_update('bc_community_article',array('click'=>$items['click']),array('aid'=>$aid));

    $total_assess_count = $items['good']+$items['general']+$items['poor'];
    $items['good_p'] = intval($items['good']/$total_assess_count*100);
    $items['general_p'] = intval($items['general']/$total_assess_count*100);
    $items['poor_p'] = intval($items['poor']/$total_assess_count*100);
    include $this->template('town_article_view');
    exit;
}
//评价
if($_GPC['act'] == 'assess'){
    if(!$mid){
        $result = array();
        $result['full'] = 2;
        $result['message'] = '请先登陆！';
        echo json_encode($result);
        exit;
    }
    $aid = intval($_GPC['aid']);
    $assess = intval($_GPC['assess']);
    $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_assess_log')." WHERE link_id=$aid AND a_type=4 AND mid=$mid");
    if($count < 1){
        pdo_insert('bc_community_assess_log',array(
            'weid'=>$weid,
            'link_id'=>$aid,
            'assess'=>$assess,
            'a_type'=>4,
            'dateline'=>time(),
            'mid'=>$mid
        ));
        $items = pdo_fetch("SELECT * FROM ".tablename('bc_community_article')." WHERE aid = $aid");
        if($assess==1){
            pdo_update('bc_community_article',array('good'=>$items['good']+1),array('aid'=>$aid));
        }
        if($assess==2){
            pdo_update('bc_community_article',array('general'=>$items['general']+1),array('aid'=>$aid));
        }
        if($assess==3){
            pdo_update('bc_community_article',array('poor'=>$items['poor']+1),array('aid'=>$aid));
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
//评论列表
if($_GPC['act'] == 'message_list_ajax') {
    $aid = intval($_GPC['aid']);
    $page = intval($_GPC['page']);
    $psize = 10;
    $start = ($page-1)*$psize;
    $list = pdo_fetchall("SELECT A.*,B.nickname,B.avatar FROM ".tablename('bc_community_tour_comment')." A LEFT JOIN ".tablename('bc_community_member')." B ON A.mid=B.mid WHERE A.weid=$weid AND A.ctype=4 AND A.link_id = $aid ORDER BY A.dateline DESC LIMIT $start,$psize");

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
    $aid = intval($_GPC['aid']);
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
        'link_id'=>$aid,
        'message'=>addslashes($_GPC['message']),
        'ctype'=>4,
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




$nav = pdo_fetchall("SELECT * FROM " . tablename('bc_community_article_nav') . " WHERE weid=:uniacid", array(':uniacid' => $_W['uniacid']));



$cid = intval($_GPC['cid']);
$home = pdo_get('bc_community_article_class', array('cid' => $cid));
$index_name = pdo_getcolumn('bc_community_base', array('id' => 1),'article_index_name');
$title = $title . $index_name;
$cids = getchildclass($cid);
$cids = implode(',', $cids);
$slide = pdo_fetchall("SELECT aid,title,cover FROM " . tablename('bc_community_article') . " WHERE weid=:uniacid AND class_id in($cids) AND slide=1 ORDER BY dateline DESC limit 0,3", array(':uniacid' => $_W['uniacid']));

$pclass = pdo_fetchall("SELECT * FROM " . tablename('bc_community_article_class') . " WHERE weid=:uniacid AND parent_id=$cid ORDER BY displayorder DESC,dateline DESC", array(':uniacid' => $_W['uniacid']));
$sclass = pdo_fetchall("SELECT * FROM " . tablename('bc_community_article_class') . " WHERE weid=:uniacid AND parent_id=" . $pclass[0]['cid'] . " ORDER BY displayorder DESC,dateline DESC", array(':uniacid' => $_W['uniacid']));


$share_title = $title;
$share_desc = $title;
$share_url = $_W['siteurl'];
$share_img = tomedia($slide[0]['cover']);

include $this->template('city_article');
//找出所有子栏目
function getchildclass($cid)
{
    static $tmp = array();
    $child = pdo_fetchall("SELECT * FROM " . tablename('bc_community_article_class') . " WHERE parent_id=:cid", array(':cid' => $cid));
    if (count($child) > 0) {
        foreach ($child as $value) {
            getchildclass($value['cid']);
        }
        $tmp[] = $cid;
    } else {
        $tmp[] = $cid;
    }
    return $tmp;
}

function cutstr_html($string, $sublength = 230, $encoding = 'utf-8', $ellipsis = '…')
{
    $sublen;
    $string = strip_tags($string);
    $string = trim($string);
    $string = preg_replace("/\t/", "", $string);
    $string = preg_replace("/\r\n/", "", $string);
    $string = preg_replace("/\r/", "", $string);
    $string = preg_replace("/\n/", "", $string);
    $string = preg_replace("/ /", "", $string);
    if (mb_strlen(trim($string), 'utf-8') < 230) {
        return trim($string) . $ellipsis;
    } else {
        return mb_strcut(trim($string), 0, $sublength, $encoding) . $ellipsis;
    }
}

?>