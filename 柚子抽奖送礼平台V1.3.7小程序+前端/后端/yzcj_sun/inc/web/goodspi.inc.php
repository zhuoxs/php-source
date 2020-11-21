<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    $pageIndex = max(1, intval($_GPC['page']));
    $pageSize=10;
    $where="where uniacid=:uniacid ";
    $data[':uniacid']=$_W['uniacid'];
    // $list = pdo_getall('yzcj_sun_goodspi',array('uniacid'=>$_W['uniacid']),array() , '' , 'id ASC');
    $sql="SELECT * FROM ".tablename('yzcj_sun_goodspi').$where." ORDER BY id asc";
    $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('yzcj_sun_goodspi').$where,$data);

    $select_sql =$sql." LIMIT " .($pageIndex - 1) * $pageSize.",".$pageSize;

    $list=pdo_fetchall($select_sql,$data);
    // p($list);
    $pager = pagination($total, $pageIndex, $pageSize);


} elseif ($operation == 'post') {
   $list = pdo_get('yzcj_sun_goodspi',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if(checksubmit('submit')){
           
            $data['name']=$_GPC['name'];
            $data['uniacid']=$_W['uniacid'];
            if($_GPC['id']==''){
                $res=pdo_insert('yzcj_sun_goodspi',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('goodspi',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzcj_sun_goodspi', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('goodspi',array()),'success');
                }else{
                message('编辑失败','','error');
                }
            }
        }
} elseif ($operation == 'delete') {
        $id=$_GPC['id'];
        $result = pdo_delete('yzcj_sun_goodspi', array('id'=>$id,'uniacid'=>$_W['uniacid']));
        if($result){
            message('删除成功',$this->createWebUrl('goodspi',array()),'success');
        }else{
            message('删除失败','','error');
        }
}
include $this->template('web/goodspi');