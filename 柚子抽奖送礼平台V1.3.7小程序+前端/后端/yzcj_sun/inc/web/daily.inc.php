<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    $pageIndex = max(1, intval($_GPC['page']));
    $pageSize=10;
    $where="where a.uniacid=:uniacid ";
    $data[':uniacid']=$_W['uniacid'];
    // $list = pdo_getall('yzcj_sun_daily',array('uniacid'=>$_W['uniacid']),array() , '' , 'id ASC');
    $sql="SELECT a.*,b.`id` as gid,b.`gname` FROM ".tablename('yzcj_sun_daily'). " a"  . " left join " . tablename("yzcj_sun_gifts") . " b on b.id=a.gid ".$where." ORDER BY a.id asc";
    $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('yzcj_sun_daily'). " a" ." left join " . tablename("yzcj_sun_gifts") . " b on b.id=a.gid ".$where,$data);

    $select_sql =$sql." LIMIT " .($pageIndex - 1) * $pageSize.",".$pageSize;

    $list=pdo_fetchall($select_sql,$data);
    // p($list);
    $pager = pagination($total, $pageIndex, $pageSize);


} elseif ($operation == 'post') {
   $list = pdo_get('yzcj_sun_daily',array('id'=>$_GPC['id']));
        if(checksubmit('submit')){
           
            $data['gid']=$_GPC['gid'];
            $data['uniacid']=$_W['uniacid'];
            if($_GPC['id']==''){
                $res=pdo_insert('yzcj_sun_daily',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('daily',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzcj_sun_daily', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('daily',array()),'success');
                }else{
                message('编辑失败','','error');
                }
            }
        }
} elseif ($operation == 'delete') {
    $id=$_GPC['id'];
   
        $result = pdo_delete('yzcj_sun_daily', array('id'=>$id,'uniacid'=>$_W['uniacid']));
        if($result){
            message('删除成功',$this->createWebUrl('daily',array()),'success');
        }else{
            message('删除失败','','error');
        }
}
include $this->template('web/daily');