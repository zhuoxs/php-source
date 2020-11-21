<?php
global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$all_net = $this->get_allnet();

$base = $this->get_base();
$title = $base['title'];
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

//获取当前用户的信息
$member = $this->getmember();





if($_GPC['act'] == 'list_ajax'){
    $page = intval($_GPC['page']);
    $psize = 10;
    $start = ($page-1)*$psize;


    $townlist = pdo_fetchall("SELECT * FROM " . tablename('bc_community_town') . " WHERE weid=:uniacid AND lev=3 ORDER BY rd DESC,id DESC LIMIT $start,$psize", array(':uniacid' => $_W['uniacid']));
    foreach ($townlist as $item) {

        $item['isrz_number'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('bc_community_member')." WHERE weid=".$_W['uniacid']." AND isrz=1 AND menpai=".$item['id']);
        $item['notrz_number'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('bc_community_member')." WHERE weid=".$_W['uniacid']." AND isrz<>1 AND menpai=".$item['id']);

        echo '<div class="item">
      <a href="'.$this->createMobileUrl('village_index',array('id'=>$item['id'])).'">
        <div class="item-pic">
          <img src="'.tomedia($item['cover']).'" alt="" style="border-radius: 3px; height: 80px;">
        </div>
        <div class="item-content">
          <div class="item-title">
            <div class="title">
              <h3>'.$item['name'].'</h3><i class="icon icon-location"></i>
            </div>
            <div class="arrow">
              <i class="icon icon-right"></i>
            </div>
          </div>
          <div class="item-info">
            <div class="item-hot">
              <h3>'.$item['rd'].'</h3>
              <p>热度值</p>
            </div>
            <div class="item-authentication">
              <ul>
                <li>
                  <p class="btn">'.$item['isrz_number'].'</p>
                  <p class="name">认证村民</p>
                </li>
                <li>
                  <p class="btn">'.$item['notrz_number'].'</p>
                  <p class="name">关注人数</p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </a>
    </div>';
    }




    exit;
}









//获取广告图片列表
$advlist = pdo_fetchall("SELECT * FROM " . tablename('bc_community_adv') . " WHERE weid=:uniacid ORDER BY aid DESC LIMIT 5", array(':uniacid' => $_W['uniacid']));
$num = pdo_fetchcolumn("SELECT count(aid) FROM " . tablename('bc_community_adv') . " WHERE weid=" . $_W['uniacid']);
if ($num >= 5) {
    $num = 4;
} else {
    $num = $num - 1;
}

//获取导航列表
$menutoplist = pdo_fetchall("SELECT * FROM" . tablename('bc_community_menu') . "WHERE weid=:uniacid AND mtype=1 AND townid=0 ORDER BY displayorder DESC,meid DESC", array(':uniacid' => $_W['uniacid']));
$menugroup = array();
$i = 0;
$k = 1;
foreach ($menutoplist as $value){
    $menugroup[$i][] = $value;
    $k++;
    if($k>10){
        $i++;
        $k=1;
    }
}






//底部导航的焦点色处理
$ft = 1;
//获取本市所有镇级列表
$town = pdo_fetchall("SELECT * FROM " . tablename('bc_community_town') . " WHERE weid=:uniacid AND lev=2 ORDER BY paixu ASC,id DESC", array(':uniacid' => $_W['uniacid']));
$townnum = count($town);

//获取村庄热度表的列表
$ldtown = pdo_fetchall("SELECT * FROM " . tablename('bc_community_town') . " WHERE weid=:uniacid AND lev=3 ORDER BY rd DESC,id DESC", array(':uniacid' => $_W['uniacid']));


$count = 0;
$pindex = max(1, intval($_GPC['page']));
$psize = 6;
$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND nmenu=" . $meid . " ORDER BY nid DESC", array(':uniacid' => $_W['uniacid']));
$count = ceil($total / $psize);



include $this->template('index');


?>