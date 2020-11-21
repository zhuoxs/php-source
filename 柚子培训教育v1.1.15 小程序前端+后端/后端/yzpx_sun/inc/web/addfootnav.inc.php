<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzpx_sun_footnav',array('id'=>$_GPC['id'],'uniacid' => $_W['uniacid']));

if(checksubmit('submit')){

    if( ($_GPC['icon_a']&&empty($_GPC['icon_a'])) || ($_GPC['icon_b']&&empty($_GPC['icon_b'])) ){
        message('请同时设置选中及未选中图标','','error');
    }

    $data['icon_a'] = $_GPC['icon_a'];
    $data['icon_b'] = $_GPC['icon_b'];
    $data['name'] = $_GPC['name'];
    $data['sort'] = $_GPC['sort'];
    $data['type'] = $_GPC['type'];

    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];

        $total=pdo_fetchcolumn("select count(*) from " . tablename("yzpx_sun_footnav") ." where uniacid =".$_W['uniacid']." and status = 1 ");
        if($total<5){
            $res=pdo_insert('yzpx_sun_footnav',$data);
            if($res){
                message('添加成功',$this->createWebUrl('footnav',array()),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            message('最多只能添加五个','','error');
        }

    }else{

        $res = pdo_update('yzpx_sun_footnav', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('footnav',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/addfootnav');