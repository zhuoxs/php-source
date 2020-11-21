<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
//$sql="SELECT * FROM ".tablename('yzhyk_sun_story_active'). " a"  . " left join " . tablename("yzhyk_sun_in") . " b on b.type=a.time_type".$where." ORDER BY a.id DESC";
$sql="SELECT * FROM ".tablename('yzhyk_sun_story').$where." ORDER BY id DESC";
$total=pdo_fetchcolumn("select count(*) from " .tablename('yzhyk_sun_story').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
foreach($list as &$val) {
    $val['category_title'] = pdo_getcolumn('yzhyk_sun_story_category', array('uniacid' => $_W['uniacid'], 'id' => $val['category_id']), 'title', 1);
    if ($val['album_id'] == 0) {
        $val['album_title'] ='空';
    } else {
        $val['album_title'] = pdo_getcolumn('yzhyk_sun_story_album', array('uniacid' => $_W['uniacid'], 'id' => $val['album_id']), 'title', 1);
    }
}
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhyk_sun_story',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('story'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzhyk_sun_story',array('state'=>2,'tg_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('story'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhyk_sun_story',array('state'=>3,'jj_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('story'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/story');