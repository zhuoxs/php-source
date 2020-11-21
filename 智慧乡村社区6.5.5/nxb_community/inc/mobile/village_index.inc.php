<?php
global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$all_net=$this->get_allnet(); 

$base=$this->get_base(); 
$title=$base['title'];
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

//获取当前用户的信息
$member=$this->getmember(); 

$meid=intval($_GPC['meid']);
$id=intval($_GPC['id']);

if($id!=0){
	//获取当前镇子的详情
	$town=pdo_fetch("SELECT * FROM ".tablename('bc_community_town')." WHERE id=:id",array(':id'=>$id));
}else{
	$isrz=$member['isrz'];
	if($isrz==1){
		$id=$member['menpai'];
		$town=pdo_fetch("SELECT * FROM ".tablename('bc_community_town')." WHERE id=:id",array(':id'=>$id));
	}else{
		message('抱歉！您还没有认证村民哦！',$this->createMobileUrl('register',array()),'error');
	}
	
}


if($_GPC['act'] == 'list_ajax'){
    $page = intval($_GPC['page']);
    $psize = 10;
    $start = ($page-1)*$psize;

    if($_GPC['menuid'] == 'all'){

    }else{
        $sql = " AND nmenu=".intval($_GPC['menuid']);
    }


    $postlist = pdo_fetchall("SELECT * FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND menpai=$id $sql ORDER BY nid DESC LIMIT $start,$psize", array(':uniacid' => $_W['uniacid']));
    foreach ($postlist as $item) {
        $html_reply = '';

        $item['member'] = pdo_fetch("SELECT * FROM " . tablename('bc_community_member') . " WHERE weid=:uniacid AND mid=".$item['mid'],array(':uniacid' => $_W['uniacid']));
        $item['menu'] = pdo_fetch("SELECT * FROM " . tablename('bc_community_menu') . " WHERE weid=:uniacid AND meid=".$item['nmenu'],array(':uniacid' => $_W['uniacid']));
        if($item['member']['isrz']){
            $html_rzcm = '(认证村民)';
        }else{
            $html_rzcm = '';
        }
        $item['nctime'] = tranTime($item['nctime']);  //发帖时间
        //回贴数
        $item['reply_number'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('bc_community_comment')." WHERE weid=".$_W['uniacid']." AND newsid = ".$item['nid']);
        if($item['reply_number'] > 0){
            //最新3条回复
            $html_reply = '<div class="item-reply">
                        <div class="item-reply-list">
                            <ul>';
            $replylist = pdo_fetchall("SELECT A.*,B.nickname,B.avatar FROM ".tablename('bc_community_comment')." A LEFT JOIN ".tablename('bc_community_member')." B ON A.mid=B.mid WHERE A.weid=".$_W['uniacid']." AND A.newsid=".$item['nid']." ORDER BY A.cctime DESC LIMIT 0,3");

            foreach ($replylist as $value){
                $html_reply .= '<li>
                                    <div class="pic">
                                        <img src="'.$value['avatar'].'" alt="">
                                        <span>'.$value['nickname'].'：</span>
                                    </div>
                                    <div class="commit">
                                        '.$value['comment'].'
                                    </div>
                                    <div class="time">
                                        '.tranTime($value['cctime']).'
                                    </div>
                                </li>';
            }

            $html_reply .= '</ul>
                        </div>
                        <div class="item-reply-more">
                            <p>还有'.$item['reply_number'].'条回复，<a href="javascript:;">点击查看 &gt;</a></p>
                        </div>
                    </div>';

        }



        echo '<div class="item" onclick="window.location.href=\''.$this->createMobileUrl('newsinfo',array('id'=>$item['nid'])).'\'">
                <div class="item-user-type">
                    <div class="item-user">
                        <div class="pic">
                            <img src="'.$item['member']['avatar'].'" alt="">
                        </div>
                        <div class="content">
                            <h3><span>'.$item['member']['nickname'].'</span><i>'.$html_rzcm.'</i></h3>
                            <p>'.$item['nctime'].'</p>
                        </div>
                    </div>
                    <div class="item-type">
                        <h3><span>'.$item['menu']['mtitle'].'</span></h3>
                        <ul>
                            <li><i class="icon icon-zan"></i>'.$item['browser'].'</li>
                            <li><i class="icon icon-msg"></i>'.$item['reply_number'].'</li>
                            <!--<li><i class="icon icon-heart"></i>280</li>-->
                        </ul>
                    </div>
                </div>
                <p class="item-commit">
                    <h3 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">'.$item['ntitle'].'</h3>
                    <p style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">'.$item['ntext'].'</p>
                    '.$html_reply.'
                </div>
                
          </div>';
    }
    exit;
}



$images=explode("|",$town['photo']);
//获取广告图片列表
$advlist=$images;
$num=count($advlist);
$num=$num-1;

$rd=$town['rd']+1;

//增加浏览量值
$newdata = array(
	'rd'=>$rd,	
);
$res = pdo_update('bc_community_town', $newdata,array('id'=>$id));



//获取导航列表
$menutoplist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=1 AND townid=:townid ORDER BY displayorder DESC,meid DESC",array(':uniacid'=>$_W['uniacid'],':townid'=>$id));
$menugroup = array();
$i = 0;
$k = 2;
$menugroup[0][0]['mtitle'] = '组织设置';
$menugroup[0][0]['mimg'] = 'myui/img/zzsz.png';
$menugroup[0][0]['murl'] = $this->createMobileUrl('organ',array())."&id=$id";
foreach ($menutoplist as $value){
    $menugroup[$i][] = $value;
    $k++;
    if($k>10){
        $i++;
        $k=1;
    }
}

$menuscolist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=2 AND townid=".$id." ORDER BY displayorder DESC,meid DESC",array(':uniacid'=>$_W['uniacid']));
//判断菜单长度
$menusco_width = 30+50;
foreach ($menuscolist as $value){
    $menusco_width += mb_strlen($value['mtitle'],'utf-8')*13+12+12;
}
//广告图片幻灯
$adslide = pdo_getall('bc_community_slide',array('weid'=>$_W['uniacid'],'type'=>2,'town_id'=>$id));




$hotpost = pdo_fetchall("SELECT * FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND menpai=" . $id . " AND nimg<>'' AND choice=1 ORDER BY browser DESC LIMIT 0,4", array(':uniacid' => $_W['uniacid']));


if(!empty($meid) && $meid!=0){
	

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND nmenu=".$meid." AND townid=:id ORDER BY nid DESC", array(':uniacid' => $_W['uniacid'],':id'=>$id));
	$count = ceil($total / $psize);
	include $this -> template('village_index');
	
}else{

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND townid=:id ORDER BY nid DESC", array(':uniacid' => $_W['uniacid'],':id'=>$id));
	$count = ceil($total / $psize);
	include $this -> template('village_index');
	
}




function tranTime($time)
{
    $rtime = date("m-d H:i",$time);
    $htime = date("H:i",$time);

    $time = time() - $time;

    if ($time < 60)
    {
        $str = '刚刚';
    }
    elseif ($time < 60 * 60)
    {
        $min = floor($time/60);
        $str = $min.'分钟前';
    }
    elseif ($time < 60 * 60 * 24)
    {
        $h = floor($time/(60*60));
        $str = $h.'小时前 '.$htime;
    }
    elseif ($time < 60 * 60 * 24 * 3)
    {
        $d = floor($time/(60*60*24));
        if($d==1)
            $str = '昨天 '.$htime;
        else
            $str = '前天 '.$htime;
    }
    else
    {
        $str = $rtime;
    }
    return $str;
}
?>