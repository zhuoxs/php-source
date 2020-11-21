<?php

global $_GPC, $_W,$tag;
$GLOBALS['frames'] = $this->getMainMenu();

if($_GPC['op'] == 'checkshow'){
    $isshow = intval($_GPC['isshow']);
    $id = intval($_GPC['id']);
    $showdata = array('isshow' => $isshow);
    if ($_GPC['type'] == 'gowith') {
        // if($_W["is_gowith"]!=1){
        //     message('你关闭了审核设置，要审核需要开通结伴行审核开关！',$this->createWebUrl('movinglist',array('id' => $_GPC['id'],'type' => "gowith")),'error');
        //     exit;
        // }
        $res = pdo_update('fyly_sun_gowith',$showdata,array('id' => $id));
    } else{
        // if($_W["is_talent"]!=1){
        //     message('你关闭了审核设置，要审核需要开通达人圈审核开关！',$this->createWebUrl('movinglist',array('id' => $_GPC['id'],'type' => "expert")),'error');
        //     exit;
        // }
        $res = pdo_update('fyly_sun_expert',$showdata,array('id' => $id));
    }

    if($res){
        message('成功!  ', $this->createWebUrl('movinglist',array('id' => $_GPC['id'],'type' => $_GPC['type'])), 'success');
    }else{
        message('失败！',$this->createWebUrl('movinglist',array('id' => $_GPC['id'],'type' => $_GPC['type'])),'error');
    }
}

if ($_GPC['op'] == 'delete') {
    if ($_GPC['type'] == 'expert') {
        $res = pdo_delete('fyly_sun_expert', array('id' => $_GPC['id']));
    } elseif ($_GPC['type'] == 'gowith') {
        $res = pdo_delete('fyly_sun_gowith',array('id' => $_GPC['id']));
    }

    if ($res) {
        message('删除成功！', $this->createWebUrl('movinglist'), 'success');
    } else {
        message('删除失败！', '', 'error');
    }
}


$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

if ($_GPC['type'] == 'gowith') {
    $queryExpertSql = "SELECT * FROM ims_fyly_sun_gowith INNER JOIN (SELECT id AS uid,`name` AS user_name FROM ims_fyly_sun_user WHERE uniacid = " . $_W['uniacid'] . ") AS t1 ON user_id = t1.uid order by id desc";
    $total=pdo_fetchcolumn("SELECT count(*) as wname FROM ims_fyly_sun_gowith INNER JOIN (SELECT id AS uid,`name` AS user_name FROM ims_fyly_sun_user WHERE uniacid = " . $_W['uniacid'] . ") AS t1 ON user_id = t1.uid ",$data);
    $tag = 'gowith';
}else{
    $queryExpertSql = "SELECT * FROM ims_fyly_sun_expert INNER JOIN (SELECT id AS uid,`name` AS user_name FROM ims_fyly_sun_user WHERE uniacid = " . $_W['uniacid'] . ") AS t1 ON user_id = t1.uid order by id desc";
    $total=pdo_fetchcolumn("SELECT count(*) as wname FROM ims_fyly_sun_expert INNER JOIN (SELECT id AS uid,`name` AS user_name FROM ims_fyly_sun_user WHERE uniacid = " . $_W['uniacid'] . ") AS t1 ON user_id = t1.uid ",$data);
    $tag = 'expert';
}

$select_sql =$queryExpertSql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql);
foreach($list as $k => $v){
    if($v["img"]){
        $list[$k]["imgarr"] = explode(",",$v["img"]);
    }

}
$pager = pagination($total, $pageindex, $pagesize);

//封装打印格式化方法
function pr($obj)
{
    print_r("<pre>");
    print_r($obj);
}

include $this->template('web/movinglist');