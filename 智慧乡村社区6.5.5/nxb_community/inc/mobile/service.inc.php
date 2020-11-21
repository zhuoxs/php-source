<?php


global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$all_net = $this->get_allnet();

$base = $this->get_base();
$title = $base['title'] . ' - 更多服务';
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


$townid = intval($_GPC['town_id']);
$slide = pdo_fetchall("SELECT id,cover,url FROM " . tablename('bc_community_slide') . " WHERE weid=:uniacid AND type=1 AND town_id=".$townid." ORDER BY dateline DESC", array(':uniacid' => $_W['uniacid']));

$service = pdo_fetchall("SELECT * FROM " . tablename('bc_community_service') . " WHERE weid=:uniacid AND parent_id=0 AND town_id=".$townid." ORDER BY displayorder DESC,dateline DESC", array(':uniacid' => $_W['uniacid']));
foreach ($service as $key=>$value){
    $service[$key]['child'] = pdo_fetchall("SELECT * FROM " . tablename('bc_community_service') . " WHERE weid=:uniacid AND parent_id=".$value['sid']." AND town_id=".$townid." ORDER BY displayorder DESC,dateline DESC", array(':uniacid' => $_W['uniacid']));
}


$share_title = $title;
$share_desc = $title;
$share_url = $_W['siteurl'];
$share_img = tomedia($slide[0]['cover']);

include $this->template('service');
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